<?php
header('Content-Type: application/json');
require 'includes/db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$reference = $_POST['reference'] ?? '';

if (empty($reference)) {
    echo json_encode(['success' => false, 'message' => 'No transaction reference provided.']);
    exit;
}

$paystackSecretKey = 'sk_test_0a76085eeda2c3f51c5c3dd7f4027c9328737be3';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transaction/verify/" . rawurlencode($reference));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $paystackSecretKey
]);
$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if ($result && $result['status'] === true && $result['data']['status'] === 'success') {
    
    // Fetch order from DB
    $stmt = $pdo->prepare("SELECT * FROM ticket_orders WHERE order_ref = ?");
    $stmt->execute([$reference]);
    $order = $stmt->fetch();
    
    if ($order) {
        if ($order['payment_status'] !== 'confirmed') {
            // Update order status
            $updateStmt = $pdo->prepare("UPDATE ticket_orders SET payment_status = 'confirmed', payment_confirmed_at = NOW(), transaction_code = ? WHERE order_ref = ?");
            $updateStmt->execute([$result['data']['id'], $reference]);
            
            // Get order items for email
            $stmtItems = $pdo->prepare("SELECT * FROM ticket_order_items WHERE order_id = ?");
            $stmtItems->execute([$order['id']]);
            $items = $stmtItems->fetchAll();
            $itemsHtml = '';
            foreach ($items as $item) {
                $itemsHtml .= "<li>{$item['quantity']}x {$item['package_name']} - $" . number_format($item['subtotal_usd'], 2) . "</li>";
            }

            // Send Confirmation Emails
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
                    
                    $firstName = $order['first_name'];
                    $lastName = $order['last_name'];
                    $email = $order['email'];
                    
                    // 1. Admin Notification
                    $recipient = !empty($settings['company_email']) ? $settings['company_email'] : 'registrations@jitoleegoodfriendsfoundation.org';
                    $mail->addAddress($recipient);
                    $mail->addReplyTo($email, "$firstName $lastName");
                    $mail->isHTML(true);
                    $mail->Subject = 'Payment Confirmed: ' . $reference;
                    $mail->Body    = "<h3>Order Payment Confirmed ({$reference})</h3>
                                      <p><strong>Name:</strong> {$firstName} {$lastName}</p>
                                      <p><strong>Email:</strong> {$email}</p>
                                      <p><strong>Total:</strong> $" . number_format($order['total_usd'], 2) . "</p>
                                      <p><strong>Status:</strong> Confirmed (Paystack ID: {$result['data']['id']})</p>";
                    $mail->send();

                    // 2. Delegate Notification (Confirmed)
                    $mail->clearAllRecipients();
                    $mail->clearReplyTos();
                    $mail->addAddress($email, "$firstName $lastName");
                    $mail->addReplyTo($recipient, $settings['from_name']);

                    $mail->Subject = 'Payment Confirmed! Your E-Tickets - Global Pro Bono Summit';
                    $mail->Body    = "
                    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;'>
                        <div style='background: #166534; padding: 25px; text-align: center; border-bottom: 4px solid #d4a017;'>
                            <h2 style='color: #ffffff; margin: 0; font-size: 22px;'>Global Pro Bono Summit</h2>
                        </div>
                        <div style='padding: 35px; background: #ffffff; color: #334155; line-height: 1.6; font-size: 16px;'>
                            <h3>Dear {$firstName},</h3>
                            <p>Thank you for your payment. Your order <strong>{$reference}</strong> has been successfully confirmed!</p>
                            
                            <div style='background: #f8fafc; padding: 15px; border-radius: 4px; border: 1px solid #e2e8f0; margin-bottom: 20px;'>
                                <h4 style='margin-top: 0;'>Order Summary</h4>
                                <ul style='margin-bottom: 10px; padding-left: 20px;'>
                                    {$itemsHtml}
                                </ul>
                                <strong>Total Paid: $" . number_format($order['total_usd'], 2) . " / KES " . number_format($order['total_kes'], 2) . "</strong>
                            </div>

                            <div style='background: #dcfce7; border-left: 4px solid #16a34a; padding: 15px; margin-bottom: 20px;'>
                                <strong>Your Registration is Complete!</strong>
                                <p style='margin-bottom: 0;'>We look forward to seeing you at the summit. Please keep this email for your records.</p>
                            </div>
                            
                            <p>Warm regards,<br><strong>The Organizing Committee</strong></p>
                        </div>
                    </div>";
                    $mail->send();

                } catch (Exception $e) {
                    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                }
            }
        }
        
        echo json_encode(['success' => true, 'message' => 'Payment verified successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Payment verified, but order reference not found in database.']);
    }
} else {
    $errorMessage = $result['data']['gateway_response'] ?? 'Transaction was not successful.';
    echo json_encode(['success' => false, 'message' => $errorMessage]);
}
?>
