<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require '../includes/db.php';

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
        
        if ($smtp_pass) {
            $stmt = $pdo->prepare("INSERT INTO mailer_settings (form_type, company_email, smtp_host, smtp_port, smtp_user, smtp_pass, from_email, from_name) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?) 
                                   ON DUPLICATE KEY UPDATE company_email=?, smtp_host=?, smtp_port=?, smtp_user=?, smtp_pass=?, from_email=?, from_name=?");
            $stmt->execute([$form_type, $company_email, $smtp_host, $smtp_port, $smtp_user, $smtp_pass, $from_email, $from_name,
                                        $company_email, $smtp_host, $smtp_port, $smtp_user, $smtp_pass, $from_email, $from_name]);
        } else {
            $stmt = $pdo->prepare("UPDATE mailer_settings SET company_email=?, smtp_host=?, smtp_port=?, smtp_user=?, from_email=?, from_name=? WHERE form_type=?");
            $stmt->execute([$company_email, $smtp_host, $smtp_port, $smtp_user, $from_email, $from_name, $form_type]);
        }
        echo json_encode(['success' => true, 'message' => "Mailer settings for " . ucfirst($form_type) . " updated successfully!"]);
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
    
    echo json_encode(['success' => false, 'message' => 'Unknown action']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
