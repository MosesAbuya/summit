<?php
require 'includes/db.php';

$orderRef = strtoupper(trim($_GET['ref'] ?? ''));
if ($orderRef === '') {
    http_response_code(400);
    exit('Missing ticket reference.');
}

$stmt = $pdo->prepare("SELECT * FROM ticket_orders WHERE order_ref = ? AND payment_status = 'confirmed' LIMIT 1");
$stmt->execute([$orderRef]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    http_response_code(404);
    exit('Ticket not found or payment has not yet been confirmed.');
}

$stmtItems = $pdo->prepare('SELECT * FROM ticket_order_items WHERE order_id = ?');
$stmtItems->execute([$order['id']]);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
$student = !empty($order['student_id_number']) || !empty($order['student_institution']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summit E-Ticket - <?php echo htmlspecialchars($orderRef); ?></title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #e7eee9; font-family: Inter, Arial, sans-serif; color: #172033; }
        .ticket { max-width: 860px; margin: 28px auto; background: white; border-radius: 18px; overflow: hidden; box-shadow: 0 22px 60px rgba(15,39,27,.16); }
        .ticket-header { min-height: 190px; position: relative; display: flex; align-items: center; justify-content: space-between; gap: 24px; padding: 30px 38px; overflow: hidden; background: linear-gradient(135deg,#091e14,#14532d 72%,#166534); color: white; }
        .ticket-header::after { content:''; position:absolute; width:280px; height:280px; right:-80px; top:-145px; border:32px solid rgba(234,179,8,.12); border-radius:50%; }
        .brand { display:flex; align-items:center; gap:16px; position:relative; z-index:2; }
        .brand img { width:118px; height:118px; object-fit:contain; padding:8px; border-radius:50%; background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.18); }
        .brand-title { font-size:26px; line-height:1.12; font-weight:850; max-width:390px; }
        .brand-title span { display:block; color:#f6ce5b; font-size:15px; letter-spacing:2px; text-transform:uppercase; margin-bottom:8px; }
        .ticket-type { position:relative; z-index:2; border:1px solid rgba(255,255,255,.28); background:rgba(255,255,255,.10); border-radius:12px; padding:14px 18px; text-align:right; }
        .ticket-type small { display:block; color:#dbeafe; text-transform:uppercase; letter-spacing:1.5px; }
        .ticket-type strong { display:block; color:#f6ce5b; font-size:21px; margin-top:4px; }
        .ticket-body { padding:34px 38px 38px; }
        .ticket-grid { display:grid; grid-template-columns:1.45fr .55fr; gap:18px; }
        .panel { border:1px solid #dfe7e2; border-radius:12px; padding:18px; }
        .label { color:#64748b; font-size:11px; text-transform:uppercase; letter-spacing:1.4px; font-weight:800; }
        .delegate-name { font-size:21px; font-weight:850; margin-top:6px; }
        .delegate-email { color:#64748b; margin-top:4px; font-size:14px; }
        .reference { background:#f8faf8; border:1px dashed #166534; text-align:center; }
        .reference strong { display:block; margin-top:7px; color:#166534; font-size:24px; letter-spacing:2px; }
        .passes { margin-top:18px; }
        .passes ul { list-style:none; margin:10px 0 0; padding:0; }
        .passes li { display:flex; justify-content:space-between; border-bottom:1px solid #edf2ef; padding:10px 0; }
        .passes li strong { color:#166534; }
        .venue-strip { margin-top:18px; display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .venue-box { border-radius:12px; padding:16px; background:#edf7f0; border-left:5px solid #166534; }
        .venue-box.gold { background:#fff8df; border-left-color:#d4a017; }
        .venue-box strong { display:block; font-size:15px; margin:5px 0 3px; }
        .venue-box span { color:#64748b; font-size:13px; }
        .student { margin-top:18px; border:1px solid #fdba74; border-radius:12px; padding:16px 18px; background:#fff7ed; color:#7c2d12; }
        .footer-note { margin-top:20px; display:flex; justify-content:space-between; color:#64748b; font-size:12px; }
        .print { display:block; width:fit-content; margin:22px auto 32px; padding:13px 22px; border:0; border-radius:8px; background:#166534; color:white; font-weight:800; cursor:pointer; }
        @media(max-width:680px){ .ticket-header{align-items:flex-start;flex-direction:column;padding:24px}.brand img{width:82px;height:82px}.brand-title{font-size:19px}.ticket-type{text-align:left}.ticket-body{padding:22px 18px}.ticket-grid,.venue-strip{grid-template-columns:1fr} }
        @media print { body{background:white}.ticket{margin:0;max-width:none;border-radius:0;box-shadow:none}.print{display:none} }
    </style>
</head>
<body>
    <main class="ticket">
        <header class="ticket-header">
            <div class="brand">
                <img src="assets/banners/logo.png" alt="Global Summit Africa logo">
                <div class="brand-title"><span>Official Delegate Pass</span>Global Pro Bono Summit Africa 2026</div>
            </div>
            <div class="ticket-type"><small>Admit</small><strong><?php echo $student ? 'STUDENT DELEGATE' : 'DELEGATE'; ?></strong></div>
        </header>
        <div class="ticket-body">
            <div class="ticket-grid">
                <div class="panel">
                    <div class="label">Delegate</div>
                    <div class="delegate-name"><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></div>
                    <div class="delegate-email"><?php echo htmlspecialchars($order['email']); ?></div>
                </div>
                <div class="panel reference"><div class="label">Ticket Reference</div><strong><?php echo htmlspecialchars($orderRef); ?></strong></div>
            </div>
            <div class="panel passes">
                <div class="label">Admission Details</div>
                <ul>
                    <?php foreach ($items as $item): ?>
                        <li><span><?php echo htmlspecialchars($item['package_name']); ?></span><strong><?php echo (int)$item['quantity']; ?> ×</strong></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="venue-strip">
                <div class="venue-box"><div class="label">25th November 2026</div><strong>Strathmore University Business School</strong><span>Nairobi, Kenya</span></div>
                <div class="venue-box gold"><div class="label">26th &amp; 27th November 2026</div><strong>26th: Strathmore University Business School<br>27th: KICC</strong><span>Nairobi, Kenya</span></div>
            </div>
            <?php if ($student): ?>
            <div class="student"><strong>Student Accreditation:</strong> Bring your original physical student ID and proof of enrollment to the accreditation desk.</div>
            <?php endif; ?>
            <div class="footer-note"><span>Global Pro Bono Network × Jitolee Foundation</span><span>Professionalism in Service. Impact in Community.</span></div>
        </div>
    </main>
    <button class="print" onclick="window.print()">Print / Download PDF</button>
</body>
</html>
