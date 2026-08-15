<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require '../includes/db.php';

// Fetch confirmed orders and their items
$stmt_orders = $pdo->query("SELECT * FROM ticket_orders WHERE payment_status = 'confirmed' ORDER BY created_at DESC");
$orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);

$stmt_items = $pdo->query("SELECT * FROM ticket_order_items");
$all_items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);
$items_by_order = [];
foreach($all_items as $item) {
    $items_by_order[$item['order_id']][] = $item;
}

// Set headers to trigger download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=summit_confirmed_orders_' . date('Y-m-d') . '.csv');

// Create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Output the column headings
fputcsv($output, [
    'Order Ref', 
    'First Name', 
    'Last Name', 
    'Email', 
    'Phone', 
    'Organization', 
    'Job Title', 
    'Country', 
    'Dietary Requirements', 
    'Accessibility Needs', 
    'Visa Required', 
    'Passport Number', 
    'Emergency Contact Name', 
    'Emergency Contact Phone', 
    'Subtotal USD', 
    'Discount USD', 
    'Total USD', 
    'Subtotal KES', 
    'Discount KES', 
    'Total KES', 
    'Promo Code', 
    'Payment Status', 
    'Transaction Code', 
    'Payment Confirmed At', 
    'Created At',
    'Purchased Packages (Qty x Name)'
]);

// Loop over the rows, formatting the data as needed, and write to the CSV
foreach ($orders as $order) {
    
    // Format items as a single string
    $items_str = '';
    if (isset($items_by_order[$order['id']])) {
        $item_parts = [];
        foreach ($items_by_order[$order['id']] as $item) {
            $item_parts[] = $item['quantity'] . 'x ' . $item['package_name'];
        }
        $items_str = implode(" | ", $item_parts);
    }
    
    fputcsv($output, [
        $order['order_ref'],
        $order['first_name'],
        $order['last_name'],
        $order['email'],
        $order['phone'],
        $order['organization'],
        $order['job_title'],
        $order['country'],
        $order['dietary_requirements'],
        $order['accessibility_needs'],
        $order['visa_required'] ? 'Yes' : 'No',
        $order['passport_number'],
        $order['emergency_contact_name'],
        $order['emergency_contact_phone'],
        $order['subtotal_usd'],
        $order['discount_usd'],
        $order['total_usd'],
        $order['subtotal_kes'],
        $order['discount_kes'],
        $order['total_kes'],
        $order['promo_code'],
        $order['payment_status'],
        $order['transaction_code'],
        $order['payment_confirmed_at'],
        $order['created_at'],
        $items_str
    ]);
}

fclose($output);
exit;
?>
