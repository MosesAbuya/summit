<?php
$host_header = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '';
$is_localhost = false;

if (!empty($host_header)) {
    if (strpos($host_header, 'localhost') !== false || strpos($host_header, '127.0.0.1') !== false || strpos($host_header, '::1') !== false) {
        $is_localhost = true;
    }
} else {
    // Fallback for CLI or local development when HTTP headers are absent
    if (php_sapi_name() === 'cli' || strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $is_localhost = true;
    }
}

if ($is_localhost) {
    // Local development credentials
    $host = 'localhost';
    $dbname = 'summit';
    $username = 'root';
    $password = '';
} else {
    // Live / Production server credentials
    $host = 'localhost';
    $dbname = 'faridagi_summit';
    $username = 'faridagi_summit';
    $password = 'Summit@2026';
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Auto-create new tables if they don't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS partners (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            image_url VARCHAR(255),
            is_major TINYINT(1) DEFAULT 0,
            website_url VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS speakers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            title VARCHAR(255),
            bio TEXT,
            image_url VARCHAR(255),
            is_keynote TINYINT(1) DEFAULT 0,
            video_url VARCHAR(255),
            theme VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS accommodations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            hotel_name VARCHAR(255) NOT NULL,
            description TEXT,
            booking_link VARCHAR(255),
            image_url VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS resources (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            file_url VARCHAR(255),
            category VARCHAR(255),
            status VARCHAR(100) DEFAULT 'Locked',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS ticket_packages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            price_usd DECIMAL(10,2) NOT NULL,
            price_kes DECIMAL(10,2) NOT NULL,
            slots INT NULL DEFAULT NULL,
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
        CREATE TABLE IF NOT EXISTS settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(100) UNIQUE NOT NULL,
            setting_value TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");

    // Ensure website_url column exists in partners table on existing databases
    try {
        $pdo->exec("ALTER TABLE partners ADD COLUMN website_url VARCHAR(255) NULL AFTER is_major");
    } catch (Exception $e) {
        // Column already exists or alter skipped
    }

    // Ensure slots column exists in ticket_packages on existing databases
    try {
        $pdo->exec("ALTER TABLE ticket_packages ADD COLUMN slots INT NULL DEFAULT NULL AFTER price_kes");
    } catch (Exception $e) {
        // Column already exists or alter skipped
    }

    // Seed default settings if empty
    $pdo->exec("INSERT IGNORE INTO settings (setting_key, setting_value) VALUES 
        ('paystack_public_key', 'pk_test_6578aa473fa44adafd06040f9ce9507ed9c9fd90'),
        ('paystack_secret_key', 'sk_test_0a76085eeda2c3f51c5c3dd7f4027c9328737be3')
    ");

    // Fetch all app settings globally
    $app_settings = [];
    try {
        $stmt_settings = $pdo->query("SELECT setting_key, setting_value FROM settings");
        while($row = $stmt_settings->fetch()) {
            $app_settings[$row['setting_key']] = $row['setting_value'];
        }
    } catch(PDOException $e) {}

    // Auto-migrate to final revised promo packages
    try {
        $promo_installed = $pdo->query("SELECT setting_value FROM settings WHERE setting_key = 'promo_packages_2026_applied'")->fetchColumn();
        if (!$promo_installed) {
            // Deactivate existing old packages
            $pdo->exec("UPDATE ticket_packages SET is_active = 0");

            $revised_packages = [
                ['name' => 'Students', 'description' => 'Valid student ID required at summit venue', 'usd' => 150.00, 'kes' => 15000.00, 'slots' => 20, 'sort' => 1],
                ['name' => 'Young Professionals', 'description' => 'Early-career professionals & youth under 30', 'usd' => 200.00, 'kes' => 20000.00, 'slots' => 20, 'sort' => 2],
                ['name' => 'EAC Members', 'description' => 'East African Community (Kenya, Uganda, Tanzania, Rwanda, Burundi, South Sudan, DRC, Somalia)', 'usd' => 200.00, 'kes' => 20000.00, 'slots' => 20, 'sort' => 3],
                ['name' => 'Civil Society', 'description' => 'Non-profit and civil society delegates', 'usd' => 350.00, 'kes' => 35000.00, 'slots' => 50, 'sort' => 4],
                ['name' => 'Speakers/Moderators', 'description' => 'Approved speakers, panellists, and session moderators', 'usd' => 450.00, 'kes' => 45000.00, 'slots' => 50, 'sort' => 5],
                ['name' => 'Academia', 'description' => 'Researchers, university faculty, and educational institutions', 'usd' => 500.00, 'kes' => 50000.00, 'slots' => 20, 'sort' => 6],
                ['name' => 'Volunteer Organizations', 'description' => 'Leaders & representatives of volunteer-involving organizations', 'usd' => 500.00, 'kes' => 50000.00, 'slots' => 50, 'sort' => 7],
            ];

            foreach ($revised_packages as $rp) {
                $chk = $pdo->prepare("SELECT id FROM ticket_packages WHERE name = ?");
                $chk->execute([$rp['name']]);
                $existingId = $chk->fetchColumn();
                if ($existingId) {
                    $upd = $pdo->prepare("UPDATE ticket_packages SET description = ?, price_usd = ?, price_kes = ?, slots = ?, sort_order = ?, is_active = 1 WHERE id = ?");
                    $upd->execute([$rp['description'], $rp['usd'], $rp['kes'], $rp['slots'], $rp['sort'], $existingId]);
                } else {
                    $ins = $pdo->prepare("INSERT INTO ticket_packages (name, description, price_usd, price_kes, slots, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, 1)");
                    $ins->execute([$rp['name'], $rp['description'], $rp['usd'], $rp['kes'], $rp['slots'], $rp['sort']]);
                }
            }

            $pdo->exec("INSERT INTO settings (setting_key, setting_value) VALUES ('promo_packages_2026_applied', '1') ON DUPLICATE KEY UPDATE setting_value = '1'");
        }
    } catch (Exception $e) {}

    // Seed packages and migrate data if not already done
    $stmt = $pdo->query("SELECT COUNT(*) FROM ticket_packages");
    if ($stmt->fetchColumn() == 0) {
        $packages = [
            ['name' => 'Students', 'description' => 'Valid student ID required at summit venue', 'usd' => 150.00, 'kes' => 15000.00, 'slots' => 20, 'sort' => 1],
            ['name' => 'Young Professionals', 'description' => 'Early-career professionals & youth under 30', 'usd' => 200.00, 'kes' => 20000.00, 'slots' => 20, 'sort' => 2],
            ['name' => 'EAC Members', 'description' => 'East African Community (Kenya, Uganda, Tanzania, Rwanda, Burundi, South Sudan, DRC, Somalia)', 'usd' => 200.00, 'kes' => 20000.00, 'slots' => 20, 'sort' => 3],
            ['name' => 'Civil Society', 'description' => 'Non-profit and civil society delegates', 'usd' => 350.00, 'kes' => 35000.00, 'slots' => 50, 'sort' => 4],
            ['name' => 'Speakers/Moderators', 'description' => 'Approved speakers, panellists, and session moderators', 'usd' => 450.00, 'kes' => 45000.00, 'slots' => 50, 'sort' => 5],
            ['name' => 'Academia', 'description' => 'Researchers, university faculty, and educational institutions', 'usd' => 500.00, 'kes' => 50000.00, 'slots' => 20, 'sort' => 6],
            ['name' => 'Volunteer Organizations', 'description' => 'Leaders & representatives of volunteer-involving organizations', 'usd' => 500.00, 'kes' => 50000.00, 'slots' => 50, 'sort' => 7],
        ];

        $insertStmt = $pdo->prepare("INSERT INTO ticket_packages (name, description, price_usd, price_kes, slots, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($packages as $p) {
            $insertStmt->execute([$p['name'], $p['description'], $p['usd'], $p['kes'], $p['slots'], $p['sort']]);
        }

        // Add a sample promo code
        $pdo->exec("INSERT IGNORE INTO promo_codes (code, discount_usd, discount_kes) VALUES ('PROMO50', 50.00, 6500.00)");

        // Migrate existing registrations
        $regs = $pdo->query("SELECT * FROM registrations")->fetchAll();
        $orderInsert = $pdo->prepare("INSERT INTO ticket_orders (order_ref, first_name, last_name, email, phone, organization, country, dietary_requirements, accessibility_needs, passport_number, payment_status, created_at, total_usd, total_kes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $itemInsert = $pdo->prepare("INSERT INTO ticket_order_items (order_id, package_id, package_name, unit_price_usd, unit_price_kes, quantity, subtotal_usd, subtotal_kes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $pkgs = $pdo->query("SELECT * FROM ticket_packages")->fetchAll();
        $pkgMap = [];
        foreach ($pkgs as $pk)
            $pkgMap[strtolower(trim($pk['name']))] = $pk;

        foreach ($regs as $r) {
            $order_ref = 'MIG-' . strtoupper(substr(md5($r['id'] . time()), 0, 8));
            $regType = strtolower(trim($r['registration_type']));

            if (strpos($regType, 'support') !== false) {
                $pkg = $pkgMap['sponsor a delegate'] ?? $pkgs[6];
            } else if (strpos($regType, 'standard') !== false) {
                $pkg = $pkgMap['non member'] ?? $pkgs[2];
            } else {
                $pkg = $pkgMap['non member'] ?? $pkgs[2];
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
                1,
                $pkg['price_usd'],
                $pkg['price_kes']
            ]);
        }
    }

    // Auto-update to handle changed text on existing databases
    try {
        $pdo->exec("UPDATE ticket_packages SET name = 'Sponsor a grassroot Pro Bono Subsidiary/StartUp leader from outside Kenya.' WHERE name = 'Sponsor a Delegate'");
    } catch (PDOException $e) {
    }

    // Auto-seed historical reports if missing
    try {
        $stmt_historical_check = $pdo->query("SELECT COUNT(*) FROM resources WHERE category = 'Historical Report'");
        if ($stmt_historical_check->fetchColumn() == 0) {
            $reports_to_seed = [
                ['title' => '2019 Global Pro Bono Summit (New York) Report', 'url' => 'https://globalprobono.org/wp-content/uploads/2019/12/GPBS_Upshot_2019_final.pdf'],
                ['title' => '2018 Global Pro Bono Summit (Mumbai) Report', 'url' => ''],
                ['title' => '2017 Global Pro Bono Summit (Lisbon) Report', 'url' => 'https://globalprobono.org/wp-content/uploads/2018/02/Global_ProBono_Summit_2017_overview.pdf'],
                ['title' => '2016 Global Pro Bono Summit (Singapore) Report', 'url' => 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2016-recap.pdf'],
                ['title' => '2015 Global Pro Bono Summit (Berlin) Report', 'url' => 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2015-summary.pdf'],
                ['title' => '2014 Global Pro Bono Summit (San Francisco) Report', 'url' => 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2014-summary.pdf'],
                ['title' => '2013 Global Pro Bono Summit (New York) Report', 'url' => 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2013-summary.pdf']
            ];

            $stmt_ins = $pdo->prepare("INSERT INTO resources (title, description, file_url, category, status) VALUES (?, ?, ?, ?, ?)");
            foreach ($reports_to_seed as $r) {
                $status = empty($r['url']) ? 'Coming Soon' : 'Active';
                $desc = 'Official summary and recap report from the ' . $r['title'];
                $stmt_ins->execute([$r['title'], $desc, $r['url'], 'Historical Report', $status]);
            }
        }
    } catch (PDOException $e) {
    }

} catch (PDOException $e) {
    die("Database Connection failed. Please ensure database.sql is imported: " . $e->getMessage());
}
?>