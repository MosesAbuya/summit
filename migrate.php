<?php
require 'includes/db.php';

try {
    // 1. Create the new tables
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS ticket_packages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            price_usd DECIMAL(10,2) NOT NULL,
            price_kes DECIMAL(10,2) NOT NULL,
            is_active TINYINT(1) DEFAULT 1,
            sort_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS promo_codes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            code VARCHAR(50) UNIQUE NOT NULL,
            discount_usd DECIMAL(10,2) DEFAULT 0,
            discount_kes DECIMAL(10,2) DEFAULT 0,
            is_active TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS ticket_orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_ref VARCHAR(50) UNIQUE NOT NULL,
            first_name VARCHAR(100) NOT NULL,
            last_name VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(50),
            organization VARCHAR(255),
            country VARCHAR(100),
            job_title VARCHAR(255),
            dietary_requirements VARCHAR(100),
            accessibility_needs TEXT,
            visa_required TINYINT(1) DEFAULT 0,
            passport_number VARCHAR(100),
            emergency_contact_name VARCHAR(255),
            emergency_contact_phone VARCHAR(50),
            subtotal_usd DECIMAL(10,2) DEFAULT 0,
            discount_usd DECIMAL(10,2) DEFAULT 0,
            total_usd DECIMAL(10,2) DEFAULT 0,
            subtotal_kes DECIMAL(10,2) DEFAULT 0,
            discount_kes DECIMAL(10,2) DEFAULT 0,
            total_kes DECIMAL(10,2) DEFAULT 0,
            promo_code VARCHAR(50),
            payment_status VARCHAR(50) DEFAULT 'pending',
            transaction_code VARCHAR(100),
            payment_proof_url VARCHAR(255),
            payment_confirmed_at DATETIME,
            admin_notes TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS ticket_order_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            package_id INT NOT NULL,
            package_name VARCHAR(255) NOT NULL,
            unit_price_usd DECIMAL(10,2) NOT NULL,
            unit_price_kes DECIMAL(10,2) NOT NULL,
            quantity INT NOT NULL,
            subtotal_usd DECIMAL(10,2) NOT NULL,
            subtotal_kes DECIMAL(10,2) NOT NULL,
            FOREIGN KEY (order_id) REFERENCES ticket_orders(id) ON DELETE CASCADE
        );
    ");

    // 2. Seed packages if they don't exist
    $stmt = $pdo->query("SELECT COUNT(*) FROM ticket_packages");
    if ($stmt->fetchColumn() == 0) {
        $packages = [
            ['name' => 'EAC Members', 'description' => 'East African Community Members', 'usd' => 250, 'kes' => 32500, 'sort' => 1],
            ['name' => 'GPBN Member', 'description' => 'Global Pro Bono Network Member', 'usd' => 350, 'kes' => 45500, 'sort' => 2],
            ['name' => 'Non Member', 'description' => 'Standard Delegate Pass', 'usd' => 450, 'kes' => 58500, 'sort' => 3],
            ['name' => 'Academia/Government/Corporate', 'description' => 'Specialized rate for academia, gov, or corporate', 'usd' => 550, 'kes' => 71500, 'sort' => 4],
            ['name' => 'Subsidised (Students & Youth below 30yrs)', 'description' => 'Requires valid ID at venue', 'usd' => 250, 'kes' => 32500, 'sort' => 5],
            ['name' => 'Daily Rate', 'description' => 'Single day pass', 'usd' => 100, 'kes' => 13000, 'sort' => 6],
            ['name' => 'Sponsor a Delegate', 'description' => 'Sponsor attendance for a grassroots NGO leader', 'usd' => 1650, 'kes' => 214500, 'sort' => 7],
        ];
        
        $insertStmt = $pdo->prepare("INSERT INTO ticket_packages (name, description, price_usd, price_kes, sort_order) VALUES (?, ?, ?, ?, ?)");
        foreach ($packages as $p) {
            $insertStmt->execute([$p['name'], $p['description'], $p['usd'], $p['kes'], $p['sort']]);
        }
    }

    // 3. Migrate existing registrations
    // Read from `registrations` and insert into `ticket_orders` + `ticket_order_items`
    $regs = $pdo->query("SELECT * FROM registrations")->fetchAll();
    
    // Create a generic promo code for testing
    $pdo->exec("INSERT IGNORE INTO promo_codes (code, discount_usd, discount_kes) VALUES ('PROMO50', 50.00, 6500.00)");

    $orderInsert = $pdo->prepare("INSERT INTO ticket_orders (order_ref, first_name, last_name, email, phone, organization, country, dietary_requirements, accessibility_needs, passport_number, payment_status, created_at, total_usd, total_kes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $itemInsert = $pdo->prepare("INSERT INTO ticket_order_items (order_id, package_id, package_name, unit_price_usd, unit_price_kes, quantity, subtotal_usd, subtotal_kes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    // get package dict
    $pkgs = $pdo->query("SELECT * FROM ticket_packages")->fetchAll();
    $pkgMap = [];
    foreach($pkgs as $pk) {
        $pkgMap[strtolower(trim($pk['name']))] = $pk;
    }

    foreach ($regs as $r) {
        $order_ref = 'MIG-' . strtoupper(substr(md5($r['id'] . time()), 0, 8));
        
        // Find matching package, default to Non Member if not found
        $regType = strtolower(trim($r['registration_type']));
        $pkg = null;
        if (strpos($regType, 'support') !== false) {
            $pkg = $pkgMap['sponsor a delegate'] ?? $pkgs[6];
        } else if (strpos($regType, 'standard') !== false) {
            $pkg = $pkgMap['non member'] ?? $pkgs[2];
        } else {
            $pkg = $pkgMap['non member'] ?? $pkgs[2]; // Default fallback
        }

        $paymentStatus = strtolower($r['status']) == 'approved' ? 'confirmed' : 'pending';

        $orderInsert->execute([
            $order_ref,
            $r['first_name'],
            $r['last_name'],
            $r['email'],
            $r['phone'],
            $r['organization'],
            $r['country'],
            $r['dietary_requirements'],
            $r['accessibility_needs'],
            $r['passport'],
            $paymentStatus,
            $r['created_at'],
            $pkg['price_usd'],
            $pkg['price_kes']
        ]);
        
        $orderId = $pdo->lastInsertId();
        
        $itemInsert->execute([
            $orderId,
            $pkg['id'],
            $pkg['name'],
            $pkg['price_usd'],
            $pkg['price_kes'],
            1, // quantity
            $pkg['price_usd'],
            $pkg['price_kes']
        ]);
    }
    
    echo "Migration completed successfully!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
