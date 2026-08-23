<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require '../includes/db.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$action = $_POST['action'];

// Helper for file uploads
function handleFileUpload($fileInputName, $uploadDir = '../assets/uploads/') {
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.-]/", "_", basename($_FILES[$fileInputName]['name']));
        $target = $uploadDir . $filename;
        if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $target)) {
            // Return path relative to document root
            return ltrim(str_replace('../', '', $uploadDir), '/') . $filename;
        }
    }
    return '';
}

try {
    if ($action === 'save_mailer_settings') {
        $form_type = $_POST['form_type'];
        $company_email = $_POST['company_email'];
        $smtp_host = $_POST['smtp_host'];
        $smtp_port = (int)$_POST['smtp_port'];
        $smtp_user = $_POST['smtp_user'];
        $smtp_pass = !empty($_POST['smtp_pass']) ? $_POST['smtp_pass'] : null;
        $from_email = $_POST['from_email'];
        $from_name = $_POST['from_name'];
        
        $stmt = $pdo->prepare("
            INSERT INTO mailer_settings (form_type, company_email, smtp_host, smtp_port, smtp_user, smtp_pass, from_email, from_name) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE 
                company_email=VALUES(company_email), 
                smtp_host=VALUES(smtp_host), 
                smtp_port=VALUES(smtp_port), 
                smtp_user=VALUES(smtp_user), 
                smtp_pass=COALESCE(VALUES(smtp_pass), mailer_settings.smtp_pass), 
                from_email=VALUES(from_email), 
                from_name=VALUES(from_name)
        ");
        $stmt->execute([$form_type, $company_email, $smtp_host, $smtp_port, $smtp_user, $smtp_pass, $from_email, $from_name]);
        echo json_encode(['success' => true, 'message' => "Mailer settings for " . ucfirst($form_type) . " updated successfully!"]);
        exit;
    }
    
    if ($action === 'save_settings') {
        $pub = $_POST['paystack_public_key'] ?? '';
        $sec = $_POST['paystack_secret_key'] ?? '';
        
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)");
        $stmt->execute(['paystack_public_key', $pub]);
        $stmt->execute(['paystack_secret_key', $sec]);
        
        echo json_encode(['success' => true, 'message' => "Settings updated successfully!"]);
        exit;
    }
    
    if ($action === 'add_news') {
        $title = $_POST['title'];
        $excerpt = $_POST['excerpt'];
        $content = $_POST['content'];
        $image_url = handleFileUpload('image_file', '../assets/news/');
        
        $stmt = $pdo->prepare("INSERT INTO news (title, excerpt, content, image_url) VALUES (?, ?, ?, ?)");
        if($stmt->execute([$title, $excerpt, $content, $image_url])) {
            $id = $pdo->lastInsertId();
            $stmt_fetch = $pdo->prepare("SELECT * FROM news WHERE id = ?");
            $stmt_fetch->execute([$id]);
            $record = $stmt_fetch->fetch(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'message' => "News article published successfully!", 'data' => $record]);
        } else {
            echo json_encode(['success' => false, 'message' => "Failed to publish news."]);
        }
        exit;
    }

    
    if ($action === 'edit_news') {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $excerpt = $_POST['excerpt'];
        $content = $_POST['content'];
        $image_url = handleFileUpload('image_file', '../assets/news/');
        
        if ($image_url) {
            $stmt = $pdo->prepare("UPDATE news SET title=?, excerpt=?, content=?, image_url=? WHERE id=?");
            $stmt->execute([$title, $excerpt, $content, $image_url, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE news SET title=?, excerpt=?, content=? WHERE id=?");
            $stmt->execute([$title, $excerpt, $content, $id]);
        }
        echo json_encode(['success' => true, 'message' => "News article updated successfully!"]);
        exit;
    }

    if ($action === 'delete_news') {
        $id = $_POST['news_id'];
        $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => "News article deleted."]);
        exit;
    }
    
    if ($action === 'add_partner') {
        $image_url = handleFileUpload('image_file', '../assets/partners/');
        $is_major = isset($_POST['is_major']) && $_POST['is_major'] === '1' ? 1 : 0;
        $stmt = $pdo->prepare("INSERT INTO partners (name, description, image_url, is_major) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['description'], $image_url, $is_major]);
        
        $id = $pdo->lastInsertId();
        $stmt_fetch = $pdo->prepare("SELECT * FROM partners WHERE id = ?");
        $stmt_fetch->execute([$id]);
        $record = $stmt_fetch->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'message' => "Partner added successfully!", 'data' => $record]);
        exit;
    }
    
    if ($action === 'edit_partner') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $is_major = isset($_POST['is_major']) && $_POST['is_major'] === '1' ? 1 : 0;
        $image_url = handleFileUpload('image_file', '../assets/partners/');
        
        if ($image_url) {
            $stmt = $pdo->prepare("UPDATE partners SET name=?, description=?, is_major=?, image_url=? WHERE id=?");
            $stmt->execute([$name, $description, $is_major, $image_url, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE partners SET name=?, description=?, is_major=? WHERE id=?");
            $stmt->execute([$name, $description, $is_major, $id]);
        }
        echo json_encode(['success' => true, 'message' => "Partner updated successfully!"]);
        exit;
    }

    if ($action === 'delete_partner') {
        $stmt = $pdo->prepare("DELETE FROM partners WHERE id = ?");
        $stmt->execute([$_POST['partner_id']]);
        echo json_encode(['success' => true, 'message' => "Partner deleted."]);
        exit;
    }

    if ($action === 'add_speaker') {
        $image_url = handleFileUpload('image_file', '../assets/speakers/');
        $is_keynote = isset($_POST['is_keynote']) && $_POST['is_keynote'] === '1' ? 1 : 0;
        $stmt = $pdo->prepare("INSERT INTO speakers (name, title, bio, image_url, is_keynote, video_url, theme) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['title'], $_POST['bio'], $image_url, $is_keynote, $_POST['video_url'], $_POST['theme']]);
        
        $id = $pdo->lastInsertId();
        $stmt_fetch = $pdo->prepare("SELECT * FROM speakers WHERE id = ?");
        $stmt_fetch->execute([$id]);
        $record = $stmt_fetch->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'message' => "Speaker added successfully!", 'data' => $record]);
        exit;
    }
    
    if ($action === 'edit_speaker') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $title = $_POST['title'];
        $bio = $_POST['bio'];
        $video_url = $_POST['video_url'];
        $theme = $_POST['theme'];
        $is_keynote = isset($_POST['is_keynote']) && $_POST['is_keynote'] === '1' ? 1 : 0;
        $image_url = handleFileUpload('image_file', '../assets/speakers/');
        
        if ($image_url) {
            $stmt = $pdo->prepare("UPDATE speakers SET name=?, title=?, bio=?, video_url=?, theme=?, is_keynote=?, image_url=? WHERE id=?");
            $stmt->execute([$name, $title, $bio, $video_url, $theme, $is_keynote, $image_url, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE speakers SET name=?, title=?, bio=?, video_url=?, theme=?, is_keynote=? WHERE id=?");
            $stmt->execute([$name, $title, $bio, $video_url, $theme, $is_keynote, $id]);
        }
        echo json_encode(['success' => true, 'message' => "Speaker updated successfully!"]);
        exit;
    }

    if ($action === 'delete_speaker') {
        $stmt = $pdo->prepare("DELETE FROM speakers WHERE id = ?");
        $stmt->execute([$_POST['speaker_id']]);
        echo json_encode(['success' => true, 'message' => "Speaker deleted."]);
        exit;
    }

    if ($action === 'add_accommodation') {
        $image_url = handleFileUpload('image_file', '../assets/accommodations/');
        $stmt = $pdo->prepare("INSERT INTO accommodations (hotel_name, description, booking_link, image_url) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['hotel_name'], $_POST['description'], $_POST['booking_link'], $image_url]);
        
        $id = $pdo->lastInsertId();
        $stmt_fetch = $pdo->prepare("SELECT * FROM accommodations WHERE id = ?");
        $stmt_fetch->execute([$id]);
        $record = $stmt_fetch->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'message' => "Accommodation added successfully!", 'data' => $record]);
        exit;
    }
    
    if ($action === 'edit_accommodation') {
        $id = $_POST['id'];
        $hotel_name = $_POST['hotel_name'];
        $description = $_POST['description'];
        $booking_link = $_POST['booking_link'];
        $image_url = handleFileUpload('image_file', '../assets/accommodations/');
        
        if ($image_url) {
            $stmt = $pdo->prepare("UPDATE accommodations SET hotel_name=?, description=?, booking_link=?, image_url=? WHERE id=?");
            $stmt->execute([$hotel_name, $description, $booking_link, $image_url, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE accommodations SET hotel_name=?, description=?, booking_link=? WHERE id=?");
            $stmt->execute([$hotel_name, $description, $booking_link, $id]);
        }
        echo json_encode(['success' => true, 'message' => "Accommodation updated successfully!"]);
        exit;
    }

    if ($action === 'delete_accommodation') {
        $stmt = $pdo->prepare("DELETE FROM accommodations WHERE id = ?");
        $stmt->execute([$_POST['accommodation_id']]);
        echo json_encode(['success' => true, 'message' => "Accommodation deleted."]);
        exit;
    }

    if ($action === 'add_resource') {
        $file_url = handleFileUpload('resource_file', '../assets/resources/');
        $stmt = $pdo->prepare("INSERT INTO resources (title, description, file_url, category, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['description'], $file_url, $_POST['category'], $_POST['status']]);
        
        $id = $pdo->lastInsertId();
        $stmt_fetch = $pdo->prepare("SELECT * FROM resources WHERE id = ?");
        $stmt_fetch->execute([$id]);
        $record = $stmt_fetch->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'message' => "Resource added successfully!", 'data' => $record]);
        exit;
    }
    
    if ($action === 'edit_resource') {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $status = $_POST['status'];
        $file_url = handleFileUpload('resource_file', '../assets/resources/');
        
        if ($file_url) {
            $stmt = $pdo->prepare("UPDATE resources SET title=?, description=?, category=?, status=?, file_url=? WHERE id=?");
            $stmt->execute([$title, $description, $category, $status, $file_url, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE resources SET title=?, description=?, category=?, status=? WHERE id=?");
            $stmt->execute([$title, $description, $category, $status, $id]);
        }
        echo json_encode(['success' => true, 'message' => "Resource updated successfully!"]);
        exit;
    }

    if ($action === 'delete_resource') {
        $stmt = $pdo->prepare("DELETE FROM resources WHERE id = ?");
        $stmt->execute([$_POST['resource_id']]);
        echo json_encode(['success' => true, 'message' => "Resource deleted."]);
        exit;
    }
    
    // Ticketing API Endpoints
    if ($action === 'save_package') {
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price_usd = $_POST['price_usd'];
        $price_kes = $_POST['price_kes'];
        $sort_order = $_POST['sort_order'];
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        if ($id) {
            $stmt = $pdo->prepare("UPDATE ticket_packages SET name=?, description=?, price_usd=?, price_kes=?, sort_order=?, is_active=? WHERE id=?");
            $stmt->execute([$name, $description, $price_usd, $price_kes, $sort_order, $is_active, $id]);
            echo json_encode(['success' => true, 'message' => "Package updated successfully!"]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO ticket_packages (name, description, price_usd, price_kes, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $description, $price_usd, $price_kes, $sort_order, $is_active]);
            echo json_encode(['success' => true, 'message' => "Package added successfully!"]);
        }
        exit;
    }
    
    if ($action === 'delete_package') {
        $stmt = $pdo->prepare("DELETE FROM ticket_packages WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        echo json_encode(['success' => true, 'message' => "Package deleted."]);
        exit;
    }
    
    if ($action === 'save_promo') {
        $id = $_POST['id'] ?? '';
        $code = strtoupper($_POST['code']);
        $discount_usd = $_POST['discount_usd'];
        $discount_kes = $_POST['discount_kes'];
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        if ($id) {
            $stmt = $pdo->prepare("UPDATE promo_codes SET code=?, discount_usd=?, discount_kes=?, is_active=? WHERE id=?");
            $stmt->execute([$code, $discount_usd, $discount_kes, $is_active, $id]);
            echo json_encode(['success' => true, 'message' => "Promo updated successfully!"]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO promo_codes (code, discount_usd, discount_kes, is_active) VALUES (?, ?, ?, ?)");
            $stmt->execute([$code, $discount_usd, $discount_kes, $is_active]);
            echo json_encode(['success' => true, 'message' => "Promo added successfully!"]);
        }
        exit;
    }
    
    if ($action === 'delete_promo') {
        $stmt = $pdo->prepare("DELETE FROM promo_codes WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        echo json_encode(['success' => true, 'message' => "Promo deleted."]);
        exit;
    }

    if ($action === 'confirm_order') {
        $id = $_POST['id'];
        
        $stmt = $pdo->prepare("SELECT * FROM ticket_orders WHERE id = ?");
        $stmt->execute([$id]);
        $order = $stmt->fetch();
        
        if (!$order) {
            echo json_encode(['success' => false, 'message' => "Order not found."]);
            exit;
        }
        
        $stmtUpdate = $pdo->prepare("UPDATE ticket_orders SET payment_status = 'confirmed', payment_confirmed_at = NOW() WHERE id = ?");
        $stmtUpdate->execute([$id]);
        
        // Send final confirmation email
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
                
                $mail->addAddress($order['email'], $order['first_name'] . ' ' . $order['last_name']);
                $mail->isHTML(true);
                $mail->Subject = 'E-Ticket Confirmed - Global Pro Bono Summit';
                $mail->Body    = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;'>
                    <div style='background: #166534; padding: 25px; text-align: center; border-bottom: 4px solid #d4a017;'>
                        <h2 style='color: #ffffff; margin: 0; font-size: 22px;'>Global Pro Bono Summit - E-Ticket</h2>
                    </div>
                    <div style='padding: 35px; background: #ffffff; color: #334155; line-height: 1.6; font-size: 16px;'>
                        <h3>Dear {$order['first_name']},</h3>
                        <p>We are thrilled to confirm that your payment has been received and your tickets are fully confirmed!</p>
                        
                        <div style='background: #f8fafc; padding: 20px; border-radius: 4px; border: 1px dashed #166534; margin-bottom: 20px; text-align: center;'>
                            <h4 style='margin-top: 0; font-size: 14px; color: #64748b; text-transform: uppercase;'>Ticket Reference</h4>
                            <div style='font-size: 28px; font-weight: 900; color: #166534; letter-spacing: 2px;'>{$order['order_ref']}</div>
                        </div>

                        <p>Please present this reference number or this email at the registration desk when you arrive at the summit.</p>
                        <p>We look forward to welcoming you.</p>
                        <br>
                        <p>Warm regards,<br><strong>The Organizing Committee</strong></p>
                    </div>
                </div>";
                $mail->send();
            } catch (Exception $e) {
                // log silently
            }
        }
        
        echo json_encode(['success' => true, 'message' => "Order confirmed and email sent."]);
        exit;
    }
    
    if ($action === 'delete_order') {
        $stmt = $pdo->prepare("DELETE FROM ticket_orders WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        echo json_encode(['success' => true, 'message' => "Order deleted."]);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Unknown action']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
