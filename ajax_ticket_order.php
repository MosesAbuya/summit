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
        $paymentMethod = $_POST['payment_method'] ?? 'paystack';

        if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($country)) {
            echo json_encode(['success' => false, 'message' => 'Missing required attendee details.']);
            exit;
        }

        $paymentStatus = 'pending';
        $paymentProofUrl = '';
        
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
            $stmt->execute([$orderRef, $firstName, $lastName, $email, $phone, $organization, $jobTitle, $country, $dietary, $accessibility, $visaRequired, $passport, $emergName, $emergPhone, $subtotalUsd, $discountUsd, $totalUsd, $subtotalKes, $discountKes, $totalKes, $promoCode, $paymentStatus, $transactionCode, $paymentProofUrl]);
            
            $orderId = $pdo->lastInsertId();

            $stmtItem = $pdo->prepare("INSERT INTO ticket_order_items (order_id, package_id, package_name, unit_price_usd, unit_price_kes, quantity, subtotal_usd, subtotal_kes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            
            $itemsHtml = '';
            foreach ($orderItems as $item) {
                $stmtItem->execute([$orderId, $item['package_id'], $item['package_name'], $item['unit_price_usd'], $item['unit_price_kes'], $item['quantity'], $item['subtotal_usd'], $item['subtotal_kes']]);
                
                $itemsHtml .= "<li>{$item['quantity']}x {$item['package_name']} - $" . number_format($item['subtotal_usd'], 2) . "</li>";
            }

            $pdo->commit();

            // Return data so frontend can initialize Paystack Inline if total > 0
            if ($totalKes > 0) {
                echo json_encode([
                    'success' => true,
                    'order_ref' => $orderRef,
                    'total_kes' => $totalKes,
                    'email' => $email
                ]);
            } else {
                // Free order (e.g. 100% discount promo code)
                $stmt = $pdo->prepare("UPDATE ticket_orders SET payment_status = 'confirmed' WHERE order_ref = ?");
                $stmt->execute([$orderRef]);
                echo json_encode(['success' => true, 'order_ref' => $orderRef, 'total_kes' => 0]);
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
