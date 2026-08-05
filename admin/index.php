<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require '../includes/db.php';

// POST requests are now handled by api.php via AJAX

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
        function switchTab(tabId, el) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.sidebar-btn').forEach(btn => {
                btn.classList.remove('bg-green-800', 'border-l-4', 'border-green-400');
                btn.classList.add('text-green-100');
            });
            document.getElementById(tabId).classList.remove('hidden');
            if (el) {
                el.classList.add('bg-green-800', 'border-l-4', 'border-green-400');
                el.classList.remove('text-green-100');
            }
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
<body class="bg-slate-100 text-slate-800 font-sans antialiased flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-green-900 text-white flex flex-col shadow-xl flex-shrink-0 z-20 relative">
        <div class="p-6 flex items-center gap-3 border-b border-green-800">
            <i class="fa-solid fa-shield-halved text-green-400 text-2xl"></i>
            <span class="font-bold text-xl tracking-wide">Admin Hub</span>
        </div>
        <div class="p-4 flex-1 overflow-y-auto">
            <nav class="flex flex-col gap-2">
                <button onclick="switchTab('tab-submissions', this)" class="sidebar-btn bg-green-800 border-l-4 border-green-400 flex items-center gap-3 px-4 py-3 rounded-md text-left transition"><i class="fa-solid fa-inbox w-5"></i> Submissions</button>
                <button onclick="switchTab('tab-partners', this)" class="sidebar-btn text-green-100 flex items-center gap-3 px-4 py-3 rounded-md text-left hover:bg-green-800 transition"><i class="fa-solid fa-handshake w-5"></i> Partners</button>
                <button onclick="switchTab('tab-speakers', this)" class="sidebar-btn text-green-100 flex items-center gap-3 px-4 py-3 rounded-md text-left hover:bg-green-800 transition"><i class="fa-solid fa-microphone w-5"></i> Speakers</button>
                <button onclick="switchTab('tab-accommodations', this)" class="sidebar-btn text-green-100 flex items-center gap-3 px-4 py-3 rounded-md text-left hover:bg-green-800 transition"><i class="fa-solid fa-bed w-5"></i> Accommodations</button>
                <button onclick="switchTab('tab-news', this)" class="sidebar-btn text-green-100 flex items-center gap-3 px-4 py-3 rounded-md text-left hover:bg-green-800 transition"><i class="fa-regular fa-newspaper w-5"></i> News</button>
                <button onclick="switchTab('tab-resources', this)" class="sidebar-btn text-green-100 flex items-center gap-3 px-4 py-3 rounded-md text-left hover:bg-green-800 transition"><i class="fa-solid fa-folder-open w-5"></i> Resources</button>
                <button onclick="switchTab('tab-mailer', this)" class="sidebar-btn text-green-100 flex items-center gap-3 px-4 py-3 rounded-md text-left hover:bg-green-800 transition"><i class="fa-solid fa-envelope-open-text w-5"></i> Mailer Settings</button>
            </nav>
        </div>
        <div class="p-4 border-t border-green-800">
            <div class="mb-4 px-2 text-sm text-green-300">Logged in as <?php echo htmlspecialchars($_SESSION['admin_user'] ?? 'Admin'); ?></div>
            <a href="logout.php" class="block w-full text-center bg-green-800 hover:bg-green-700 px-4 py-2 rounded-md font-medium transition text-sm flex items-center justify-center gap-2"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto bg-slate-50 relative p-8">
        <!-- Toast Container -->
        <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2"></div>

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
                        <form class="ajax-form" enctype="multipart/form-data">
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
                                <input type="file" name="image_file" accept="image/*" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
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
                                        <button type="button" onclick=\"ajaxDelete('delete_partner', 'partner_id', <?php echo $p['id']; ?>, this.closest('tr'), 'tab-partners')\"" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i> Delete</button>
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
                        <form class="ajax-form" enctype="multipart/form-data">
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
                                <input type="file" name="image_file" accept="image/*" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
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
                                        <button type="button" onclick=\"ajaxDelete('delete_speaker', 'speaker_id', <?php echo $s['id']; ?>, this.closest('tr'), 'tab-speakers')\"" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i> Delete</button>
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
                        <form class="ajax-form" enctype="multipart/form-data">
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
                                <input type="file" name="image_file" accept="image/*" class="w-full border-slate-300 rounded-md shadow-sm p-2 border" required>
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
                                        <button type="button" onclick=\"ajaxDelete('delete_accommodation', 'accommodation_id', <?php echo $a['id']; ?>, this.closest('tr'), 'tab-accommodations')\"" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i> Delete</button>
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
                        <form class="ajax-form" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add_news">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Headline Title</label>
                                <input type="text" name="title" class="w-full border-slate-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Image URL</label>
                                <input type="file" name="image_file" accept="image/*" class="w-full border-slate-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm" required>
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
                                            <button type="button" onclick=\"ajaxDelete('delete_news', 'news_id', <?php echo $news['id']; ?>, this.closest('tr'), 'tab-news')\"" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i> Delete</button>
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
                    
                    <form class="ajax-form" enctype="multipart/form-data">
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
                    
                    <form class="ajax-form" enctype="multipart/form-data">
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
                <form class="ajax-form" enctype="multipart/form-data">
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
                                <button type="button" onclick=\"ajaxDelete('delete_resource', 'resource_id', <?php echo $res['id']; ?>, this.closest('tr'), 'tab-resources')\"" class="text-red-600 hover:text-red-900"><i class="fa-solid fa-trash"></i></button>
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
    <script>
        function showToast(message, type='success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `px-4 py-3 rounded shadow-lg text-white font-medium flex items-center gap-2 transform transition-all duration-300 translate-x-full ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
            toast.innerHTML = `<i class="fa-solid ${type === 'success' ? 'fa-check-circle' : 'fa-triangle-exclamation'}"></i> ${message}`;
            container.appendChild(toast);
            
            // Animate in
            requestAnimationFrame(() => {
                toast.classList.remove('translate-x-full');
            });
            
            // Remove after 3s
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        async function refreshTable(tabId) {
            try {
                const response = await fetch(window.location.href);
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const currentTable = document.querySelector(`#${tabId} tbody`);
                const newTable = doc.querySelector(`#${tabId} tbody`);
                
                if(currentTable && newTable) {
                    currentTable.innerHTML = newTable.innerHTML;
                }
            } catch (err) {
                console.error("Failed to refresh table", err);
            }
        }

        document.querySelectorAll('.ajax-form').forEach(form => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const btn = form.querySelector('button[type="submit"]');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Saving...';
                btn.disabled = true;
                
                try {
                    const formData = new FormData(form);
                    const res = await fetch('api.php', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await res.json();
                    
                    if (data.success) {
                        showToast(data.message, 'success');
                        form.reset();
                        // Find which tab we are in
                        const tab = form.closest('.tab-content');
                        if (tab) {
                            await refreshTable(tab.id);
                        }
                    } else {
                        showToast(data.message, 'error');
                    }
                } catch (err) {
                    showToast('Network error occurred.', 'error');
                } finally {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            });
        });

        async function ajaxDelete(action, idKey, idVal, rowElement, tabId) {
            if(!confirm('Are you sure you want to delete this record?')) return;
            
            const formData = new FormData();
            formData.append('action', action);
            formData.append(idKey, idVal);
            
            try {
                const res = await fetch('api.php', { method: 'POST', body: formData });
                const data = await res.json();
                
                if (data.success) {
                    showToast(data.message, 'success');
                    // Animate row out
                    rowElement.style.transition = 'opacity 0.3s ease';
                    rowElement.style.opacity = '0';
                    setTimeout(() => {
                        rowElement.remove();
                    }, 300);
                } else {
                    showToast(data.message, 'error');
                }
            } catch (err) {
                showToast('Network error occurred.', 'error');
            }
        }
    </script>
</body>
</html>
