<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
require '../includes/db.php';

// Fetch Registrations
$stmt_reg = $pdo->query("SELECT * FROM registrations ORDER BY created_at DESC");
$registrations = $stmt_reg->fetchAll();

// Fetch Enquiries
$stmt_enq = $pdo->query("SELECT * FROM enquiries ORDER BY created_at DESC");
$enquiries = $stmt_enq->fetchAll();
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
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased">
    <nav class="bg-green-900 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-shield-halved text-green-400 text-xl"></i>
                    <span class="font-bold text-xl tracking-wide">Summit Admin Hub</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-green-200 text-sm font-medium">Welcome, Sadia!</span>
                    <a href="logout.php" class="bg-green-800 hover:bg-green-700 px-4 py-2 rounded-md font-medium transition text-sm flex items-center gap-2"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Registrations Data -->
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
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Requirements</th>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 text-xs">
                                    <strong>PP:</strong> <?php echo htmlspecialchars($r['passport'] ?: 'N/A'); ?><br>
                                    <strong>Diet:</strong> <?php echo htmlspecialchars($r['dietary_requirements'] ?: 'None'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800">
                                      <?php echo htmlspecialchars($r['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php if(!empty($r['accessibility_needs'])): ?>
                                <tr class="bg-slate-50 border-t-0 p-0 m-0"><td colspan="6" class="px-6 py-2 text-xs text-slate-600 border-t-0"><strong>Accessibility/Notes:</strong> <?php echo htmlspecialchars($r['accessibility_needs']); ?></td></tr>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500">No registrations found yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Enquiries Data -->
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
                                <td class="px-6 py-4 text-sm text-slate-700 max-w-xl">
                                    <?php echo nl2br(htmlspecialchars($e['message'])); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500">No enquiries found yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</body>
</html>
