<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require '../includes/db.php';

// Handle Post Actions
$admin_msg = "";
$admin_msg_type = "success";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'save_mailer_settings') {
        $form_type = $_POST['form_type'];
        $company_email = $_POST['company_email'];
        $smtp_host = $_POST['smtp_host'];
        $smtp_port = (int)$_POST['smtp_port'];
        $smtp_user = $_POST['smtp_user'];
        $smtp_pass = !empty($_POST['smtp_pass']) ? $_POST['smtp_pass'] : null;
        $from_email = $_POST['from_email'];
        $from_name = $_POST['from_name'];
        
        // If password is not provided, don't update it
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
        $admin_msg = "Mailer settings for " . ucfirst($form_type) . " updated successfully!";
    }
    
    if (isset($_POST['action']) && $_POST['action'] === 'add_news') {
        $title = $_POST['title'];
        $excerpt = $_POST['excerpt'];
        $content = $_POST['content'];
        $image_url = $_POST['image_url'];
        
        $stmt = $pdo->prepare("INSERT INTO news (title, excerpt, content, image_url) VALUES (?, ?, ?, ?)");
        if($stmt->execute([$title, $excerpt, $content, $image_url])) {
            $admin_msg = "News article published successfully!";
        } else {
            $admin_msg = "Failed to publish news.";
            $admin_msg_type = "error";
        }
    }

    if (isset($_POST['action']) && $_POST['action'] === 'delete_news') {
        $id = $_POST['news_id'];
        $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
        $stmt->execute([$id]);
        $admin_msg = "News article deleted.";
    }
    
    // Partners CRUD
    if (isset($_POST['action']) && $_POST['action'] === 'add_partner') {
        $stmt = $pdo->prepare("INSERT INTO partners (name, description, image_url, is_major) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['description'], $_POST['image_url'], isset($_POST['is_major']) ? 1 : 0]);
        $admin_msg = "Partner added successfully!";
    }
    if (isset($_POST['action']) && $_POST['action'] === 'delete_partner') {
        $stmt = $pdo->prepare("DELETE FROM partners WHERE id = ?");
        $stmt->execute([$_POST['partner_id']]);
        $admin_msg = "Partner deleted.";
    }

    // Speakers CRUD
    if (isset($_POST['action']) && $_POST['action'] === 'add_speaker') {
        $stmt = $pdo->prepare("INSERT INTO speakers (name, title, bio, image_url, is_keynote, video_url, theme) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['title'], $_POST['bio'], $_POST['image_url'], isset($_POST['is_keynote']) ? 1 : 0, $_POST['video_url'], $_POST['theme']]);
        $admin_msg = "Speaker added successfully!";
    }
    if (isset($_POST['action']) && $_POST['action'] === 'delete_speaker') {
        $stmt = $pdo->prepare("DELETE FROM speakers WHERE id = ?");
        $stmt->execute([$_POST['speaker_id']]);
        $admin_msg = "Speaker deleted.";
    }

    // Accommodations CRUD
    if (isset($_POST['action']) && $_POST['action'] === 'add_accommodation') {
        $stmt = $pdo->prepare("INSERT INTO accommodations (hotel_name, description, booking_link, image_url) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['hotel_name'], $_POST['description'], $_POST['booking_link'], $_POST['image_url']]);
        $admin_msg = "Accommodation added successfully!";
    }
    if (isset($_POST['action']) && $_POST['action'] === 'delete_accommodation') {
        $stmt = $pdo->prepare("DELETE FROM accommodations WHERE id = ?");
        $stmt->execute([$_POST['accommodation_id']]);
        $admin_msg = "Accommodation deleted.";
    }

    // Resources CRUD
    if (isset($_POST['action']) && $_POST['action'] === 'add_resource') {
        $file_url = '';
        if (isset($_FILES['resource_file']) && $_FILES['resource_file']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/resources/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            $filename = time() . '_' . basename($_FILES['resource_file']['name']);
            $target = $upload_dir . $filename;
            if (move_uploaded_file($_FILES['resource_file']['tmp_name'], $target)) {
                $file_url = 'assets/resources/' . $filename;
            }
        }
        $stmt = $pdo->prepare("INSERT INTO resources (title, description, file_url, category, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['description'], $file_url, $_POST['category'], $_POST['status']]);
        $admin_msg = "Resource added successfully!";
    }
    if (isset($_POST['action']) && $_POST['action'] === 'delete_resource') {
        $stmt = $pdo->prepare("DELETE FROM resources WHERE id = ?");
        $stmt->execute([$_POST['resource_id']]);
        $admin_msg = "Resource deleted.";
    }
}


// Fetch Data
$stmt_reg = $pdo->query("SELECT * FROM registrations ORDER BY created_at DESC");
$registrations = $stmt_reg->fetchAll();

$stmt_enq = $pdo->query("SELECT * FROM enquiries ORDER BY created_at DESC");
$enquiries = $stmt_enq->fetchAll();

$stmt_news = $pdo->query("SELECT * FROM news ORDER BY created_at DESC");
$all_news = $stmt_news->fetchAll();

$stmt_partners = $pdo->query("SELECT * FROM partners ORDER BY created_at DESC");
$partners = $stmt_partners->fetchAll();

$stmt_resources = $pdo->query("SELECT * FROM resources ORDER BY created_at DESC");
$resources = $stmt_resources->fetchAll();

$stmt_speakers = $pdo->query("SELECT * FROM speakers ORDER BY created_at DESC");
$speakers = $stmt_speakers->fetchAll();

$stmt_accommodations = $pdo->query("SELECT * FROM accommodations ORDER BY created_at DESC");
$accommodations = $stmt_accommodations->fetchAll();


$stmt_ms = $pdo->query("SELECT * FROM mailer_settings");
$ms_raw = $stmt_ms->fetchAll();
$mailer_settings = [];
foreach($ms_raw as $ms) {
    $mailer_settings[$ms['form_type']] = $ms;
}

// Ensure defaults exist for the view
if(!isset($mailer_settings['contact'])) $mailer_settings['contact'] = ['company_email'=>'', 'smtp_host'=>'', 'smtp_port'=>'465', 'smtp_user'=>'', 'from_email'=>'', 'from_name'=>''];
if(!isset($mailer_settings['registration'])) $mailer_settings['registration'] = ['company_email'=>'', 'smtp_host'=>'', 'smtp_port'=>'465', 'smtp_user'=>'', 'from_email'=>'', 'from_name'=>''];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Summit Africa</title>
    <!-- Use Tailwind via CDN for quick, clean admin panel -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('border-green-600', 'text-green-600');
                el.classList.add('border-transparent', 'text-slate-500');
            });
            document.getElementById(tabId).classList.remove('hidden');
            document.getElementById('btn-' + tabId).classList.remove('border-transparent', 'text-slate-500');
            document.getElementById('btn-' + tabId).classList.add('border-green-600', 'text-green-600');
        }
        
        function switchMailerTab(formType) {
            document.querySelectorAll('.mailer-pane').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.mailer-tab-btn').forEach(el => {
                el.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600', 'font-medium');
                el.classList.add('text-slate-500');
            });
            document.getElementById('mailer-' + formType).classList.remove('hidden');
            document.getElementById('btn-mailer-' + formType).classList.remove('text-slate-500');
            document.getElementById('btn-mailer-' + formType).classList.add('border-b-2', 'border-blue-500', 'text-blue-600', 'font-medium');
        }
    </script>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased">
    <nav class="bg-green-900 text-white shadow-lg relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-shield-halved text-green-400 text-xl"></i>
                    <span class="font-bold text-xl tracking-wide">Summit Admin Hub</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-green-200 text-sm font-medium">Welcome, <?php echo htmlspecialchars($_SESSION['admin_user'] ?? 'Sadia'); ?>!</span>
                    <a href="logout.php" class="bg-green-800 hover:bg-green-700 px-4 py-2 rounded-md font-medium transition text-sm flex items-center gap-2"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex space-x-8 overflow-x-auto pb-2">
                <button id="btn-tab-submissions" onclick="switchTab('tab-submissions')" class="tab-btn border-green-600 text-green-600 border-b-2 py-4 px-1 text-sm font-medium whitespace-nowrap focus:outline-none"><i class="fa-solid fa-inbox mr-2"></i>Submissions</button>
                <button id="btn-tab-partners" onclick="switchTab('tab-partners')" class="tab-btn border-transparent text-slate-500 hover:text-slate-700 border-b-2 py-4 px-1 text-sm font-medium whitespace-nowrap focus:outline-none"><i class="fa-solid fa-handshake mr-2"></i>Partners</button>
                <button id="btn-tab-speakers" onclick="switchTab('tab-speakers')" class="tab-btn border-transparent text-slate-500 hover:text-slate-700 border-b-2 py-4 px-1 text-sm font-medium whitespace-nowrap focus:outline-none"><i class="fa-solid fa-microphone mr-2"></i>Speakers</button>
                <button id="btn-tab-accommodations" onclick="switchTab('tab-accommodations')" class="tab-btn border-transparent text-slate-500 hover:text-slate-700 border-b-2 py-4 px-1 text-sm font-medium whitespace-nowrap focus:outline-none"><i class="fa-solid fa-bed mr-2"></i>Accommodations</button>
                <button id="btn-tab-news" onclick="switchTab('tab-news')" class="tab-btn border-transparent text-slate-500 hover:text-slate-700 border-b-2 py-4 px-1 text-sm font-medium whitespace-nowrap focus:outline-none"><i class="fa-regular fa-newspaper mr-2"></i>News & Updates</button>
                <button id="btn-tab-resources" onclick="switchTab('tab-resources')" class="tab-btn border-transparent text-slate-500 hover:text-slate-700 border-b-2 py-4 px-1 text-sm font-medium whitespace-nowrap focus:outline-none"><i class="fa-solid fa-folder-open mr-2"></i>Resources</button>
                <button id="btn-tab-mailer" onclick="switchTab('tab-mailer')" class="tab-btn border-transparent text-slate-500 hover:text-slate-700 border-b-2 py-4 px-1 text-sm font-medium whitespace-nowrap focus:outline-none"><i class="fa-solid fa-envelope-open-text mr-2"></i>Mailer Settings</button>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <?php if($admin_msg): ?>
            <div class="<?php echo $admin_msg_type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700'; ?> px-4 py-3 rounded relative border mb-6" role="alert">
              <span class="block sm:inline"><?php echo htmlspecialchars($admin_msg); ?></span>
            </div>
        <?php endif; ?>

        <!-- ==============================
             TAB 1: SUBMISSIONS
             ============================== -->
        <div id="tab-submissions" class="tab-content">
            <h2 class="text-2xl font-bold mb-4 text-slate-900 flex items-center gap-2"><i class="fa-solid fa-clipboard-list text-green-700"></i> Global Registrations</h2>
            <div class="bg-white shadow rounded-lg overflow-hidden mb-12">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Name / Org</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Reg Type</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Track & Pledge</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            <?php if (count($registrations) > 0): ?>
                                <?php foreach($registrations as $r): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?php echo date('M d, g:i A', strtotime($r['created_at'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-slate-900"><?php echo htmlspecialchars($r['first_name'] . ' ' . $r['last_name']); ?></div>
                                        <div class="text-sm text-slate-500"><?php echo htmlspecialchars($r['organization']) . ' (' . htmlspecialchars($r['country']) . ')'; ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-900"><?php echo htmlspecialchars($r['email']); ?></div>
                                        <div class="text-sm text-slate-500"><?php echo htmlspecialchars($r['phone']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold"><?php echo htmlspecialchars($r['registration_type']); ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        <div class="font-bold mb-1" style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;"><?php echo htmlspecialchars($r['track_alignment']); ?></div>
                                        <?php if ($r['pro_bono_pledge']): ?>
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold"><i class="fa-solid fa-handshake"></i> Pledged</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800"><?php echo htmlspecialchars($r['status']); ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500">No registrations found yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <h2 class="text-2xl font-bold mb-4 text-slate-900 flex items-center gap-2"><i class="fa-solid fa-inbox text-green-700"></i> Headquarters Enquiries</h2>
            <div class="bg-white shadow rounded-lg overflow-hidden mb-12">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Sender</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Message Payload</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            <?php if (count($enquiries) > 0): ?>
                                <?php foreach($enquiries as $e): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?php echo date('M d, g:i A', strtotime($e['created_at'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-slate-900"><?php echo htmlspecialchars($e['full_name']); ?></div>
                                        <div class="text-sm"><a href="mailto:<?php echo htmlspecialchars($e['email']); ?>" class="text-green-600 hover:text-green-900 font-medium"><?php echo htmlspecialchars($e['email']); ?></a></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-bold"><?php echo htmlspecialchars($e['subject']); ?></td>
                                    <td class="px-6 py-4 text-sm text-slate-700 max-w-xl"><?php echo nl2br(htmlspecialchars($e['message'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500">No enquiries found yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ==============================
             TAB: PARTNERS
             ============================== -->
        <div id="tab-partners" class="tab-content hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">Add Partner</h3>
                        <form method="POST">
                            <input type="hidden" name="action" value="add_partner">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Partner Name</label>
                                <input type="text" name="name" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                                <textarea name="description" rows="3" class="w-full border-slate-300 rounded-md shadow-sm p-2 border"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Image URL</label>
                                <input type="text" name="image_url" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
                            </div>
                            <div class="mb-4 flex items-center">
                                <input type="checkbox" name="is_major" id="is_major" class="h-4 w-4 text-green-600 border-slate-300 rounded">
                                <label for="is_major" class="ml-2 block text-sm text-slate-900">Major Partner (Homepage)</label>
                            </div>
                            <button type="submit" class="w-full bg-green-700 text-white font-medium py-2 px-4 rounded-md">Add Partner</button>
                        </form>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Partner</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Major</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                <?php foreach($partners as $p): ?>
                                <tr>
                                    <td class="px-6 py-4"><div class="text-sm font-bold"><?php echo htmlspecialchars($p['name']); ?></div></td>
                                    <td class="px-6 py-4"><span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full <?php echo $p['is_major'] ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800'; ?>"><?php echo $p['is_major'] ? 'Yes' : 'No'; ?></span></td>
                                    <td class="px-6 py-4 text-right">
                                        <form method="POST" onsubmit="return confirm('Delete partner?');">
                                            <input type="hidden" name="action" value="delete_partner">
                                            <input type="hidden" name="partner_id" value="<?php echo $p['id']; ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==============================
             TAB: SPEAKERS
             ============================== -->
        <div id="tab-speakers" class="tab-content hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">Add Speaker</h3>
                        <form method="POST">
                            <input type="hidden" name="action" value="add_speaker">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Speaker Name</label>
                                <input type="text" name="name" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Title/Org</label>
                                <input type="text" name="title" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Bio</label>
                                <textarea name="bio" rows="2" class="w-full border-slate-300 rounded-md shadow-sm p-2 border"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Image URL</label>
                                <input type="text" name="image_url" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Theme (Pillar)</label>
                                <select name="theme" class="w-full border-slate-300 rounded-md shadow-sm p-2 border">
                                    <option value="Pillar I">Pillar I</option>
                                    <option value="Pillar II">Pillar II</option>
                                    <option value="Pillar III">Pillar III</option>
                                    <option value="Pillar IV">Pillar IV</option>
                                </select>
                            </div>
                            <div class="mb-4 flex items-center">
                                <input type="checkbox" name="is_keynote" id="is_keynote" class="h-4 w-4 text-green-600 border-slate-300 rounded">
                                <label for="is_keynote" class="ml-2 block text-sm text-slate-900">Keynote Speaker (Homepage)</label>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Video URL (For Keynote)</label>
                                <input type="text" name="video_url" class="w-full border-slate-300 rounded-md shadow-sm p-2 border">
                            </div>
                            <button type="submit" class="w-full bg-green-700 text-white font-medium py-2 px-4 rounded-md">Add Speaker</button>
                        </form>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Speaker</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Theme</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Keynote</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                <?php foreach($speakers as $s): ?>
                                <tr>
                                    <td class="px-6 py-4"><div class="text-sm font-bold"><?php echo htmlspecialchars($s['name']); ?></div><div class="text-xs"><?php echo htmlspecialchars($s['title']); ?></div></td>
                                    <td class="px-6 py-4 text-sm"><?php echo htmlspecialchars($s['theme']); ?></td>
                                    <td class="px-6 py-4"><span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full <?php echo $s['is_keynote'] ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-800'; ?>"><?php echo $s['is_keynote'] ? 'Yes' : 'No'; ?></span></td>
                                    <td class="px-6 py-4 text-right">
                                        <form method="POST" onsubmit="return confirm('Delete speaker?');">
                                            <input type="hidden" name="action" value="delete_speaker">
                                            <input type="hidden" name="speaker_id" value="<?php echo $s['id']; ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==============================
             TAB: ACCOMMODATIONS
             ============================== -->
        <div id="tab-accommodations" class="tab-content hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">Add Accommodation</h3>
                        <form method="POST">
                            <input type="hidden" name="action" value="add_accommodation">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Hotel Name</label>
                                <input type="text" name="hotel_name" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Description (No prices)</label>
                                <textarea name="description" rows="3" class="w-full border-slate-300 rounded-md shadow-sm p-2 border"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Booking Link</label>
                                <input type="text" name="booking_link" class="w-full border-slate-300 rounded-md shadow-sm p-2 border">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Image URL</label>
                                <input type="text" name="image_url" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
                            </div>
                            <button type="submit" class="w-full bg-green-700 text-white font-medium py-2 px-4 rounded-md">Add Accommodation</button>
                        </form>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Hotel</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                <?php foreach($accommodations as $a): ?>
                                <tr>
                                    <td class="px-6 py-4"><div class="text-sm font-bold"><?php echo htmlspecialchars($a['hotel_name']); ?></div></td>
                                    <td class="px-6 py-4 text-right">
                                        <form method="POST" onsubmit="return confirm('Delete accommodation?');">
                                            <input type="hidden" name="action" value="delete_accommodation">
                                            <input type="hidden" name="accommodation_id" value="<?php echo $a['id']; ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==============================
             TAB 2: NEWS MANAGER
             ============================== -->
        <div id="tab-news" class="tab-content hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">Publish News</h3>
                        <form method="POST">
                            <input type="hidden" name="action" value="add_news">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Headline Title</label>
                                <input type="text" name="title" class="w-full border-slate-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Image URL</label>
                                <input type="url" name="image_url" class="w-full border-slate-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm" placeholder="https://..." required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Excerpt (Short description)</label>
                                <textarea name="excerpt" rows="2" class="w-full border-slate-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Full Content</label>
                                <textarea name="content" rows="6" class="w-full border-slate-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm" required></textarea>
                            </div>
                            <button type="submit" class="w-full bg-green-700 text-white font-medium py-2 px-4 rounded-md hover:bg-green-800 transition">Publish Article</button>
                        </form>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                <?php if (count($all_news) > 0): ?>
                                    <?php foreach($all_news as $news): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?php echo date('M d, Y', strtotime($news['created_at'])); ?></td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-slate-900"><?php echo htmlspecialchars($news['title']); ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                                <input type="hidden" name="action" value="delete_news">
                                                <input type="hidden" name="news_id" value="<?php echo $news['id']; ?>">
                                                <button type="submit" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="px-6 py-8 text-center text-slate-500">No news articles published.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==============================
             TAB 3: MAILER SETTINGS
             ============================== -->
        <div id="tab-mailer" class="tab-content hidden">
            
            <div class="bg-white shadow rounded-lg p-6 mb-8 border-t-4 border-[#c1440e]">
                <h2 class="text-2xl font-bold mb-2 flex items-center gap-2"><i class="fa-regular fa-envelope text-[#d4a017]"></i> Email & Notification Settings</h2>
                <p class="text-slate-500 mb-6">Configure where notifications are sent and the outgoing SMTP server for each form.</p>
                
                <!-- Inner Tabs -->
                <div class="flex border-b border-slate-200 mb-6">
                    <button id="btn-mailer-contact" onclick="switchMailerTab('contact')" class="mailer-tab-btn px-6 py-3 border-b-2 border-blue-500 text-blue-600 font-medium bg-slate-50/50">General / Contact</button>
                    <button id="btn-mailer-registration" onclick="switchMailerTab('registration')" class="mailer-tab-btn px-6 py-3 text-slate-500 hover:text-slate-700 font-medium">Registrations</button>
                </div>

                <!-- Contact Settings Pane -->
                <div id="mailer-contact" class="mailer-pane">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">General / Contact Form</h3>
                    <p class="text-sm text-slate-500 mb-6">Default settings used by the general contact form.</p>
                    
                    <form method="POST">
                        <input type="hidden" name="action" value="save_mailer_settings">
                        <input type="hidden" name="form_type" value="contact">
                        
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-slate-800 mb-2">Company Notify Email (Receives inquiries/submissions)</label>
                            <input type="email" name="company_email" value="<?php echo htmlspecialchars($mailer_settings['contact']['company_email']); ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                            <p class="text-xs text-slate-500 mt-1">Leave blank to fallback to the general contact email.</p>
                        </div>
                        
                        <hr class="my-8">
                        <h4 class="text-md font-serif font-medium text-slate-800 mb-4">Outgoing Mail Server (SMTP)</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">SMTP Host</label>
                                <input type="text" name="smtp_host" value="<?php echo htmlspecialchars($mailer_settings['contact']['smtp_host']); ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">SMTP Port</label>
                                <input type="number" name="smtp_port" value="<?php echo htmlspecialchars($mailer_settings['contact']['smtp_port']); ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">SMTP Username</label>
                                <input type="text" name="smtp_user" value="<?php echo htmlspecialchars($mailer_settings['contact']['smtp_user']); ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">SMTP Password</label>
                                <input type="password" name="smtp_pass" placeholder="<?php echo !empty($mailer_settings['contact']['smtp_host']) ? '••••••••••••••••' : ''; ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" <?php echo !empty($mailer_settings['contact']['smtp_host']) ? '' : 'required'; ?>>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">From Email</label>
                                <input type="email" name="from_email" value="<?php echo htmlspecialchars($mailer_settings['contact']['from_email']); ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">From Name</label>
                                <input type="text" name="from_name" value="<?php echo htmlspecialchars($mailer_settings['contact']['from_name']); ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="bg-[#d4a017] hover:bg-[#b8860b] text-white font-bold py-2 px-6 rounded-md shadow flex items-center gap-2 transition"><i class="fa-solid fa-check-double"></i> Save Settings</button>
                    </form>
                </div>

                <!-- Registration Settings Pane -->
                <div id="mailer-registration" class="mailer-pane hidden">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Registration Form</h3>
                    <p class="text-sm text-slate-500 mb-6">Settings used for delegate and sponsorship registrations.</p>
                    
                    <form method="POST">
                        <input type="hidden" name="action" value="save_mailer_settings">
                        <input type="hidden" name="form_type" value="registration">
                        
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-slate-800 mb-2">Company Notify Email (Receives registrations)</label>
                            <input type="email" name="company_email" value="<?php echo htmlspecialchars($mailer_settings['registration']['company_email']); ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        
                        <hr class="my-8">
                        <h4 class="text-md font-serif font-medium text-slate-800 mb-4">Outgoing Mail Server (SMTP)</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">SMTP Host</label>
                                <input type="text" name="smtp_host" value="<?php echo htmlspecialchars($mailer_settings['registration']['smtp_host']); ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">SMTP Port</label>
                                <input type="number" name="smtp_port" value="<?php echo htmlspecialchars($mailer_settings['registration']['smtp_port']); ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">SMTP Username</label>
                                <input type="text" name="smtp_user" value="<?php echo htmlspecialchars($mailer_settings['registration']['smtp_user']); ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">SMTP Password</label>
                                <input type="password" name="smtp_pass" placeholder="<?php echo !empty($mailer_settings['registration']['smtp_host']) ? '••••••••••••••••' : ''; ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" <?php echo !empty($mailer_settings['registration']['smtp_host']) ? '' : 'required'; ?>>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">From Email</label>
                                <input type="email" name="from_email" value="<?php echo htmlspecialchars($mailer_settings['registration']['from_email']); ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">From Name</label>
                                <input type="text" name="from_name" value="<?php echo htmlspecialchars($mailer_settings['registration']['from_name']); ?>" class="w-full border-slate-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="bg-[#d4a017] hover:bg-[#b8860b] text-white font-bold py-2 px-6 rounded-md shadow flex items-center gap-2 transition"><i class="fa-solid fa-check-double"></i> Save Settings</button>
                    </form>
                </div>
            </div>
            
        </div>

        <!-- ==============================
             TAB 7: RESOURCES
             ============================== -->
        <div id="tab-resources" class="tab-content hidden">
            <h2 class="text-2xl font-bold mb-4 text-slate-900 flex items-center gap-2"><i class="fa-solid fa-folder-open text-green-700"></i> Manage Resources</h2>
            
            <div class="bg-white shadow rounded-lg p-6 mb-8">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Add New Resource</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add_resource">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1">Title</label>
                            <input type="text" name="title" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1">Category</label>
                            <select name="category" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
                                <option value="Whitepapers & Research">Whitepapers & Research</option>
                                <option value="Case Studies">Case Studies</option>
                                <option value="Media Toolkit">Media Toolkit</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-800 mb-1">Description</label>
                            <textarea name="description" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" rows="2" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1">Document Upload (PDF, ZIP, etc.)</label>
                            <input type="file" name="resource_file" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1">Status</label>
                            <select name="status" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
                                <option value="Active">Active / Downloadable</option>
                                <option value="Locked">Locked</option>
                                <option value="Awaiting Ratification">Awaiting Ratification</option>
                                <option value="For Summit Delegates Only">For Summit Delegates Only</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-6 rounded-md shadow transition"><i class="fa-solid fa-plus"></i> Add Resource</button>
                </form>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Title / Desc</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">File</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        <?php foreach($resources as $res): ?>
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900"><?php echo htmlspecialchars($res['title']); ?></div>
                                <div class="text-sm text-slate-500 max-w-xs truncate"><?php echo htmlspecialchars($res['description']); ?></div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-900"><?php echo htmlspecialchars($res['category']); ?></td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800">
                                    <?php echo htmlspecialchars($res['status']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                <?php if($res['file_url']): ?>
                                <a href="../<?php echo htmlspecialchars($res['file_url']); ?>" target="_blank" class="text-blue-600 hover:underline">View File</a>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this resource?');">
                                    <input type="hidden" name="action" value="delete_resource">
                                    <input type="hidden" name="resource_id" value="<?php echo $res['id']; ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(count($resources) === 0): ?>
                        <tr><td colspan="5" class="px-6 py-4 text-center text-slate-500">No resources found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</body>
</html>
