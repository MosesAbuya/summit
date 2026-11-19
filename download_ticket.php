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
        body { margin: 0; background: #eef2f7; font-family: Arial, sans-serif; color: #1e293b; }
        .ticket { max-width: 760px; margin: 30px auto; background: white; border: 2px solid #166534; border-radius: 14px; overflow: hidden; }
        .header { background: #166534; color: white; padding: 24px; text-align: center; border-bottom: 5px solid #d4a017; }
        .header h1 { margin: 0 0 6px; font-size: 24px; }
        .body { padding: 28px; }
        .ref { background: #f8fafc; border: 1px dashed #166534; border-radius: 8px; padding: 16px; text-align: center; margin-bottom: 20px; }
        .ref strong { display: block; color: #166534; font-size: 26px; letter-spacing: 2px; }
        .student { background: #fff7ed; border: 1px solid #fdba74; border-radius: 8px; padding: 14px; margin-top: 16px; color: #7c2d12; }
        .venue { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 14px; margin-top: 16px; }
        ul { padding-left: 20px; }
        .print { display: block; width: fit-content; margin: 20px auto 0; padding: 12px 18px; border-radius: 6px; border: 0; background: #166534; color: white; font-weight: 700; cursor: pointer; }
        @media print { body { background: white; } .ticket { margin: 0; max-width: none; } .print { display: none; } }
    </style>
</head>
<body>
    <main class="ticket">
        <div class="header">
            <h1>Global Pro Bono Summit Africa 2026</h1>
            <div>Official E-Ticket</div>
        </div>
        <div class="body">
            <div class="ref"><span>Ticket Reference</span><strong><?php echo htmlspecialchars($orderRef); ?></strong></div>
            <p><strong>Delegate:</strong> <?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
            <p><strong>Passes:</strong></p>
            <ul>
                <?php foreach ($items as $item): ?>
                    <li><?php echo (int)$item['quantity']; ?> × <?php echo htmlspecialchars($item['package_name']); ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="venue">
                <strong>Venue for 25th &amp; 26th November:</strong><br>
                Strathmore University Business School, Nairobi
            </div>
            <?php if ($student): ?>
            <div class="student">
                <strong>Student Accreditation:</strong> Bring your original physical student ID and proof of enrollment to the accreditation desk.
            </div>
            <?php endif; ?>
        </div>
    </main>
    <button class="print" onclick="window.print()">Print / Download PDF</button>
</body>
</html>
