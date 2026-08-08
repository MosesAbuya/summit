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
        $country = $_POST['country'] ?? '';
        $dietary = $_POST['dietary_requirements'] ?? 'None';
        $accessibility = $_POST['accessibility_needs'] ?? '';
        $visaRequired = isset($_POST['visa_required']) && $_POST['visa_required'] == '1' ? 1 : 0;
        $passport = $_POST['passport_number'] ?? '';
        $emergName = $_POST['emergency_contact_name'] ?? '';
        $emergPhone = $_POST['emergency_contact_phone'] ?? '';
        
        $transactionCode = $_POST['transaction_code'] ?? '';
        $promoCode = $_POST['promo_code'] ?? '';

        if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($country)) {
            echo json_encode(['success' => false, 'message' => 'Missing required attendee details.']);
            exit;
        }

        // Handle file upload
        $proofUrl = '';
        if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/proofs/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.-]/", "_", basename($_FILES['payment_proof']['name']));
            $target = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $target)) {
                $proofUrl = $target;
            }
        }
        
        $paymentStatus = ($proofUrl || $transactionCode) ? 'proof_uploaded' : 'pending';

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
            
            $stmt = $pdo->prepare("INSERT INTO ticket_orders (order_ref, first_name, last_name, email, phone, organization, job_title, country, dietary_requirements, accessibility_needs, visa_required, passport_number, emergency_contact_name, emergency_contact_phone, subtotal_usd, discount_usd, total_usd, subtotal_kes, discount_kes, total_kes, promo_code, payment_status, transaction_code, payment_proof_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$orderRef, $firstName, $lastName, $email, $phone, $organization, $jobTitle, $country, $dietary, $accessibility, $visaRequired, $passport, $emergName, $emergPhone, $subtotalUsd, $discountUsd, $totalUsd, $subtotalKes, $discountKes, $totalKes, $promoCode, $paymentStatus, $transactionCode, $proofUrl]);
            
            $orderId = $pdo->lastInsertId();

            $stmtItem = $pdo->prepare("INSERT INTO ticket_order_items (order_id, package_id, package_name, unit_price_usd, unit_price_kes, quantity, subtotal_usd, subtotal_kes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            
            $itemsHtml = '';
            foreach ($orderItems as $item) {
                $stmtItem->execute([$orderId, $item['package_id'], $item['package_name'], $item['unit_price_usd'], $item['unit_price_kes'], $item['quantity'], $item['subtotal_usd'], $item['subtotal_kes']]);
                
                $itemsHtml .= "<li>{$item['quantity']}x {$item['package_name']} - $" . number_format($item['subtotal_usd'], 2) . "</li>";
            }

            $pdo->commit();

            // SEND EMAILS
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
                    
                    // 1. Admin Notification
                    $recipient = !empty($settings['company_email']) ? $settings['company_email'] : 'registrations@jitoleegoodfriendsfoundation.org';
                    $mail->addAddress($recipient);
                    $mail->addReplyTo($email, "$firstName $lastName");
                    $mail->isHTML(true);
                    $mail->Subject = 'New Ticket Order: ' . $orderRef;
                    $mail->Body    = "<h3>New Ticket Order ({$orderRef})</h3>
                                      <p><strong>Name:</strong> {$firstName} {$lastName}</p>
                                      <p><strong>Email:</strong> {$email}</p>
                                      <p><strong>Total:</strong> $" . number_format($totalUsd, 2) . "</p>
                                      <p><strong>Status:</strong> {$paymentStatus}</p>";
                    $mail->send();

                    // 2. Delegate Notification (Reviewing / Reserved)
                    $mail->clearAllRecipients();
                    $mail->clearReplyTos();
                    $mail->addAddress($email, "$firstName $lastName");
                    $mail->addReplyTo($recipient, $settings['from_name']);
                    
                    $uploadLink = "http://" . $_SERVER['HTTP_HOST'] . str_replace("ajax_ticket_order.php", "upload_proof.php?ref=" . $orderRef, $_SERVER['REQUEST_URI']);

                    $mail->Subject = 'Your Tickets are Reserved! - Global Pro Bono Summit';
                    $mail->Body    = "
                    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;'>
                        <div style='background: #166534; padding: 25px; text-align: center; border-bottom: 4px solid #d4a017;'>
                            <h2 style='color: #ffffff; margin: 0; font-size: 22px;'>Global Pro Bono Summit</h2>
                        </div>
                        <div style='padding: 35px; background: #ffffff; color: #334155; line-height: 1.6; font-size: 16px;'>
                            <h3>Dear {$firstName},</h3>
                            <p>Thank you for booking your tickets. Your order <strong>{$orderRef}</strong> has been received and the tickets are currently reserved.</p>
                            
                            <div style='background: #f8fafc; padding: 15px; border-radius: 4px; border: 1px solid #e2e8f0; margin-bottom: 20px;'>
                                <h4 style='margin-top: 0;'>Order Summary</h4>
                                <ul style='margin-bottom: 10px; padding-left: 20px;'>
                                    {$itemsHtml}
                                </ul>
                                <strong>Total Due: $" . number_format($totalUsd, 2) . " / KES " . number_format($totalKes, 2) . "</strong>
                            </div>

                            <div style='background: #eef2ff; border-left: 4px solid #4f46e5; padding: 15px; margin-bottom: 20px;'>
                                <strong>Payment Verification Options:</strong>
                                <p style='margin-bottom: 0;'>If you have already uploaded your payment proof during checkout, no further action is needed! If you skipped the upload step because you needed time to make the bank transfer, please use the details below to complete your payment, and then click the button to upload your screenshot.</p>
                            </div>
                            
                            <div style='background: #f1f5f9; border-left: 4px solid #166534; padding: 15px; margin-bottom: 20px;'>
                                <ul style='list-style: none; padding: 0; margin: 0;'>
                                    <li><strong>Bank:</strong> KCB Bank Kenya Ltd</li>
                                    <li><strong>Account Title:</strong> JITOLEE GOOD FRIENDS</li>
                                    <li><strong>Account Number:</strong> 1325956678 (KES)</li>
                                    <li><strong>Payment Reference:</strong> {$orderRef}</li>
                                </ul>
                            </div>
                            
                            <p style='text-align: center;'>
                                <a href='{$uploadLink}' style='background: #166534; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block;'>Upload Proof of Payment</a>
                            </p>
                            
                            <p>Once we verify your payment, we will send your final e-tickets!</p>
                            <br>
                            <p>Warm regards,<br><strong>The Organizing Committee</strong></p>
                        </div>
                    </div>";
                    $mail->send();

                } catch (Exception $e) {
                    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                }
            }

            echo json_encode(['success' => true, 'order_ref' => $orderRef]);
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
