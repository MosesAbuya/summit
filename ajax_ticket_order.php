<?php
header('Content-Type: application/json');
require 'includes/db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    // Action: Validate Promo Code
    if ($action === 'validate_promo') {
        $code = trim($_POST['code'] ?? '');
        if (empty($code)) {
            echo json_encode(['valid' => false]);
            exit;
        }
        
        $stmt = $pdo->prepare("SELECT discount_usd, discount_kes FROM promo_codes WHERE code = ? AND is_active = 1");
        $stmt->execute([$code]);
        $promo = $stmt->fetch();
        
        if ($promo) {
            echo json_encode([
                'valid' => true,
                'discount_usd' => $promo['discount_usd'],
                'discount_kes' => $promo['discount_kes']
            ]);
        } else {
            echo json_encode(['valid' => false]);
        }
        exit;
    }

    // Action: Submit Order
    if ($action === 'submit_order') {
        // Collect personal details
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $organization = $_POST['organization'] ?? '';
        $jobTitle = $_POST['job_title'] ?? '';
        $studentIdNumber = trim($_POST['student_id_number'] ?? '');
        $studentInstitution = trim($_POST['student_institution'] ?? '');
        $country = $_POST['country'] ?? '';
        $dietary = $_POST['dietary_requirements'] ?? 'None';
        $accessibility = $_POST['accessibility_needs'] ?? '';
        $visaRequired = isset($_POST['visa_required']) && $_POST['visa_required'] == '1' ? 1 : 0;
        $passport = $_POST['passport_number'] ?? '';
        $emergName = $_POST['emergency_contact_name'] ?? '';
        $emergPhone = $_POST['emergency_contact_phone'] ?? '';
        
        $transactionCode = $_POST['transaction_code'] ?? '';
        $promoCode = $_POST['promo_code'] ?? '';
        $paymentMethod = $_POST['payment_method'] ?? 'paystack';

        if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($country)) {
            echo json_encode(['success' => false, 'message' => 'Missing required attendee details.']);
            exit;
        }

        $paymentStatus = 'pending';
        $paymentProofUrl = '';
        $studentIdProofUrl = '';
        
        // Handle Student ID card upload
        if (isset($_FILES['student_id_proof']) && $_FILES['student_id_proof']['error'] == UPLOAD_ERR_OK) {
            if ($_FILES['student_id_proof']['size'] > 5 * 1024 * 1024) {
                echo json_encode(['success' => false, 'message' => 'Student proof must be 5 MB or smaller.']);
                exit;
            }
            $allowedStudentTypes = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
            $studentMime = mime_content_type($_FILES['student_id_proof']['tmp_name']);
            if (!in_array($studentMime, $allowedStudentTypes, true)) {
                echo json_encode(['success' => false, 'message' => 'Student proof must be a JPG, PNG, WEBP, or PDF document.']);
                exit;
            }
            $studentUploadDir = 'uploads/student_ids/';
            if (!is_dir($studentUploadDir)) {
                mkdir($studentUploadDir, 0755, true);
            }
            $sFileName = time() . '_std_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($_FILES['student_id_proof']['name']));
            $sTargetPath = $studentUploadDir . $sFileName;
            if (move_uploaded_file($_FILES['student_id_proof']['tmp_name'], $sTargetPath)) {
                $studentIdProofUrl = $sTargetPath;
            }
        }
        
        // Handle manual payment file upload
        if ($paymentMethod === 'manual') {
            if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/receipts/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['payment_proof']['name']);
                $targetFilePath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $targetFilePath)) {
                    $paymentProofUrl = $targetFilePath;
                    $paymentStatus = 'proof_uploaded';
                }
            } else if (!empty($transactionCode)) {
                $paymentStatus = 'proof_uploaded';
            }
        }

        try {
            // Process Cart
            $qtyData = $_POST['qty'] ?? [];
            if (empty($qtyData) || !is_array($qtyData)) {
                echo json_encode(['success' => false, 'message' => 'Cart is empty.']);
                exit;
            }

            $orderRef = 'GPBS-' . strtoupper(substr(uniqid(), -6));
            
            $subtotalUsd = 0;
            $subtotalKes = 0;
            $orderItems = [];

            foreach ($qtyData as $pkgId => $qty) {
                $qty = (int)$qty;
                if ($qty > 0) {
                    $stmt = $pdo->prepare("SELECT * FROM ticket_packages WHERE id = ?");
                    $stmt->execute([$pkgId]);
                    $pkg = $stmt->fetch();
                    if (!$pkg) {
                        // Failsafe fallback for Final Call promo packages
                        if ($pkgId == 101 || (isset($_POST['pkg_name_' . $pkgId]) && strpos($_POST['pkg_name_' . $pkgId], 'Regular') !== false)) {
                            $pkg = ['id' => 101, 'name' => 'Final Call - Regular Delegate', 'price_usd' => 100.00, 'price_kes' => 10000.00];
                        } else if ($pkgId == 102 || (isset($_POST['pkg_name_' . $pkgId]) && strpos($_POST['pkg_name_' . $pkgId], 'Student') !== false)) {
                            $pkg = ['id' => 102, 'name' => 'Final Call - Student Pass', 'price_usd' => 50.00, 'price_kes' => 5000.00];
                        }
                    }
                    if ($pkg) {
                        $itemTotalUsd = $pkg['price_usd'] * $qty;
                        $itemTotalKes = $pkg['price_kes'] * $qty;
                        $subtotalUsd += $itemTotalUsd;
                        $subtotalKes += $itemTotalKes;
                        
                        $orderItems[] = [
                            'package_id' => $pkg['id'],
                            'package_name' => $pkg['name'],
                            'unit_price_usd' => $pkg['price_usd'],
                            'unit_price_kes' => $pkg['price_kes'],
                            'quantity' => $qty,
                            'subtotal_usd' => $itemTotalUsd,
                            'subtotal_kes' => $itemTotalKes
                        ];
                    }
                }
            }

            // Validate Student Pass Requirements
            $hasStudentPass = false;
            foreach ($orderItems as $item) {
                if (stripos($item['package_name'], 'student') !== false) {
                    $hasStudentPass = true;
                    break;
                }
            }
            
            if ($hasStudentPass) {
                $emailClean = strtolower(trim($email));
                $parts = explode('@', $emailClean);
                if (count($parts) !== 2) {
                    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
                    exit;
                }
                $domain = $parts[1];
                
                $freemail_domains = [
                    'gmail.com', 'googlemail.com', 'yahoo.com', 'yahoo.co.uk', 'yahoo.fr', 'yahoo.co.in',
                    'ymail.com', 'rocketmail.com', 'hotmail.com', 'hotmail.co.uk', 'outlook.com',
                    'outlook.co.uk', 'live.com', 'live.co.uk', 'msn.com', 'icloud.com', 'me.com',
                    'mac.com', 'aol.com', 'protonmail.com', 'proton.me', 'zoho.com', 'mail.com',
                    'gmx.com', 'gmx.net', 'yandex.com', 'yandex.ru', 'fastmail.com', 'inbox.com',
                    'qq.com', '163.com'
                ];
                
                $isFreemail = in_array($domain, $freemail_domains);
                $isAcademic = (
                    str_ends_with($domain, '.edu') || 
                    str_contains($domain, '.edu.') || 
                    str_ends_with($domain, '.ac.ke') || 
                    str_ends_with($domain, '.ac.ug') || 
                    str_ends_with($domain, '.ac.tz') || 
                    str_ends_with($domain, '.ac.rw') || 
                    str_ends_with($domain, '.ac.za') || 
                    str_ends_with($domain, '.ac.uk') || 
                    str_contains($domain, '.ac.')
                );
                
                if ($isFreemail || !$isAcademic) {
                    echo json_encode([
                        'success' => false, 
                        'message' => 'Student verification error: Personal email domains (Gmail, Yahoo, Outlook, etc.) are strictly not allowed for student passes. Please use your official university or student email (e.g. .edu or .ac.ke).'
                    ]);
                    exit;
                }
                
                if (empty($studentIdNumber) || empty($studentInstitution) || empty($studentIdProofUrl)) {
                    echo json_encode([
                        'success' => false, 
                        'message' => 'Student registration requires your institution, Student Registration / ID Number, and proof-of-enrollment or student ID document.'
                    ]);
                    exit;
                }
            }

            // Apply Promo Code Server Side
            $discountUsd = 0;
            $discountKes = 0;
            if (!empty($promoCode)) {
                $stmt = $pdo->prepare("SELECT discount_usd, discount_kes FROM promo_codes WHERE code = ? AND is_active = 1");
                $stmt->execute([$promoCode]);
                $promo = $stmt->fetch();
                if ($promo) {
                    $discountUsd = min($promo['discount_usd'], $subtotalUsd);
                    $discountKes = min($promo['discount_kes'], $subtotalKes);
                }
            }
            
            $totalUsd = $subtotalUsd - $discountUsd;
            $totalKes = $subtotalKes - $discountKes;

            $pdo->beginTransaction();
            
            $stmt = $pdo->prepare("INSERT INTO ticket_orders (order_ref, first_name, last_name, email, phone, organization, job_title, student_id_number, student_institution, country, dietary_requirements, accessibility_needs, visa_required, passport_number, emergency_contact_name, emergency_contact_phone, subtotal_usd, discount_usd, total_usd, subtotal_kes, discount_kes, total_kes, promo_code, payment_status, transaction_code, payment_proof_url, student_id_proof_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$orderRef, $firstName, $lastName, $email, $phone, $organization, $jobTitle, $studentIdNumber, $studentInstitution, $country, $dietary, $accessibility, $visaRequired, $passport, $emergName, $emergPhone, $subtotalUsd, $discountUsd, $totalUsd, $subtotalKes, $discountKes, $totalKes, $promoCode, $paymentStatus, $transactionCode, $paymentProofUrl, $studentIdProofUrl]);
            
            $orderId = $pdo->lastInsertId();

            $stmtItem = $pdo->prepare("INSERT INTO ticket_order_items (order_id, package_id, package_name, unit_price_usd, unit_price_kes, quantity, subtotal_usd, subtotal_kes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            
            $itemsHtml = '';
            foreach ($orderItems as $item) {
                $stmtItem->execute([$orderId, $item['package_id'], $item['package_name'], $item['unit_price_usd'], $item['unit_price_kes'], $item['quantity'], $item['subtotal_usd'], $item['subtotal_kes']]);
                
                $itemsHtml .= "<li>{$item['quantity']}x {$item['package_name']} - $" . number_format($item['subtotal_usd'], 2) . "</li>";
            }

            $pdo->commit();

            if ($paymentMethod === 'manual' && $totalKes > 0) {
                // Fetch settings
                $stmt_settings = $pdo->prepare("SELECT * FROM mailer_settings WHERE form_type = 'registration' LIMIT 1");
                $stmt_settings->execute();
                $settings = $stmt_settings->fetch();

                if ($settings && !empty($settings['smtp_host'])) {
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host       = $settings['smtp_host'];
                        $mail->SMTPAuth   = true;
                        $mail->Username   = $settings['smtp_user'];
                        $mail->Password   = $settings['smtp_pass'];
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port       = $settings['smtp_port'];

                        $mail->setFrom($settings['from_email'], $settings['from_name']);
                        $mail->addAddress($email, "$firstName $lastName");
                        $recipient = !empty($settings['company_email']) ? $settings['company_email'] : 'info@globalsummitafrica.org';
                        $mail->addReplyTo($recipient, $settings['from_name']);
                        $mail->isHTML(true);
                        $mail->Subject = "Order Confirmation & Payment Instructions - $orderRef";
                        
                        $uploadLink = "https://globalsummitafrica.org/upload_proof.php?ref=" . $orderRef;
                        
                        $studentEmailNotice = $hasStudentPass ? "<div style='background:#fff7ed;border:2px solid #fdba74;padding:18px;margin:20px 0;border-radius:8px;'><strong style='color:#9a3412;'>Student Ticket — Accreditation Required</strong><p style='color:#7c2d12;margin-bottom:0;'>Bring the original physical student ID matching your registration ID ({$studentIdNumber}) and proof-of-enrollment document to the venue accreditation desk.</p></div>" : '';
                        if ($paymentStatus === 'proof_uploaded') {
                            $emailContent = "
                                <p>Thank you for your ticket order (<strong>{$orderRef}</strong>).</p>
                                <p>We have successfully received your payment evidence for the amount of <strong>KES " . number_format($totalKes, 2) . "</strong> (or USD " . number_format($totalUsd, 2) . ").</p>
                                
                                <div style='background: #f8fafc; padding: 20px; border-left: 4px solid #166534; margin: 25px 0; border-radius: 0 4px 4px 0;'>
                                    <h4 style='margin-top: 0; margin-bottom: 12px; color: #0f172a; font-size: 16px;'>Next Steps:</h4>
                                    <p style='margin: 0; color: #475569;'>Our team is currently reviewing your payment evidence. Once verified, your official e-ticket will be issued.</p>
                                </div>
                                <p style='font-size: 0.9em; color: #64748b;'><em>Failsafe: If for any reason you need to re-upload your proof of payment or provide a different transaction code, you can do so here: <a href='{$uploadLink}' style='color: #c1440e;'>Upload Proof</a>. If you have already provided it successfully, please ignore this link.</em></p>
                                {$studentEmailNotice}
                            ";
                        } else {
                            $emailContent = "
                                <p>Thank you for your ticket order (<strong>{$orderRef}</strong>).</p>
                                <p>You selected Bank Transfer / Manual payment. Please make the payment of <strong>KES " . number_format($totalKes, 2) . "</strong> (or USD " . number_format($totalUsd, 2) . ") to our official bank account.</p>
                                
                                <div style='background: #f8fafc; padding: 20px; border-left: 4px solid #c1440e; margin: 25px 0; border-radius: 0 4px 4px 0;'>
                                    <h4 style='margin-top: 0; margin-bottom: 12px; color: #0f172a; font-size: 16px;'>Next Steps:</h4>
                                    <ol style='margin: 0; padding-left: 20px; color: #475569;'>
                                        <li style='margin-bottom: 8px;'>Make the transfer using <strong>{$orderRef}</strong> as the reference.</li>
                                        <li>Upload your proof of payment or transaction code here: <a href='{$uploadLink}'>Upload Proof</a></li>
                                    </ol>
                                </div>
                                <p>Once we verify the payment, your e-ticket will be issued.</p>
                                {$studentEmailNotice}
                            ";
                        }

                        $mail->Body = "
                        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);'>
                            <div style='background: #166534; padding: 25px; text-align: center; border-bottom: 4px solid #d4a017;'>
                                <h2 style='color: #ffffff; margin: 0; font-size: 22px; letter-spacing: 2px; text-transform: uppercase;'>Global Pro Bono Summit</h2>
                            </div>
                            <div style='padding: 35px; background: #ffffff; color: #334155; line-height: 1.6; font-size: 16px;'>
                                <h3 style='color: #0f172a; margin-top: 0; font-size: 20px;'>Dear {$firstName},</h3>
                                {$emailContent}
                                <p>Warm regards,<br><strong style='color: #166534;'>The Organizing Committee</strong><br>{$settings['from_name']}</p>
                            </div>
                        </div>";
                        $mail->send();
                    } catch (Exception $e) {
                        // ignore silently
                    }
                }
            }

            // Return data so frontend can initialize Paystack Inline if total > 0
            if ($totalKes > 0) {
                echo json_encode([
                    'success' => true,
                    'order_ref' => $orderRef,
                    'total_kes' => $totalKes,
                    'email' => $email,
                    'is_student' => $hasStudentPass
                ]);
            } else {
                // Free order (e.g. 100% discount promo code)
                $stmt = $pdo->prepare("UPDATE ticket_orders SET payment_status = 'confirmed' WHERE order_ref = ?");
                $stmt->execute([$orderRef]);
                echo json_encode(['success' => true, 'order_ref' => $orderRef, 'total_kes' => 0, 'is_student' => $hasStudentPass]);
            }
        } catch(PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            echo json_encode(['success' => false, 'message' => 'Database error occurred.']);
        }

    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    }
}
?>
