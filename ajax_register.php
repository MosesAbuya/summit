<?php
header('Content-Type: application/json');
require 'includes/db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = ['status' => 'error', 'message' => 'An unknown error occurred.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $regType = $_POST['registration_type'] ?? '';
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $organization = $_POST['organization'] ?? '';
    $country = $_POST['country'] ?? '';
    $passport = $_POST['passport'] ?? '';
    $dietary = $_POST['dietary_requirements'] ?? '';
    $accessibility = $_POST['accessibility_needs'] ?? '';
    $track = $_POST['track_alignment'] ?? '';
    $pledge = isset($_POST['pro_bono_pledge']) ? 1 : 0;

    if (empty($regType) || empty($firstName) || empty($lastName) || empty($email) || empty($organization) || empty($country) || empty($track)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    try {
        // 1. Save to DB
        $stmt = $pdo->prepare("INSERT INTO registrations (registration_type, first_name, last_name, email, phone, organization, country, passport, dietary_requirements, accessibility_needs, track_alignment, pro_bono_pledge) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$regType, $firstName, $lastName, $email, $phone, $organization, $country, $passport, $dietary, $accessibility, $track, $pledge]);

        // 2. Fetch Mailer Settings
        $stmt_settings = $pdo->prepare("SELECT * FROM mailer_settings WHERE form_type = 'registration' LIMIT 1");
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
                $recipient = !empty($settings['company_email']) ? $settings['company_email'] : 'registrations@jitoleegoodfriendsfoundation.org';
                $mail->addAddress($recipient);
                $mail->addReplyTo($email, "$firstName $lastName");
                $mail->isHTML(true);
                $mail->Subject = 'New Registration: ' . $firstName . ' ' . $lastName;
                $mail->Body    = "<h3>New Summit Registration</h3>
                                  <p><strong>Type:</strong> {$regType}</p>
                                  <p><strong>Name:</strong> {$firstName} {$lastName}</p>
                                  <p><strong>Email:</strong> {$email}</p>
                                  <p><strong>Organization:</strong> {$organization} ({$country})</p>
                                  <p><strong>Track:</strong> {$track}</p>
                                  <p><strong>Pledged 10k hours:</strong> " . ($pledge ? 'Yes' : 'No') . "</p>";
                $mail->send();

                // 2. Send Confirmation to User
                $mail->clearAllRecipients();
                $mail->clearReplyTos();
                $mail->addAddress($email, "$firstName $lastName");
                // Reply-To goes to company
                $mail->addReplyTo($recipient, $settings['from_name']);
                $mail->Subject = 'Registration Received - Global Pro Bono Summit';
                $mail->Body    = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);'>
                    <div style='background: #166534; padding: 25px; text-align: center; border-bottom: 4px solid #d4a017;'>
                        <h2 style='color: #ffffff; margin: 0; font-size: 22px; letter-spacing: 2px; text-transform: uppercase;'>Global Pro Bono Summit</h2>
                    </div>
                    <div style='padding: 35px; background: #ffffff; color: #334155; line-height: 1.6; font-size: 16px;'>
                        <h3 style='color: #0f172a; margin-top: 0; font-size: 20px;'>Dear {$firstName} {$lastName},</h3>
                        <p>Thank you for your interest in attending the Global Pro Bono Summit in Nairobi.</p>
                        <p>We have successfully received your application for: <strong>{$regType}</strong>.</p>
                        <p>Our team is currently reviewing your details. Once approved, you will receive further instructions and a secure link to finalize your pass.</p>
                        
                        <div style='background: #f8fafc; padding: 20px; border-left: 4px solid #c1440e; margin: 25px 0; border-radius: 0 4px 4px 0;'>
                            <h4 style='margin-top: 0; margin-bottom: 12px; color: #0f172a; font-size: 16px;'>Your Registration Details:</h4>
                            <ul style='margin: 0; padding-left: 20px; color: #475569;'>
                                <li style='margin-bottom: 5px;'><strong>Organization:</strong> {$organization}</li>
                                <li><strong>Thematic Track:</strong> {$track}</li>
                            </ul>
                        </div>
                        
                        <p>If you have any immediate questions, simply reply directly to this email.</p>
                        <br>
                        <p>Warm regards,<br><strong style='color: #166534;'>The Organizing Committee</strong><br>{$settings['from_name']}</p>
                    </div>
                    <div style='background: #0f172a; color: #94a3b8; text-align: center; padding: 20px; font-size: 12px;'>
                        &copy; " . date('Y') . " Global Pro Bono Summit. All rights reserved.<br>
                        Nairobi, Kenya
                    </div>
                </div>";
                $mail->send();

            } catch (Exception $e) {
                // Log mailer error but don't fail the whole submission
                error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
        }

        $response['status'] = 'success';
        $response['message'] = 'Registration successful! Check your email for further instructions.';
        
    } catch(PDOException $e) {
        $response['message'] = 'Database error occurred. Please try again later.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>
