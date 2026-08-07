<?php
require 'includes/db.php';

$reports = [
    [
        'title' => '2019 Global Pro Bono Summit (New York) Report',
        'url' => 'https://globalprobono.org/wp-content/uploads/2019/12/GPBS_Upshot_2019_final.pdf',
        'filename' => 'GPBS_Upshot_2019_final.pdf'
    ],
    [
        'title' => '2018 Global Pro Bono Summit (Mumbai) Report',
        'url' => '',
        'filename' => ''
    ],
    [
        'title' => '2017 Global Pro Bono Summit (Lisbon) Report',
        'url' => 'https://globalprobono.org/wp-content/uploads/2018/02/Global_ProBono_Summit_2017_overview.pdf',
        'filename' => 'Global_ProBono_Summit_2017_overview.pdf'
    ],
    [
        'title' => '2016 Global Pro Bono Summit (Singapore) Report',
        'url' => 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2016-recap.pdf',
        'filename' => 'global-pro-bono-summit-2016-recap.pdf'
    ],
    [
        'title' => '2015 Global Pro Bono Summit (Berlin) Report',
        'url' => 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2015-summary.pdf',
        'filename' => 'global-pro-bono-summit-2015-summary.pdf'
    ],
    [
        'title' => '2014 Global Pro Bono Summit (San Francisco) Report',
        'url' => 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2014-summary.pdf',
        'filename' => 'global-pro-bono-summit-2014-summary.pdf'
    ],
    [
        'title' => '2013 Global Pro Bono Summit (New York) Report',
        'url' => 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2013-summary.pdf',
        'filename' => 'global-pro-bono-summit-2013-summary.pdf'
    ]
];

$dir = __DIR__ . '/assets/resources/';
if (!is_dir($dir)) mkdir($dir, 0755, true);

foreach($reports as $r) {
    $file_url = '';
    if (!empty($r['url'])) {
        $content = @file_get_contents($r['url']);
        if ($content !== false) {
            file_put_contents($dir . $r['filename'], $content);
            $file_url = 'assets/resources/' . $r['filename'];
            echo "Downloaded: " . $r['filename'] . "\n";
        } else {
            echo "Failed to download: " . $r['url'] . "\n";
        }
    }
    
    // Check if already exists to prevent duplicates
    $check = $pdo->prepare("SELECT id FROM resources WHERE title = ?");
    $check->execute([$r['title']]);
    if (!$check->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO resources (title, description, file_url, category, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $r['title'],
            'Official summary and recap report from the ' . $r['title'],
            $file_url,
            'Historical Report',
            empty($file_url) ? 'Coming Soon' : 'Active'
        ]);
        echo "Inserted: " . $r['title'] . "\n";
    } else {
        echo "Skipped (already exists): " . $r['title'] . "\n";
    }
}
echo "Done\n";
?>
