<?php
require 'includes/db.php';

$reports = [
    '2019 Global Pro Bono Summit (New York) Report' => 'https://globalprobono.org/wp-content/uploads/2019/12/GPBS_Upshot_2019_final.pdf',
    '2018 Global Pro Bono Summit (Mumbai) Report' => '',
    '2017 Global Pro Bono Summit (Lisbon) Report' => 'https://globalprobono.org/wp-content/uploads/2018/02/Global_ProBono_Summit_2017_overview.pdf',
    '2016 Global Pro Bono Summit (Singapore) Report' => 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2016-recap.pdf',
    '2015 Global Pro Bono Summit (Berlin) Report' => 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2015-summary.pdf',
    '2014 Global Pro Bono Summit (San Francisco) Report' => 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2014-summary.pdf',
    '2013 Global Pro Bono Summit (New York) Report' => 'https://globalprobono.org/wp-content/uploads/2018/02/global-pro-bono-summit-2013-summary.pdf'
];

foreach ($reports as $title => $url) {
    $status = empty($url) ? 'Coming Soon' : 'Active';
    $stmt = $pdo->prepare("UPDATE resources SET file_url = ?, status = ? WHERE title = ? AND category = 'Historical Report'");
    $stmt->execute([$url, $status, $title]);
}
echo "Updated links in DB.\n";
