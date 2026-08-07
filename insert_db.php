<?php
require 'includes/db.php';

$reports = [
    [
        'title' => '2019 Global Pro Bono Summit (New York) Report',
        'url' => 'assets/resources/GPBS_Upshot_2019_final.pdf'
    ],
    [
        'title' => '2018 Global Pro Bono Summit (Mumbai) Report',
        'url' => ''
    ],
    [
        'title' => '2017 Global Pro Bono Summit (Lisbon) Report',
        'url' => 'assets/resources/Global_ProBono_Summit_2017_overview.pdf'
    ],
    [
        'title' => '2016 Global Pro Bono Summit (Singapore) Report',
        'url' => 'assets/resources/global-pro-bono-summit-2016-recap.pdf'
    ],
    [
        'title' => '2015 Global Pro Bono Summit (Berlin) Report',
        'url' => 'assets/resources/global-pro-bono-summit-2015-summary.pdf'
    ],
    [
        'title' => '2014 Global Pro Bono Summit (San Francisco) Report',
        'url' => 'assets/resources/global-pro-bono-summit-2014-summary.pdf'
    ],
    [
        'title' => '2013 Global Pro Bono Summit (New York) Report',
        'url' => 'assets/resources/global-pro-bono-summit-2013-summary.pdf'
    ]
];

foreach($reports as $r) {
    // Check if already exists to prevent duplicates
    $check = $pdo->prepare("SELECT id FROM resources WHERE title = ?");
    $check->execute([$r['title']]);
    if (!$check->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO resources (title, description, file_url, category, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $r['title'],
            'Official summary and recap report from the ' . $r['title'],
            $r['url'],
            'Historical Report',
            empty($r['url']) ? 'Coming Soon' : 'Active'
        ]);
        echo "Inserted: " . $r['title'] . "\n";
    } else {
        echo "Skipped (already exists): " . $r['title'] . "\n";
    }
}
echo "Done\n";
?>
