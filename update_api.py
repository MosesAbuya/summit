import re

with open('admin/api.php', 'r', encoding='utf-8') as f:
    content = f.read()

# News Edit
edit_news = """
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
"""
content = content.replace("if ($action === 'delete_news') {", edit_news + "\n    if ($action === 'delete_news') {")

# Partner Edit
edit_partner = """
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
"""
content = content.replace("if ($action === 'delete_partner') {", edit_partner + "\n    if ($action === 'delete_partner') {")

# Speaker Edit
edit_speaker = """
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
"""
content = content.replace("if ($action === 'delete_speaker') {", edit_speaker + "\n    if ($action === 'delete_speaker') {")

# Accommodation Edit
edit_accommodation = """
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
"""
content = content.replace("if ($action === 'delete_accommodation') {", edit_accommodation + "\n    if ($action === 'delete_accommodation') {")

# Resource Edit
edit_resource = """
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
"""
content = content.replace("if ($action === 'delete_resource') {", edit_resource + "\n    if ($action === 'delete_resource') {")

with open('admin/api.php', 'w', encoding='utf-8') as f:
    f.write(content)

print("api.php updated")
