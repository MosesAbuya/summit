<?php
header('Content-Type: application/json');
require 'includes/db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = ['status' => 'error', 'message' => 'An unknown error occurred.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty($fullName) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    try {
        // 1. Save to DB
        $stmt = $pdo->prepare("INSERT INTO enquiries (full_name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$fullName, $email, $subject, $message]);

        // 2. Fetch Mailer Settings
        $stmt_settings = $pdo->prepare("SELECT * FROM mailer_settings WHERE form_type = 'contact' LIMIT 1");
        $stmt_settings->execute();
        $settings = $stmt_settings->fetch();

        if ($settings && !empty($settings['smtp_host'])) {
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host       = $settings['smtp_host'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $settings['smtp_user'];
                $mail->Password   = $settings['smtp_pass'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = $settings['smtp_port'];

                //Recipients
                $mail->setFrom($settings['from_email'], $settings['from_name']);
                
                // 1. Send Notification to Company
                $mail->clearAllRecipients();
                $recipient = !empty($settings['company_email']) ? $settings['company_email'] : 'info@jitoleegoodfriendsfoundation.org';
                $mail->addAddress($recipient);
                $mail->addReplyTo($email, $fullName);
                $mail->isHTML(true);
                $mail->Subject = 'New Website Inquiry: ' . $subject;
                $mail->Body    = "<h3>New Inquiry Received</h3>
                                  <p><strong>Name:</strong> {$fullName}</p>
                                  <p><strong>Email:</strong> {$email}</p>
                                  <p><strong>Subject:</strong> {$subject}</p>
                                  <p><strong>Message:</strong><br/>" . nl2br(htmlspecialchars($message)) . "</p>";
                $mail->send();

                // 2. Send Confirmation/Auto-reply to User
                $mail->clearAllRecipients();
                $mail->clearReplyTos();
                $mail->addAddress($email, $fullName);
                // Reply-To goes to company
                $mail->addReplyTo($recipient, $settings['from_name']);
                $mail->Subject = 'Thank you for your inquiry: ' . $subject;
                $mail->Body    = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);'>
                    <div style='background: #166534; padding: 25px; text-align: center; border-bottom: 4px solid #d4a017;'>
                        <h2 style='color: #ffffff; margin: 0; font-size: 22px; letter-spacing: 2px; text-transform: uppercase;'>Global Pro Bono Summit</h2>
                    </div>
                    <div style='padding: 35px; background: #ffffff; color: #334155; line-height: 1.6; font-size: 16px;'>
                        <h3 style='color: #0f172a; margin-top: 0; font-size: 20px;'>Dear {$fullName},</h3>
                        <p>Thank you for reaching out to us regarding <strong>{$subject}</strong>.</p>
                        <p>We have successfully received your message. Our concierge team will review your enquiry and reply within 24 hours.</p>
                        
                        <div style='background: #f8fafc; padding: 20px; border-left: 4px solid #c1440e; margin: 25px 0; border-radius: 0 4px 4px 0;'>
                            <strong style='color: #0f172a;'>Your Message:</strong><br/><br/>
                            <div style='color: #475569; font-style: italic;'>" . nl2br(htmlspecialchars($message)) . "</div>
                        </div>
                        
                        <p>Best regards,<br><strong style='color: #166534;'>{$settings['from_name']}</strong></p>
                    </div>
                    <div style='background: #0f172a; color: #94a3b8; text-align: center; padding: 20px; font-size: 12px;'>
                        &copy; " . date('Y') . " Global Pro Bono Summit. All rights reserved.<br>
                        Nairobi, Kenya
                    </div>
                </div>";
                $mail->send();

            } catch (Exception $e) {
                // Log mailer error but don't fail the whole submission since DB save worked
                error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
        }

        $response['status'] = 'success';
        $response['message'] = 'Your inquiry has been sent successfully. We will get back to you shortly.';
        
    } catch(PDOException $e) {
        $response['message'] = 'Database error occurred. Please try again later.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>
