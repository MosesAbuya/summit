<?php
require 'includes/db.php';
$ref = $_GET['ref'] ?? '';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ref = $_POST['ref'] ?? '';
    $transaction_code = $_POST['transaction_code'] ?? '';
    
    if (empty($ref)) {
        $error = "Invalid order reference.";
    } else {
        $stmt = $pdo->prepare("SELECT id, payment_status FROM ticket_orders WHERE order_ref = ?");
        $stmt->execute([$ref]);
        $order = $stmt->fetch();
        
        if (!$order) {
            $error = "Order not found.";
        } else if ($order['payment_status'] === 'confirmed') {
            $error = "This order is already confirmed.";
        } else {
            $proofUrl = '';
            if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/proofs/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.-]/", "_", basename($_FILES['payment_proof']['name']));
                $target = $uploadDir . $filename;
                if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $target)) {
                    $proofUrl = $target;
                }
            }
            
            if (empty($proofUrl) && empty($transaction_code)) {
                $error = "Please provide either a transaction code or upload a proof document.";
            } else {
                $updateQ = "UPDATE ticket_orders SET payment_status = 'proof_uploaded'";
                $params = [];
                if (!empty($proofUrl)) {
                    $updateQ .= ", payment_proof_url = ?";
                    $params[] = $proofUrl;
                }
                if (!empty($transaction_code)) {
                    $updateQ .= ", transaction_code = ?";
                    $params[] = $transaction_code;
                }
                $updateQ .= " WHERE id = ?";
                $params[] = $order['id'];
                
                $stmtUpdate = $pdo->prepare($updateQ);
                $stmtUpdate->execute($params);
                
                $success = "Proof of payment uploaded successfully. Our team will review and confirm your tickets shortly.";
            }
        }
    }
}
include 'includes/header.php';
?>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('assets/hero-bg.png') center/cover; padding: 4rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 2.5rem; margin-bottom: 0.5rem;">Upload Payment Proof</h1>
    </div>
</div>

<main style="padding: 4rem 0; background: #f8fafc; min-height: 50vh;">
    <div class="container" style="max-width: 600px; margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        
        <?php if($success): ?>
            <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; text-align: center;">
                <i class="fa-solid fa-check-circle" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                <strong><?php echo htmlspecialchars($success); ?></strong>
            </div>
            <div style="text-align: center;">
                <a href="index.php" class="btn btn-primary">Return to Homepage</a>
            </div>
        <?php else: ?>
        
            <?php if($error): ?>
                <div style="background: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div style="background: #eef2ff; border-left: 4px solid #4f46e5; padding: 1.5rem; border-radius: 4px; margin-bottom: 2rem;">
                <h3 style="color: #4f46e5; margin-top: 0; margin-bottom: 0.5rem; font-size: 1.1rem;">Finalize Your Payment</h3>
                <p style="color: #334155; margin: 0;">Welcome to your secure payment portal. If you skipped uploading your payment proof during the initial checkout, you can complete the process here. Please provide your order reference and the proof of payment (screenshot or transaction code) so we can verify your booking and issue your e-tickets.</p>
            </div>

            <form action="upload_proof.php" method="POST" enctype="multipart/form-data">
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Order Reference *</label>
                    <input type="text" name="ref" value="<?php echo htmlspecialchars($ref); ?>" class="form-control" required placeholder="e.g. GPBS-A1B2C3" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Bank Transaction Code</label>
                    <input type="text" name="transaction_code" class="form-control" placeholder="e.g. KCB1234567" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Proof of Payment (Screenshot/PDF)</label>
                    <input type="file" name="payment_proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 4px;">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem;">Submit Proof</button>
            </form>
            
        <?php endif; ?>

    </div>
</main>

<?php include 'includes/footer.php'; ?>
