<?php
require 'includes/db.php';

// Target deadline: November 25, 2026 23:59:59 EAT (UTC+3)
$targetDateStr = '2026-11-25 23:59:59';
$targetTimestamp = strtotime($targetDateStr);
$secondsLeft = max(0, $targetTimestamp - time());
$daysLeft = ceil($secondsLeft / 86400);
$hoursLeft = floor(($secondsLeft % 86400) / 3600);
$minsLeft = floor(($secondsLeft % 3600) / 60);
$secsLeft = $secondsLeft % 60;

// Fetch active Final Call packages from DB
$final_packages = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM ticket_packages WHERE is_active = 1 AND name LIKE 'Final Call%' ORDER BY sort_order ASC");
    $stmt->execute();
    $final_packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

// Bulletproof fallback if packages are not in DB or DB is offline
if (count($final_packages) < 2) {
    // Attempt auto-insert if DB is connected
    try {
        $pdo->exec("INSERT IGNORE INTO ticket_packages (name, description, price_usd, price_kes, slots, sort_order, is_active) VALUES
            ('Final Call - Regular Delegate', 'Final Call Special Rate: Full summit access, masterclasses, networking, materials & lunch.', 100.00, 10000.00, 50, 101, 1),
            ('Final Call - Student Pass', 'Final Call Special Rate: Valid student ID required at summit venue. Full conference access.', 50.00, 5000.00, 30, 102, 1)
        ");
        $stmt = $pdo->prepare("SELECT * FROM ticket_packages WHERE is_active = 1 AND name LIKE 'Final Call%' ORDER BY sort_order ASC");
        $stmt->execute();
        $final_packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {}
}

if (count($final_packages) < 2) {
    $final_packages = [
        [
            'id' => 101,
            'name' => 'Final Call - Regular Delegate',
            'description' => 'Final Call Special Rate: Full summit access, masterclasses, networking, materials & lunch.',
            'price_usd' => 100.00,
            'price_kes' => 10000.00,
            'regular_usd' => 300.00,
            'regular_kes' => 30000.00,
            'savings' => '67% OFF'
        ],
        [
            'id' => 102,
            'name' => 'Final Call - Student Pass',
            'description' => 'Final Call Special Rate: Valid student ID required at summit venue. Full conference access.',
            'price_usd' => 50.00,
            'price_kes' => 5000.00,
            'regular_usd' => 100.00,
            'regular_kes' => 10000.00,
            'savings' => '50% OFF'
        ]
    ];
}

// Prefills from redirect/URL
$prefill_first_name = trim($_GET['first_name'] ?? '');
$prefill_last_name = trim($_GET['last_name'] ?? '');
$prefill_email = trim($_GET['email'] ?? '');
$prefill_phone = trim($_GET['phone'] ?? '');
$prefill_organization = trim($_GET['organization'] ?? '');
$prefill_job_title = trim($_GET['job_title'] ?? '');
$prefill_country = trim($_GET['country'] ?? '');

$page_title = "Final Call Discount Passes | Global Pro Bono Summit Africa 2026";
include 'includes/header.php';
?>

<!-- Hero Header Section -->
<div class="final-call-hero">
    <div class="container" style="max-width: 1050px; margin: 0 auto; position: relative; z-index: 2;">
        
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.45); padding: 0.35rem 1rem; border-radius: 999px; margin-bottom: 1.25rem;">
            <i class="fa-solid fa-bolt" style="color: #f87171; font-size: 0.85rem;"></i>
            <span style="color: #fecaca; font-size: 0.82rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">
                Final Call Discount &bull; Closes November 25th
            </span>
        </div>

        <h1 style="color: white; font-size: clamp(2rem, 4.5vw, 3.25rem); font-weight: 800; line-height: 1.2; margin-bottom: 1rem;">
            Global Pro Bono Summit Africa 2026<br>
            <span style="color: var(--kente-gold);">Final Call Registration</span>
        </h1>
        
        <p class="lead-text" style="color: rgba(255,255,255,0.85); max-width: 760px; margin: 0 auto 2rem; font-size: clamp(1rem, 2vw, 1.15rem); line-height: 1.6;">
            Subsidized delegate and student passes are available until <strong>November 25, 2026</strong>. 
            Join 300+ continental leaders, civil society pioneers, and corporate ESG executives in Nairobi, Kenya.
        </p>

        <!-- Countdown Timer Card -->
        <div class="countdown-card">
            <div class="countdown-title">
                <i class="fa-regular fa-clock" style="color: var(--kente-gold); margin-right: 0.4rem;"></i>
                Discount Window Closes In:
            </div>
            <div class="countdown-grid">
                <div class="cd-box">
                    <span class="cd-number" id="cd_days"><?php echo str_pad($daysLeft, 2, '0', STR_PAD_LEFT); ?></span>
                    <span class="cd-label">Days</span>
                </div>
                <div class="cd-sep">:</div>
                <div class="cd-box">
                    <span class="cd-number" id="cd_hours"><?php echo str_pad($hoursLeft, 2, '0', STR_PAD_LEFT); ?></span>
                    <span class="cd-label">Hours</span>
                </div>
                <div class="cd-sep">:</div>
                <div class="cd-box">
                    <span class="cd-number" id="cd_mins"><?php echo str_pad($minsLeft, 2, '0', STR_PAD_LEFT); ?></span>
                    <span class="cd-label">Mins</span>
                </div>
                <div class="cd-sep">:</div>
                <div class="cd-box">
                    <span class="cd-number" id="cd_secs"><?php echo str_pad($secsLeft, 2, '0', STR_PAD_LEFT); ?></span>
                    <span class="cd-label">Secs</span>
                </div>
            </div>
            <div class="countdown-footnote">
                Offer ends strictly on <strong>November 25th at 23:59 EAT</strong> or once allocated subsidized slots are filled.
            </div>
        </div>

        <!-- Summit Value Pills -->
        <div class="value-pills-row">
            <div class="value-pill"><i class="fa-solid fa-earth-africa" style="color: var(--kente-gold);"></i> 30+ Nations Represented</div>
            <div class="value-pill"><i class="fa-solid fa-utensils" style="color: var(--kente-gold);"></i> Lunches &amp; Tea Breaks Included</div>
            <div class="value-pill"><i class="fa-solid fa-certificate" style="color: var(--kente-gold);"></i> Official Verified Certificate</div>
            <div class="value-pill"><i class="fa-solid fa-network-wired" style="color: var(--kente-gold);"></i> VIP &amp; Executive Networking</div>
        </div>

    </div>
</div>

<main>
    <section class="section bg-white" style="padding-top: 2rem; padding-bottom: 5rem;">
        <div class="container" style="max-width: 1000px; margin: 0 auto;">
            
            <!-- Stepper Progress Bar -->
            <div class="stepper-header">
                <div class="stepper-step active" id="step-nav-1">
                    <div class="step-num">1</div>
                    <div class="step-label">Select Pass</div>
                </div>
                <div class="stepper-step" id="step-nav-2">
                    <div class="step-num">2</div>
                    <div class="step-label">Attendee Details</div>
                </div>
                <div class="stepper-step" id="step-nav-3">
                    <div class="step-num">3</div>
                    <div class="step-label">Payment</div>
                </div>
                <div class="stepper-step" id="step-nav-4">
                    <div class="step-num">4</div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>

            <form id="finalCallForm" enctype="multipart/form-data">
                
                <!-- STEP 1: SELECT PASS -->
                <div id="step-1" class="stepper-panel active">
                    
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <h2 style="font-size: clamp(1.6rem, 3vw, 2.2rem); color: #0f172a; margin-bottom: 0.5rem; font-weight: 800;">
                            Select Your Discounted Pass
                        </h2>
                        <p style="color: #64748b; font-size: 1rem; max-width: 650px; margin: 0 auto;">
                            Choose between the subsidized Regular Delegate Pass (<strong>KES 10,000 / $100</strong>) or Student Pass (<strong>KES 5,000 / $50</strong>). Quantities can be adjusted below.
                        </p>
                    </div>

                    <!-- Pass Cards Grid -->
                    <div class="pass-cards-grid">
                        
                        <?php 
                        foreach($final_packages as $pkg): 
                            $isStudent = (stripos($pkg['name'], 'student') !== false);
                            $badgeColor = $isStudent ? '#ea580c' : '#16a34a';
                            $badgeBg = $isStudent ? '#fff7ed' : '#dcfce7';
                            $savingsTag = $isStudent ? 'SAVE 50%' : 'SAVE 67%';
                            $wasText = $isStudent ? 'Was KES 10,000 / $100' : 'Was KES 30,000 / $300';
                            $cardTitle = $isStudent ? 'Student Delegate Pass' : 'Regular Delegate Pass';
                        ?>
                        <div class="promo-card <?php echo $isStudent ? 'promo-student' : 'promo-regular'; ?>" id="card_<?php echo $pkg['id']; ?>">
                            
                            <div class="promo-card-header">
                                <div style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                                    <span style="font-size: 0.75rem; font-weight: 800; color: <?php echo $badgeColor; ?>; background: <?php echo $badgeBg; ?>; padding: 0.2rem 0.65rem; border-radius: 999px; text-transform: uppercase;">
                                        <i class="fa-solid fa-fire"></i> <?php echo $savingsTag; ?>
                                    </span>
                                    <span style="font-size: 0.78rem; color: #ef4444; font-weight: 700; background: #fee2e2; padding: 0.15rem 0.5rem; border-radius: 4px;">
                                        Closing Nov 25
                                    </span>
                                </div>
                                <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-bottom: 0.25rem;">
                                    <?php echo htmlspecialchars($cardTitle); ?>
                                </h3>
                                <div style="font-size: 0.85rem; color: #64748b; text-decoration: line-through; font-weight: 500;">
                                    <?php echo $wasText; ?>
                                </div>
                            </div>

                            <div class="promo-pricing-box">
                                <div class="price-usd">$<?php echo number_format($pkg['price_usd'], 0); ?></div>
                                <div class="price-kes">KES <?php echo number_format($pkg['price_kes'], 0); ?></div>
                                <div style="font-size: 0.78rem; color: #64748b; margin-top: 0.25rem;">per person &bull; all 4 summit days</div>
                            </div>

                            <div class="promo-features-list">
                                <div class="feature-item">
                                    <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i>
                                    <span>Full access to all keynote sessions, panels &amp; workshops</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i>
                                    <span>Daily executive networking lunches and refreshments</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i>
                                    <span>Official delegate badge, bag &amp; digital summit materials</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i>
                                    <span>Verified Certificate of Participation</span>
                                </div>
                                <?php if($isStudent): ?>
                                <div class="feature-item" style="color: #c2410c; background: #fff7ed; padding: 0.5rem 0.65rem; border-radius: 6px; font-weight: 600; font-size: 0.82rem;">
                                    <i class="fa-solid fa-id-card" style="color: #ea580c;"></i>
                                    <span>Valid student ID required at venue accreditation desk</span>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="promo-counter-wrapper">
                                <div style="font-size: 0.9rem; font-weight: 700; color: #334155;">Quantity:</div>
                                <div class="ticket-counter">
                                    <button type="button" class="qty-btn" onclick="updateFinalQty(<?php echo $pkg['id']; ?>, -1)">-</button>
                                    <input type="number" id="qty_<?php echo $pkg['id']; ?>" name="qty[<?php echo $pkg['id']; ?>]" value="0" min="0" max="99" readonly>
                                    <button type="button" class="qty-btn" onclick="updateFinalQty(<?php echo $pkg['id']; ?>, 1)">+</button>
                                </div>
                            </div>

                            <input type="hidden" id="name_<?php echo $pkg['id']; ?>" value="<?php echo htmlspecialchars($pkg['name']); ?>">
                            <input type="hidden" id="price_usd_<?php echo $pkg['id']; ?>" value="<?php echo $pkg['price_usd']; ?>">
                            <input type="hidden" id="price_kes_<?php echo $pkg['id']; ?>" value="<?php echo $pkg['price_kes']; ?>">

                        </div>
                        <?php endforeach; ?>

                    </div>

                    <!-- Subtotal Bar -->
                    <div class="subtotal-bar">
                        <div>
                            <div style="font-size: 0.85rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">
                                Total Order Amount
                            </div>
                            <div style="font-size: 1.6rem; font-weight: 800; color: #0f172a;">
                                $<span id="step1_total_usd">0.00</span> 
                                <span style="font-size: 1.05rem; color: var(--primary-color); font-weight: 700; margin-left: 0.5rem;">
                                    (KES <span id="step1_total_kes">0.00</span>)
                                </span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="nextStep(2)" id="btn-next-1" disabled style="opacity: 0.5; cursor: not-allowed; padding: 0.9rem 1.75rem; font-size: 1.05rem;">
                            Proceed to Attendee Details &rarr;
                        </button>
                    </div>

                </div>

                <!-- STEP 2: DETAILS -->
                <div id="step-2" class="stepper-panel hidden" style="display: none;">
                    <div class="checkout-layout-grid">
                        
                        <!-- Form Section -->
                        <div class="checkout-main-card">
                            <!-- Student Verification Alert -->
                            <div id="student_verification_alert" style="display: none; background: #fff7ed; border: 1px solid #fed7aa; border-left: 5px solid #ea580c; padding: 1.15rem; border-radius: 8px; margin-bottom: 1.5rem;">
                                <div style="font-weight: 800; color: #9a3412; font-size: 0.95rem; display: flex; align-items: center; gap: 0.45rem; margin-bottom: 0.35rem;">
                                    <i class="fa-solid fa-graduation-cap"></i> Student Pass Verification Required
                                </div>
                                <div style="color: #7c2d12; font-size: 0.88rem; line-height: 1.5;">
                                    Please use an official university email address. Personal email providers such as Gmail, Yahoo, Outlook, and iCloud are not accepted.<br><br>You also need your institution name, student ID number, and proof-of-enrollment document.
                                </div>
                            </div>

                            <h3 style="font-size: 1.4rem; margin-bottom: 1.25rem; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem;">
                                Attendee Information
                            </h3>
                            
                            <div class="form-row form-grid-2">
                                <div>
                                    <label class="form-label">First Name *</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo htmlspecialchars($prefill_first_name, ENT_QUOTES, 'UTF-8'); ?>" required placeholder="e.g. Jane">
                                </div>
                                <div>
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo htmlspecialchars($prefill_last_name, ENT_QUOTES, 'UTF-8'); ?>" required placeholder="e.g. Doe">
                                </div>
                            </div>
                            
                            <div class="form-row form-grid-2">
                                <div>
                                    <label class="form-label" id="email_label">Email Address *</label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($prefill_email, ENT_QUOTES, 'UTF-8'); ?>" required placeholder="e.g. jane@example.com" oninput="validateStudentEmailRealtime()">
                                    <div id="email_student_error" style="display: none; color: #dc2626; font-size: 0.82rem; margin-top: 0.35rem; font-weight: 600;"></div>
                                </div>
                                <div>
                                    <label class="form-label">Mobile Phone Number *</label>
                                    <input type="tel" name="phone" id="phone" class="form-control" value="<?php echo htmlspecialchars($prefill_phone, ENT_QUOTES, 'UTF-8'); ?>" required placeholder="e.g. +254 712 345678">
                                </div>
                            </div>

                            <div class="form-row form-grid-2">
                                <div>
                                    <label class="form-label">Organization / University *</label>
                                    <input type="text" name="organization" id="organization" class="form-control" value="<?php echo htmlspecialchars($prefill_organization, ENT_QUOTES, 'UTF-8'); ?>" required placeholder="e.g. University of Nairobi / NGO / Company">
                                </div>
                                <div>
                                    <label class="form-label">Job Title / Student Course</label>
                                    <input type="text" name="job_title" id="job_title" class="form-control" value="<?php echo htmlspecialchars($prefill_job_title, ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. Student / Program Officer">
                                </div>
                            </div>

                            <div style="margin-bottom: 1.5rem;">
                                <label class="form-label">Country of Residence *</label>
                                <select name="country" id="country" class="form-control" required>
                                    <option value="">Select Country...</option>
                                    <?php
                                    $countries = ['Kenya', 'Uganda', 'Tanzania', 'Rwanda', 'Burundi', 'South Sudan', 'DRC', 'Ethiopia', 'Nigeria', 'South Africa', 'United States', 'United Kingdom', 'Other'];
                                    foreach ($countries as $c) {
                                        $selected = (strcasecmp($prefill_country, $c) === 0 || ($prefill_country === '' && $c === 'Kenya')) ? 'selected' : '';
                                        echo "<option value=\"$c\" $selected>$c" . ($c === 'Other' ? '...' : '') . "</option>\n";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Student Credentials Box -->
                            <div id="student_credentials_box" style="display: none; background: #fafaf9; border: 1px solid #e7e5e4; border-radius: 8px; padding: 1.25rem; margin-bottom: 1.5rem;">
                                <h4 style="font-size: 1.05rem; color: #0f172a; margin-bottom: 0.85rem; font-weight: 700; display: flex; align-items: center; gap: 0.4rem;">
                                    <i class="fa-solid fa-id-card-clip" style="color: #ea580c;"></i> Student Academic Credentials
                                </h4>
                                <div class="form-row form-grid-2">
                                    <div>
                                        <label class="form-label">University / College Name *</label>
                                        <input type="text" name="student_institution" id="student_institution" class="form-control" placeholder="e.g. University of Nairobi" required>
                                    </div>
                                    <div>
                                        <label class="form-label">Student Registration / ID Number *</label>
                                        <input type="text" name="student_id_number" id="student_id_number" class="form-control" placeholder="e.g. C01/12345/2023" required>
                                    </div>
                                </div>
                                <div style="margin-top: 0.85rem;">
                                    <label class="form-label">Upload Student ID Card / Proof of Enrollment *</label>
                                    <input type="file" name="student_id_proof" id="student_id_proof" class="form-control" accept="image/jpeg,image/png,image/webp,application/pdf" required>
                                    <small style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 0.25rem;">Required for verification: upload a clear student ID card or current admission/enrollment letter (JPG, PNG, WEBP or PDF, maximum 5 MB).</small>
                                </div>
                            </div>

                            <h3 style="font-size: 1.2rem; margin-top: 2rem; margin-bottom: 1rem; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem;">
                                Logistics &amp; Visa
                            </h3>
                            
                            <div class="form-row form-grid-2">
                                <div>
                                    <label class="form-label">Dietary Requirements</label>
                                    <select name="dietary_requirements" class="form-control">
                                        <option value="None">None</option>
                                        <option value="Vegetarian">Vegetarian</option>
                                        <option value="Vegan">Vegan</option>
                                        <option value="Halal">Halal</option>
                                        <option value="Kosher">Kosher</option>
                                        <option value="Gluten-Free">Gluten-Free</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Require Visa Support Letter?</label>
                                    <select name="visa_required" id="visa_required" class="form-control" onchange="toggleFinalPassport()">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div id="passport_field" style="margin-bottom: 1rem; display: none;">
                                <label class="form-label">Passport Number (Required for Visa Letter) *</label>
                                <input type="text" name="passport_number" id="passport_number" class="form-control" placeholder="e.g. A12345678">
                            </div>

                            <div style="margin-bottom: 1.5rem;">
                                <label class="form-label">Accessibility or other special needs?</label>
                                <textarea name="accessibility_needs" class="form-control" rows="2" placeholder="Let us know if you need any assistance..."></textarea>
                            </div>

                            <h3 style="font-size: 1.2rem; margin-top: 2rem; margin-bottom: 1rem; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem;">
                                Emergency Contact
                            </h3>
                            <div class="form-row form-grid-2" style="margin-bottom: 0;">
                                <div>
                                    <label class="form-label">Contact Name</label>
                                    <input type="text" name="emergency_contact_name" class="form-control" placeholder="e.g. John Doe">
                                </div>
                                <div>
                                    <label class="form-label">Contact Phone</label>
                                    <input type="tel" name="emergency_contact_phone" class="form-control" placeholder="e.g. +254 ...">
                                </div>
                            </div>

                        </div>

                        <!-- Sidebar Order Summary -->
                        <div>
                            <div class="sidebar-sticky-box">
                                <h4 style="font-size: 1.2rem; margin-bottom: 1rem; color: #0f172a; border-bottom: 1px solid #cbd5e1; padding-bottom: 0.5rem;">
                                    Order Summary
                                </h4>
                                
                                <div id="sidebar_cart_items" style="margin-bottom: 1rem;">
                                    <!-- Populated dynamically -->
                                </div>
                                
                                <div style="border-top: 1px solid #cbd5e1; padding-top: 1rem; margin-bottom: 1.5rem;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: #64748b; font-size: 0.95rem;">
                                        <span>Subtotal</span>
                                        <span>$<span id="sidebar_subtotal_usd">0.00</span></span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: #ef4444; display: none;" id="discount_row">
                                        <span>Discount</span>
                                        <span>-$<span id="sidebar_discount_usd">0.00</span></span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 1.3rem; color: #0f172a; margin-top: 0.5rem;">
                                        <span>Total</span>
                                        <span>$<span id="sidebar_total_usd">0.00</span></span>
                                    </div>
                                    <div style="text-align: right; font-size: 0.95rem; color: var(--primary-color); font-weight: 700;">
                                        KES <span id="sidebar_total_kes">0.00</span>
                                    </div>
                                </div>

                                <div style="margin-bottom: 1.5rem;">
                                    <label class="form-label" style="font-size: 0.85rem;">Promo Code (Optional)</label>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <input type="text" id="promo_code_input" name="promo_code" class="form-control" style="padding: 0.5rem; font-size: 0.9rem;" placeholder="Enter code">
                                        <button type="button" class="btn btn-outline" style="padding: 0.5rem 1rem;" onclick="applyPromo()">Apply</button>
                                    </div>
                                    <div id="promo_msg" style="font-size: 0.8rem; margin-top: 0.25rem;"></div>
                                </div>
                                
                                <input type="hidden" id="discount_usd_val" name="discount_usd" value="0">
                                <input type="hidden" id="discount_kes_val" name="discount_kes" value="0">

                                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                                    <button type="button" class="btn btn-outline" style="flex: 1; padding: 0.85rem;" onclick="nextStep(1)">&larr; Back</button>
                                    <button type="button" class="btn btn-primary" style="flex: 2; padding: 0.85rem;" onclick="validateFinalStep2AndProceed()">Proceed to Payment &rarr;</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- STEP 3: PAYMENT -->
                <div id="step-3" class="stepper-panel hidden" style="display: none;">
                    <div class="checkout-layout-grid">
                        
                        <div class="checkout-main-card">
                            <h3 style="font-size: 1.4rem; margin-bottom: 1.25rem; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem;">
                                Select Payment Method
                            </h3>
                            
                            <!-- Payment Toggle Options -->
                            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                                <label class="payment-label-card" id="label_paystack" onclick="togglePaymentMethod('paystack')">
                                    <input type="radio" name="payment_method" value="paystack" checked style="margin-top: 0.25rem;">
                                    <div>
                                        <div style="font-weight: 700; color: #0f172a; font-size: 1.1rem; margin-bottom: 0.35rem;">
                                            <i class="fa-solid fa-credit-card" style="color: #09a5db; margin-right: 0.4rem;"></i>
                                            Pay Online via Paystack
                                        </div>
                                        <div style="color: #64748b; font-size: 0.92rem; line-height: 1.5;">
                                            Instant automated processing. Supported options: <strong>Credit/Debit Card (Visa, Mastercard, Verve), Mobile Money (M-PESA), Apple Pay</strong>.
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="payment-label-card" id="label_manual" onclick="togglePaymentMethod('manual')">
                                    <input type="radio" name="payment_method" value="manual" style="margin-top: 0.25rem;">
                                    <div>
                                        <div style="font-weight: 700; color: #0f172a; font-size: 1.1rem; margin-bottom: 0.35rem;">
                                            <i class="fa-solid fa-building-columns" style="color: var(--primary-color); margin-right: 0.4rem;"></i>
                                            Direct Bank Transfer / Manual M-PESA Paybill
                                        </div>
                                        <div style="color: #64748b; font-size: 0.92rem; line-height: 1.5;">
                                            Transfer directly to our official KCB Bank account or send via M-PESA Paybill.
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Paystack Notice -->
                            <div id="section_paystack">
                                <div style="background: #f1f5f9; border-left: 4px solid #09a5db; padding: 1.5rem; border-radius: 0 8px 8px 0;">
                                    <p style="color: #334155; line-height: 1.6; margin-bottom: 0.75rem;">
                                        By clicking <strong>"Pay Securely with Paystack"</strong>, a secure popup will open to process your payment in KES or equivalent international currency.
                                    </p>
                                    <p style="color: #334155; line-height: 1.6; margin-bottom: 0;">
                                        <i class="fa-solid fa-lock" style="color: #16a34a; margin-right: 0.3rem;"></i> 256-bit encrypted. Your e-ticket and invoice will be issued immediately upon confirmation.
                                    </p>
                                </div>
                            </div>

                            <!-- Manual Payment Details -->
                            <div id="section_manual" style="display: none;">
                                
                                <h4 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.75rem; font-weight: 700;">
                                    <i class="fa-solid fa-building-columns" style="color: var(--primary-color); margin-right: 0.35rem;"></i> KCB Bank Details
                                </h4>
                                <ul style="list-style: none; padding: 0; margin: 0; line-height: 1.8; color: #334155; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.25rem; margin-bottom: 1.5rem;">
                                    <li><strong>Bank Name:</strong> KCB Bank Kenya Ltd</li>
                                    <li><strong>Account Title:</strong> JITOLEE GOOD FRIENDS</li>
                                    <li>
                                        <strong>Account Number:</strong> 
                                        <span style="font-size: 1.15rem; font-family: monospace; font-weight: bold; color: var(--primary-color);">1325956678</span> (KES)
                                        <button type="button" class="copy-chip" onclick="copyFinalText('1325956678', this)"><i class="fa-regular fa-copy"></i> Copy</button>
                                    </li>
                                    <li><strong>Branch:</strong> KCB Mortgage Center, Salama House</li>
                                    <li><strong>SWIFT Code:</strong> KCBLKENX</li>
                                    <li><strong>Bank Code / Branch Code:</strong> 01 / 289</li>
                                </ul>
                                
                                <h4 style="font-size: 1.1rem; color: #0f172a; margin-bottom: 0.75rem; font-weight: 700;">
                                    <i class="fa-solid fa-mobile-screen" style="color: #10b981; margin-right: 0.35rem;"></i> M-PESA Paybill Details
                                </h4>
                                <ul style="list-style: none; padding: 0; margin: 0; line-height: 1.8; color: #334155; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.25rem; margin-bottom: 2rem;">
                                    <li>
                                        <strong>Paybill Business Number:</strong> 
                                        <span style="font-size: 1.15rem; font-family: monospace; font-weight: bold; color: #10b981;">522522</span>
                                        <button type="button" class="copy-chip" onclick="copyFinalText('522522', this)"><i class="fa-regular fa-copy"></i> Copy</button>
                                    </li>
                                    <li>
                                        <strong>Account Number:</strong> 
                                        <span style="font-size: 1.15rem; font-family: monospace; font-weight: bold; color: #0f172a;">1325956678</span>
                                        <button type="button" class="copy-chip" onclick="copyFinalText('1325956678', this)"><i class="fa-regular fa-copy"></i> Copy</button>
                                    </li>
                                </ul>

                                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.25rem;">
                                    <h4 style="font-size: 1.05rem; margin-bottom: 1rem; color: #0f172a;">Payment Verification Info</h4>
                                    <div class="form-group" style="margin-bottom: 1.25rem;">
                                        <label class="form-label">M-PESA / Bank Transaction Code</label>
                                        <input type="text" name="transaction_code" id="transaction_code" class="form-control" placeholder="e.g. QXY1234567 or Bank Reference">
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label class="form-label">Upload Receipt / Proof of Payment (Optional)</label>
                                        <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept="image/*,.pdf">
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <!-- Amount Due Sidebar -->
                        <div>
                            <div class="sidebar-sticky-box">
                                <h4 style="font-size: 1.2rem; margin-bottom: 1rem; color: #0f172a; border-bottom: 1px solid #cbd5e1; padding-bottom: 0.5rem;">
                                    Amount Due
                                </h4>
                                <div style="font-size: 2.4rem; font-weight: 800; color: var(--primary-color); margin-bottom: 0.25rem;">
                                    $<span id="final_total_usd">0.00</span>
                                </div>
                                <div style="font-size: 1.15rem; color: #64748b; font-weight: 700; margin-bottom: 1.5rem;">
                                    KES <span id="final_total_kes">0.00</span>
                                </div>
                                
                                <div style="display: flex; gap: 0.75rem; flex-direction: column;">
                                    <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.05rem; padding: 1rem; background-color: #09a5db; border-color: #09a5db; font-weight: 700;" id="submitBtn">
                                        <i class="fa-solid fa-lock"></i> Pay Securely with Paystack
                                    </button>
                                    <button type="button" class="btn btn-outline" style="width: 100%; padding: 0.8rem;" onclick="nextStep(2)">
                                        &larr; Back to Details
                                    </button>
                                </div>
                                <div style="margin-top: 1rem; text-align: center; font-size: 0.8rem; color: #94a3b8; line-height: 1.5;">
                                    By completing your booking, you agree to our Terms &amp; Conditions and Summit Delegate Code of Conduct.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- STEP 4: CONFIRMATION -->
                <div id="step-4" class="stepper-panel hidden" style="display: none; text-align: center; padding: 3rem 1.5rem;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 80px; height: 80px; border-radius: 50%; background: #dcfce7; color: #16a34a; font-size: 2.5rem; margin-bottom: 1.5rem;">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <h2 style="font-size: clamp(2rem, 3.5vw, 2.5rem); color: #0f172a; margin-bottom: 1rem; font-weight: 800;">
                        Booking Received!
                    </h2>
                    <p id="success_subtitle" style="font-size: 1.1rem; color: #64748b; max-width: 600px; margin: 0 auto 2rem;">
                        Your final call registration has been placed. An email confirmation has been sent to your email address.
                    </p>
                    
                    <div style="background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; padding: 1.5rem; max-width: 420px; margin: 0 auto 2rem;">
                        <div style="font-size: 0.85rem; color: #64748b; text-transform: uppercase; font-weight: 700; margin-bottom: 0.4rem; letter-spacing: 1px;">
                            Your Order Reference
                        </div>
                        <div id="success_order_ref" style="font-size: 1.9rem; font-weight: 800; color: var(--primary-color); letter-spacing: 2px;">
                            GPBS-XXXXXX
                        </div>
                    </div>

                    <h4 id="success_next_steps_title" style="font-size: 1.2rem; color: #0f172a; margin-bottom: 1rem;">Next Steps:</h4>
                    <ol id="success_next_steps_list" style="text-align: left; max-width: 500px; margin: 0 auto 3rem; color: #334155; line-height: 1.8; font-size: 1.05rem;">
                        <li>Check your email inbox for the official order confirmation.</li>
                        <li>Make the bank transfer using the order reference above as the payment narration.</li>
                        <li>Upload your proof of payment or transaction code via the link in your email.</li>
                        <li>Receive your final e-ticket and venue access badge once verified.</li>
                    </ol>

                    <div id="student_success_box" style="display: none; background: #fff7ed; border: 2px solid #fdba74; border-radius: 8px; padding: 1.25rem; max-width: 520px; margin: 0 auto 2rem; text-align: left;">
                        <div style="font-weight: 800; color: #9a3412; font-size: 0.95rem; display: flex; align-items: center; gap: 0.4rem; margin-bottom: 0.35rem;">
                            <i class="fa-solid fa-graduation-cap"></i> Student Accreditation Requirement
                        </div>
                        <div style="color: #7c2d12; font-size: 0.88rem; line-height: 1.5;">
                            You have registered under the subsidized student rate. <strong>Please remember to bring your physical Student ID card matching your registered student ID number to the summit check-in desk at Strathmore University Business School on 25th and 26th November 2026.</strong>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 1.5rem;">
                        <a id="btn_view_ticket" href="#" target="_blank" class="btn btn-secondary" style="padding: 0.85rem 1.85rem; font-weight: 700; font-size: 1.05rem; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(234,179,8,0.35);">
                            <i class="fa-solid fa-ticket"></i> View &amp; Print E-Ticket
                        </a>
                    </div>

                    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                        <a href="index" class="btn btn-outline" style="padding: 0.85rem 1.75rem;">Return to Homepage</a>
                        <a href="program" class="btn btn-outline" style="padding: 0.85rem 1.75rem;">View Summit Schedule</a>
                    </div>
                </div>

            </form>
        </div>
    </section>

    <!-- Summit Value Assurance Section -->
    <section style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 4rem 1.5rem;">
        <div class="container" style="max-width: 1000px; margin: 0 auto; text-align: center;">
            <h3 style="font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 800; color: #0f172a; margin-bottom: 1rem;">
                Why Join the Global Pro Bono Summit Africa 2026?
            </h3>
            <p style="color: #64748b; font-size: 1.05rem; max-width: 700px; margin: 0 auto 3rem;">
                Experience the landmark gathering accelerating multidisciplinary pro bono practice for the SDGs and AU Agenda 2063.
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; text-align: left;">
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem;">
                    <div style="width: 44px; height: 44px; border-radius: 8px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; margin-bottom: 1rem;">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem;">High-Level Leaders</h4>
                    <p style="font-size: 0.92rem; color: #64748b; line-height: 1.5; margin: 0;">Connect with corporate executives, legal minds, academia and NGO directors across Africa.</p>
                </div>

                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem;">
                    <div style="width: 44px; height: 44px; border-radius: 8px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; margin-bottom: 1rem;">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem;">Actionable Masterclasses</h4>
                    <p style="font-size: 0.92rem; color: #64748b; line-height: 1.5; margin: 0;">Hands-on workshops tackling ESG metrics, policy alignment, and community impact models.</p>
                </div>

                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem;">
                    <div style="width: 44px; height: 44px; border-radius: 8px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; margin-bottom: 1rem;">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem;">Partnership Deals</h4>
                    <p style="font-size: 0.92rem; color: #64748b; line-height: 1.5; margin: 0;">Build lasting institutional alliances and unlock grassroots pro bono partnerships.</p>
                </div>

                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem;">
                    <div style="width: 44px; height: 44px; border-radius: 8px; background: #ede9fe; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; margin-bottom: 1rem;">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem;">Full Accreditation</h4>
                    <p style="font-size: 0.92rem; color: #64748b; line-height: 1.5; margin: 0;">Receive an official verified certificate of participation from GPBN &amp; Jitolee Foundation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- UI Overlay for loading -->
    <div id="loaderOverlay" style="display:none; position: fixed; top:0; left:0; right:0; bottom:0; background: rgba(255,255,255,0.9); z-index: 9999; flex-direction: column; align-items: center; justify-content: center;">
        <div class="spinner" style="border: 4px solid #e2e8f0; border-top: 4px solid var(--primary-color); border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; margin-bottom: 1rem;"></div>
        <div style="font-weight: 700; color: #0f172a; font-size: 1.15rem;">Processing Your Order...</div>
        <style>@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }</style>
    </div>

    <!-- Styled Checkout Notice Modal -->
    <div id="checkoutNoticeModal" class="checkout-notice-modal" role="dialog" aria-modal="true" aria-labelledby="checkoutNoticeTitle" aria-describedby="checkoutNoticeMessage" style="display:none;">
        <div class="checkout-notice-backdrop" onclick="closeCheckoutNotice()"></div>
        <div class="checkout-notice-card">
            <button type="button" class="checkout-notice-close" onclick="closeCheckoutNotice()" aria-label="Close popup">&times;</button>
            <div id="checkoutNoticeIcon" class="checkout-notice-icon">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h3 id="checkoutNoticeTitle">Student Pass Verification</h3>
            <div id="checkoutNoticeMessage"></div>
            <button type="button" class="checkout-notice-button" onclick="closeCheckoutNotice()">Continue</button>
        </div>
    </div>
</main>

<style>
    .checkout-notice-modal { position: fixed; inset: 0; z-index: 10050; align-items: center; justify-content: center; padding: 1rem; }
    .checkout-notice-modal.active { display: flex !important; }
    .checkout-notice-backdrop { position: absolute; inset: 0; background: rgba(15, 23, 42, 0.72); backdrop-filter: blur(5px); }
    .checkout-notice-card { position: relative; width: min(430px, 100%); background: white; border: 1px solid #fed7aa; border-radius: 16px; padding: 2rem; text-align: center; box-shadow: 0 24px 70px rgba(15, 23, 42, 0.35); animation: checkoutNoticeIn 0.18s ease-out; }
    .checkout-notice-card h3 { margin: 0.75rem 0 0.65rem; color: #0f172a; font-size: 1.35rem; }
    #checkoutNoticeMessage { color: #475569; line-height: 1.65; font-size: 0.95rem; }
    .checkout-notice-icon { width: 62px; height: 62px; margin: 0 auto; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; font-size: 1.55rem; }
    .checkout-notice-icon.error { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
    .checkout-notice-close { position: absolute; top: 0.75rem; right: 0.75rem; width: 34px; height: 34px; border: none; border-radius: 50%; background: #f1f5f9; color: #64748b; cursor: pointer; font-size: 1.35rem; line-height: 1; }
    .checkout-notice-button { width: 100%; margin-top: 1.35rem; border: none; border-radius: 8px; background: #166534; color: white; font-weight: 800; padding: 0.85rem 1rem; cursor: pointer; }
    .checkout-notice-button:hover { background: #14532d; }
    @keyframes checkoutNoticeIn { from { opacity: 0; transform: translateY(12px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }

    /* Final Call Specific Styles & Mobile Optimization */
    .final-call-hero {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(22, 101, 52, 0.9) 100%), url('assets/hero-bg.png') center/cover;
        padding: 9rem 1.5rem 4rem;
        text-align: center;
        color: white;
        position: relative;
    }
    
    .countdown-card {
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(234, 179, 8, 0.4);
        border-radius: 16px;
        padding: 1.5rem 1.25rem;
        max-width: 540px;
        margin: 0 auto 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }
    .countdown-title {
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #fef08a;
        margin-bottom: 0.85rem;
    }
    .countdown-grid {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .cd-box {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        padding: 0.6rem 0.8rem;
        min-width: 65px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .cd-number {
        font-size: 1.8rem;
        font-weight: 800;
        color: white;
        font-family: monospace;
        line-height: 1;
    }
    .cd-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255,255,255,0.7);
        margin-top: 0.35rem;
    }
    .cd-sep {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--kente-gold);
        line-height: 1;
    }
    .countdown-footnote {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.75);
        margin-top: 0.85rem;
    }

    .value-pills-row {
        display: flex;
        justify-content: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }
    .value-pill {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        font-size: 0.82rem;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        backdrop-filter: blur(6px);
    }

    /* Stepper Header */
    .stepper-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2.5rem;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 1rem;
        position: relative;
    }
    .stepper-step {
        flex: 1;
        text-align: center;
        font-weight: 600;
        color: #cbd5e1;
        font-size: 0.95rem;
    }
    .stepper-step.active {
        color: var(--primary-color);
    }
    .stepper-step .step-num {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.4rem;
        font-weight: 700;
        transition: all 0.2s;
    }
    .stepper-step.active .step-num {
        background: var(--primary-color);
        color: white;
    }

    /* Pass Cards Grid */
    .pass-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(310px, 1fr));
        gap: 1.75rem;
        margin-bottom: 2.5rem;
    }
    .promo-card {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 2rem 1.75rem;
        display: flex;
        flex-direction: column;
        transition: all 0.25s ease;
        position: relative;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    }
    .promo-card:hover {
        border-color: var(--primary-color);
        box-shadow: 0 8px 25px rgba(22, 101, 52, 0.12);
        transform: translateY(-2px);
    }
    .promo-regular {
        border-color: #cbd5e1;
    }
    .promo-pricing-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
        margin: 1.25rem 0;
    }
    .promo-pricing-box .price-usd {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--primary-color);
        line-height: 1;
    }
    .promo-pricing-box .price-kes {
        font-size: 1.2rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 0.35rem;
    }
    .promo-features-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex: 1;
    }
    .feature-item {
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        font-size: 0.92rem;
        color: #334155;
        line-height: 1.5;
    }
    .promo-counter-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.25rem;
        border-top: 1px solid #e2e8f0;
    }
    .ticket-counter {
        display: flex;
        align-items: center;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        overflow: hidden;
        background: white;
        height: 42px;
    }
    .ticket-counter .qty-btn {
        width: 44px;
        height: 42px;
        background: #f1f5f9;
        border: none;
        cursor: pointer;
        font-weight: bold;
        font-size: 1.2rem;
        color: #334155;
        transition: background 0.15s;
    }
    .ticket-counter .qty-btn:hover {
        background: #e2e8f0;
    }
    .ticket-counter input[type="number"] {
        width: 50px;
        height: 42px;
        text-align: center;
        border: none;
        font-weight: 700;
        font-size: 1.1rem;
        pointer-events: none;
    }

    /* Subtotal Bar */
    .subtotal-bar {
        background: white;
        padding: 1.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* Form & Checkout Layout */
    .checkout-layout-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }
    .checkout-main-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: var(--border-radius-lg);
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.45rem;
        color: #334155;
        font-size: 0.95rem;
    }
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-family: var(--font-body);
        font-size: 16px; /* Prevents auto-zoom on iOS */
        transition: all 0.2s;
        background: white;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.1);
    }
    .sidebar-sticky-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: var(--border-radius-lg);
        padding: 1.5rem;
        position: sticky;
        top: 100px;
    }

    /* Payment Labels */
    .payment-label-card {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        border: 2px solid #cbd5e1;
        border-radius: 8px;
        cursor: pointer;
        background: white;
        transition: all 0.2s;
    }
    #label_paystack {
        border-color: var(--primary-color);
        background: #f8fafc;
    }

    /* Copy chip */
    .copy-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.15rem 0.55rem;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 4px;
        background: #e2e8f0;
        color: #334155;
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid #cbd5e1;
        margin-left: 0.5rem;
    }
    .copy-chip:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Checkout Notice Modal */
    .checkout-notice-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1050;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 1rem;
    }
    .checkout-notice-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
    }
    .checkout-notice-card {
        position: relative;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        max-width: 480px;
        width: 100%;
        padding: 2rem 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    .checkout-notice-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: none;
        border: none;
        color: #334155;
        font-size: 1.25rem;
        cursor: pointer;
    }
    .checkout-notice-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #f0f9ff;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: #0c4a6e;
    }
    .checkout-notice-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
        text-align: center;
    }
    .checkout-notice-message {
        font-size: 1rem;
        color: #334155;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    .checkout-notice-button {
        display: block;
        width: 100%;
        padding: 0.75rem;
        background: var(--primary-color);
        color: white;
        font-weight: 700;
        text-align: center;
        border-radius: 8px;
        transition: background 0.2s;
        border: none;
        cursor: pointer;
    }
    .checkout-notice-button:hover {
        background: #166534;
    }

    /* Mobile Responsive Breakpoints */
    @media (max-width: 991px) {
        .checkout-layout-grid {
            grid-template-columns: 1fr !important;
            gap: 1.5rem !important;
        }
        .sidebar-sticky-box {
            position: static !important;
            top: auto !important;
            margin-top: 1.5rem !important;
        }
    }

    @media (max-width: 768px) {
        .final-call-hero {
            padding: 7.5rem 1rem 3rem !important;
        }
        .countdown-grid {
            gap: 0.3rem !important;
        }
        .cd-box {
            min-width: 52px !important;
            padding: 0.5rem 0.5rem !important;
        }
        .cd-number {
            font-size: 1.4rem !important;
        }
        .cd-label {
            font-size: 0.65rem !important;
        }
        .cd-sep {
            font-size: 1.2rem !important;
        }
        .pass-cards-grid {
            grid-template-columns: 1fr !important;
            gap: 1.25rem !important;
        }
        .promo-card {
            padding: 1.5rem 1.25rem !important;
        }
        .subtotal-bar {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 1.25rem !important;
            padding: 1.25rem 1rem !important;
        }
        .subtotal-bar button {
            width: 100% !important;
            text-align: center !important;
        }
    }

    @media (max-width: 640px) {
        .form-grid-2 {
            grid-template-columns: 1fr !important;
            gap: 0.85rem !important;
            margin-bottom: 0.85rem !important;
        }
        .stepper-header {
            margin-bottom: 1.5rem !important;
            padding-bottom: 0.75rem !important;
        }
        .stepper-step {
            font-size: 0.72rem !important;
        }
        .stepper-step .step-num {
            width: 26px !important;
            height: 26px !important;
            font-size: 0.8rem !important;
            margin-bottom: 0.25rem !important;
        }
        .checkout-main-card {
            padding: 1.25rem 1rem !important;
        }
        .payment-label-card {
            padding: 1rem !important;
        }
    }
</style>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    let cart = {};
    let subtotalUsd = 0;
    let subtotalKes = 0;

    // Live countdown timer until Nov 25th 2026 23:59:59 EAT (UTC+3 = UTC 20:59:59)
    const deadlineTimestamp = <?php echo ($targetTimestamp * 1000); ?>;
    
    function updateCountdownTicker() {
        const now = new Date().getTime();
        const diff = deadlineTimestamp - now;

        if (diff <= 0) {
            document.getElementById('cd_days').innerText = "00";
            document.getElementById('cd_hours').innerText = "00";
            document.getElementById('cd_mins').innerText = "00";
            document.getElementById('cd_secs').innerText = "00";
            return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const secs = Math.floor((diff % (1000 * 60)) / 1000);

        document.getElementById('cd_days').innerText = String(days).padStart(2, '0');
        document.getElementById('cd_hours').innerText = String(hours).padStart(2, '0');
        document.getElementById('cd_mins').innerText = String(mins).padStart(2, '0');
        document.getElementById('cd_secs').innerText = String(secs).padStart(2, '0');
    }
    setInterval(updateCountdownTicker, 1000);
    updateCountdownTicker();

    function copyFinalText(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';
            btn.style.background = '#166534';
            btn.style.color = '#ffffff';
            setTimeout(() => {
                btn.innerHTML = orig;
                btn.style.background = '';
                btn.style.color = '';
            }, 2000);
        });
    }

    function togglePaymentMethod(method) {
        document.getElementById('section_paystack').style.display = method === 'paystack' ? 'block' : 'none';
        document.getElementById('section_manual').style.display = method === 'manual' ? 'block' : 'none';
        
        document.getElementById('label_paystack').style.borderColor = method === 'paystack' ? 'var(--primary-color)' : '#cbd5e1';
        document.getElementById('label_paystack').style.background = method === 'paystack' ? '#f8fafc' : 'white';
        
        document.getElementById('label_manual').style.borderColor = method === 'manual' ? 'var(--primary-color)' : '#cbd5e1';
        document.getElementById('label_manual').style.background = method === 'manual' ? '#f8fafc' : 'white';
        
        const btn = document.getElementById('submitBtn');
        if (method === 'paystack') {
            btn.innerHTML = '<i class="fa-solid fa-lock"></i> Pay Securely with Paystack';
            btn.style.backgroundColor = '#09a5db';
            btn.style.borderColor = '#09a5db';
        } else {
            btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit Order & Details';
            btn.style.backgroundColor = 'var(--primary-color)';
            btn.style.borderColor = 'var(--primary-color)';
        }
    }

    function updateFinalQty(id, delta) {
        const input = document.getElementById('qty_' + id);
        let val = parseInt(input.value) + delta;
        if(val < 0) val = 0;
        const max = parseInt(input.getAttribute('max')) || 99;
        if(val > max) val = max;
        input.value = val;
        
        const name = document.getElementById('name_' + id).value;
        const priceUsd = parseFloat(document.getElementById('price_usd_' + id).value);
        const priceKes = parseFloat(document.getElementById('price_kes_' + id).value);
        
        if (val > 0) {
            cart[id] = { name, priceUsd, priceKes, qty: val };
        } else {
            delete cart[id];
        }
        
        
        recalculateFinalTotals();
    }

    function recalculateFinalTotals() {
        subtotalUsd = 0;
        subtotalKes = 0;
        let sidebarHtml = '';
        
        for (const [id, item] of Object.entries(cart)) {
            const itemTotalUsd = item.priceUsd * item.qty;
            const itemTotalKes = item.priceKes * item.qty;
            subtotalUsd += itemTotalUsd;
            subtotalKes += itemTotalKes;
            
            sidebarHtml += `
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.92rem;">
                    <div><span style="font-weight: 700;">${item.qty}x</span> ${item.name}</div>
                    <div style="font-weight: 700;">$${itemTotalUsd.toFixed(2)}</div>
                </div>
            `;
        }
        
        if (Object.keys(cart).length === 0) {
            sidebarHtml = '<div style="color: #94a3b8; font-size: 0.9rem; font-style: italic;">No passes selected.</div>';
            document.getElementById('btn-next-1').disabled = true;
            document.getElementById('btn-next-1').style.opacity = '0.5';
            document.getElementById('btn-next-1').style.cursor = 'not-allowed';
        } else {
            document.getElementById('btn-next-1').disabled = false;
            document.getElementById('btn-next-1').style.opacity = '1';
            document.getElementById('btn-next-1').style.cursor = 'pointer';
        }
        
        document.getElementById('step1_total_usd').innerText = subtotalUsd.toFixed(2);
        document.getElementById('step1_total_kes').innerText = subtotalKes.toFixed(2);
        
        document.getElementById('sidebar_cart_items').innerHTML = sidebarHtml;
        document.getElementById('sidebar_subtotal_usd').innerText = subtotalUsd.toFixed(2);
        
        applyDiscounts();
        updateStudentRequirements();
    }

    function applyDiscounts() {
        let discountUsd = parseFloat(document.getElementById('discount_usd_val').value) || 0;
        let discountKes = parseFloat(document.getElementById('discount_kes_val').value) || 0;
        
        if (discountUsd > subtotalUsd) discountUsd = subtotalUsd;
        if (discountKes > subtotalKes) discountKes = subtotalKes;
        
        if (discountUsd > 0) {
            document.getElementById('discount_row').style.display = 'flex';
            document.getElementById('sidebar_discount_usd').innerText = discountUsd.toFixed(2);
        } else {
            document.getElementById('discount_row').style.display = 'none';
        }
        
        const finalUsd = subtotalUsd - discountUsd;
        const finalKes = subtotalKes - discountKes;
        
        document.getElementById('sidebar_total_usd').innerText = finalUsd.toFixed(2);
        document.getElementById('sidebar_total_kes').innerText = finalKes.toFixed(2);
        document.getElementById('final_total_usd').innerText = finalUsd.toFixed(2);
        document.getElementById('final_total_kes').innerText = finalKes.toFixed(2);
    }

    function applyPromo() {
        const code = document.getElementById('promo_code_input').value.trim();
        const msgBox = document.getElementById('promo_msg');
        if (!code) {
                                                                                         msgBox.innerHTML = '<span style="color:#ef4444;">Enter a code</span>';
            return;
        }
        msgBox.innerHTML = '<span style="color:#64748b;">Checking...</span>';
        
        fetch('ajax_ticket_order.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'action=validate_promo&code=' + encodeURIComponent(code)
        })
        .then(r => r.json())
        .then(data => {
            if (data.valid) {
                msgBox.innerHTML = '<span style="color:#16a34a;">Promo code applied!</span>';
                document.getElementById('discount_usd_val').value = data.discount_usd;
                document.getElementById('discount_kes_val').value = data.discount_kes;
                applyDiscounts();
            } else {
                msgBox.innerHTML = '<span style="color:#ef4444;">Invalid or expired code</span>';
                document.getElementById('discount_usd_val').value = 0;
                document.getElementById('discount_kes_val').value = 0;
                applyDiscounts();
            }
        }).catch(err => {
            msgBox.innerHTML = '<span style="color:#ef4444;">Error checking code</span>';
        });
    }

    function toggleFinalPassport() {
        const val = document.getElementById('visa_required').value;
        const passportField = document.getElementById('passport_field');
        if(val === '1') {
            passportField.style.display = 'block';
            document.getElementById('passport_number').required = true;
        } else {
            passportField.style.display = 'none';
            document.getElementById('passport_number').required = false;
        }
    }

    function nextStep(step) {
        document.querySelectorAll('.stepper-panel').forEach(p => { p.style.display = 'none'; p.classList.remove('active'); });
        const target = document.getElementById('step-' + step);
        target.style.display = 'block';
        setTimeout(() => target.classList.add('active'), 10);
        
        // Update nav dots
        for(let i=1; i<=4; i++) {
            const nav = document.getElementById('step-nav-' + i);
            const num = nav.querySelector('.step-num');
            if(i < step) {
                nav.style.color = 'var(--primary-color)';
                num.style.background = 'var(--primary-color)';
                num.style.color = 'white';
                num.innerHTML = '<i class="fa-solid fa-check"></i>';
            } else if (i === step) {
                nav.style.color = 'var(--primary-color)';
                num.style.background = 'var(--primary-color)';
                num.style.color = 'white';
                num.innerHTML = i;
            } else {
                nav.style.color = '#cbd5e1';
                num.style.background = '#e2e8f0';
                num.style.color = '#64748b';
                num.innerHTML = i;
            }
        }
        
        const headerElem = document.querySelector('.stepper-header');
        if(headerElem) {
            window.scrollTo({top: headerElem.offsetTop - 120, behavior: 'smooth'});
        }
    }

    function validateFinalStep2AndProceed() {
        const requiredFields = ['first_name', 'last_name', 'email', 'phone', 'organization', 'country'];
        let valid = true;
        requiredFields.forEach(f => {
            const el = document.getElementById(f);
            if(!el.value.trim()) {
                el.style.borderColor = '#ef4444';
                valid = false;
            } else {
                el.style.borderColor = '#cbd5e1';
            }
        });
        
        if (document.getElementById('visa_required').value === '1') {
            const pass = document.getElementById('passport_number');
            if(!pass.value.trim()) {
                pass.style.borderColor = '#ef4444';
                valid = false;
            }
        }
        
        const studentFields = ['student_institution', 'student_id_number', 'student_id_proof'];
        const isStudentPassSelected = Object.keys(cart).some(id => id === '102' && cart[id].qty > 0);
        
        if (isStudentPassSelected) {
            studentFields.forEach(f => {
                const el = document.getElementById(f);
                if(!el.value.trim()) {
                    el.style.borderColor = '#ef4444';
                    valid = false;
                } else {
                    el.style.borderColor = '#cbd5e1';
                }
            });
        }

        if (isStudentCartSelected()) {
            if (!validateStudentEmailRealtime()) valid = false;

            const institution = document.getElementById('student_institution');
            const studentId = document.getElementById('student_id_number');
            const proof = document.getElementById('student_id_proof');

            if (!institution.value.trim()) {
                institution.style.borderColor = '#ef4444';
                valid = false;
            } else {
                institution.style.borderColor = '#cbd5e1';
            }
            if (!studentId.value.trim()) {
                studentId.style.borderColor = '#ef4444';
                valid = false;
            } else {
                studentId.style.borderColor = '#cbd5e1';
            }
            if (!proof.files.length) {
                proof.style.borderColor = '#ef4444';
                valid = false;
            } else if (proof.files[0].size > 5 * 1024 * 1024) {
                proof.style.borderColor = '#ef4444';
                openCheckoutNotice('File Too Large', 'The student ID/proof file must be 5 MB or smaller.', 'fa-file-circle-exclamation', true);
                valid = false;
            } else {
                proof.style.borderColor = '#cbd5e1';
            }

            if (!valid) {
                openCheckoutNotice('Student Pass Verification Required', 'Please use an official university email address. Personal email providers such as Gmail, Yahoo, Outlook, and iCloud are not accepted.<br><br>You also need your institution name, student ID number, and proof-of-enrollment document.', 'fa-graduation-cap', true);
            }
        }

        if (document.getElementById('visa_required').value === '1') {
            const pass = document.getElementById('passport_number');
            if(!pass.value.trim()) {
                pass.style.borderColor = '#ef4444';
                valid = false;
            }
        }
        
        if(valid) {
            nextStep(3);
        } else if (!isStudentCartSelected()) {
            openCheckoutNotice('Required Information Missing', 'Please complete all fields marked with an asterisk before continuing.', 'fa-circle-exclamation', true);
        }
    }

    document.getElementById('finalCallForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        document.getElementById('loaderOverlay').style.display = 'flex';
        
        const formData = new FormData(this);
        formData.append('action', 'submit_order');
        formData.append('subtotal_usd', subtotalUsd);
        formData.append('subtotal_kes', subtotalKes);
        
        const paymentMethod = formData.get('payment_method');
        
        fetch('ajax_ticket_order.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loaderOverlay').style.display = 'none';
            if(data.success && data.total_kes > 0 && paymentMethod === 'paystack') {
                // Initialize Paystack Inline popup
                let handler = PaystackPop.setup({
                    key: '<?php echo htmlspecialchars($app_settings["paystack_public_key"] ?? ""); ?>',
                    email: data.email,
                    amount: data.total_kes * 100, // cents/kobo
                    currency: 'KES',
                    ref: data.order_ref,
                    callback: function(response) {
                        // verify the transaction with backend
                        document.getElementById('loaderOverlay').style.display = 'flex';
                        let verifyForm = new FormData();
                        verifyForm.append('reference', response.reference);
                        
                        fetch('ajax_verify_payment.php', {
                            method: 'POST',
                            body: verifyForm
                        })
                        .then(res => res.json())
                        .then(verifyData => {
                            document.getElementById('loaderOverlay').style.display = 'none';
                            if (verifyData.success) {
                                document.getElementById('success_order_ref').innerText = data.order_ref;
                                document.getElementById('success_subtitle').innerText = "Your payment was successful and your summit pass is confirmed! A confirmation email with your e-ticket has been sent to you.";
                                document.getElementById('success_next_steps_title').innerText = "What's Next?";
                                document.getElementById('success_next_steps_list').innerHTML = "<li>Check your inbox for your final confirmation and e-ticket badge.</li><li>Present your e-ticket at the summit registration desk in Nairobi.</li><li>Prepare for the summit!</li>";
                                nextStep(4);
                            } else {
                                openCheckoutNotice('Payment Verification', 'Payment verification notice: ' + verifyData.message, 'fa-circle-exclamation', true);
                            }
                        })
                        .catch(err => {
                            document.getElementById('loaderOverlay').style.display = 'none';
                            openCheckoutNotice('Verification Error', 'An error occurred during payment verification. Please contact support.', 'fa-triangle-exclamation', true);
                        });
                    },
                    onClose: function() {
                        openCheckoutNotice('Payment Cancelled', 'The payment window was closed. You can try again by clicking “Pay Securely with Paystack”.', 'fa-circle-xmark', true);
                    }
                });
                handler.openIframe();
            } else if (data.success) {
                // Direct Bank Transfer or Manual M-PESA
                document.getElementById('success_order_ref').innerText = data.order_ref;
                if (data.is_student) document.getElementById('student_success_box').style.display = 'block';

                const proofSubmitted = data.payment_status === 'proof_uploaded';
                const ticketButton = document.getElementById('btn_view_ticket');
                ticketButton.style.display = 'none';

                if (data.total_kes <= 0) {
                    document.getElementById('success_subtitle').innerText = "Your order has been successfully received.";
                    document.getElementById('success_next_steps_title').innerText = "Next Steps:";
                    document.getElementById('success_next_steps_list').innerHTML = "<li>Check your email for the final confirmation.</li><li>Present your order reference at the summit registration desk.</li>";
                } else if (proofSubmitted) {
                    document.getElementById('success_subtitle').innerText = "Order successfully received. We’ll get back to you after confirming your payment by email.";
                    document.getElementById('success_next_steps_title').innerText = "What Happens Next:";
                    document.getElementById('success_next_steps_list').innerHTML = "<li>Your receipt or transaction code is now under verification.</li><li>Once confirmed, we will email you the link to download your e-ticket.</li><li>Please keep order reference " + data.order_ref + " for your records.</li>";
                } else {
                    document.getElementById('success_subtitle').innerText = "Your booking has been received, but payment verification is still outstanding.";
                    document.getElementById('success_next_steps_title').innerText = "Next Steps:";
                    document.getElementById('success_next_steps_list').innerHTML = "<li>Complete your bank transfer or M-PESA payment using order reference " + data.order_ref + " as the narration.</li><li>Use the payment verification link provided in your email to upload your receipt or transaction code.</li><li>After verification, we will email you the link to download your e-ticket.</li>";
                }
                nextStep(4);
            } else {
                openCheckoutNotice('Notice', data.message, 'fa-circle-exclamation', true);
            }
        })
        .catch(error => {
            document.getElementById('loaderOverlay').style.display = 'none';
            openCheckoutNotice('Error', 'An unexpected error occurred. Please try again.', 'fa-circle-exclamation', true);
        });
    });

    // Auto-select pass if query parameter ?pass=student or ?pass=regular is passed
    (function handleInitialSelection() {
        const urlParams = new URLSearchParams(window.location.search);
        const passParam = (urlParams.get('pass') || '').toLowerCase();
        
        let targetId = null;
        document.querySelectorAll('input[id^="name_"]').forEach(el => {
            const id = el.id.replace('name_', '');
            const nameVal = el.value.toLowerCase();
            if (passParam === 'student' && nameVal.includes('student')) {
                targetId = id;
            } else if ((passParam === 'regular' || passParam === 'delegate') && !nameVal.includes('student')) {
                targetId = id;
            }
        });

        if (targetId) {
            updateFinalQty(targetId, 1);
        }
    })();

    function isStudentCartSelected() {
        return Object.values(cart).some(item => /student/i.test(item.name));
    }

    function validateStudentEmailRealtime() {
        const emailInput = document.getElementById('email');
        const errorBox = document.getElementById('email_student_error');
        if (!isStudentCartSelected()) {
            errorBox.style.display = 'none';
            emailInput.style.borderColor = '#cbd5e1';
            return true;
        }

        const email = emailInput.value.trim().toLowerCase();
        const domain = email.includes('@') ? email.split('@').pop() : '';
        const personalDomains = ['gmail.com','googlemail.com','yahoo.com','hotmail.com','outlook.com','live.com','icloud.com','me.com','aol.com','protonmail.com','proton.me','zoho.com','gmx.com','mail.com','yandex.com','qq.com','163.com'];
        const institutional = /(^|\.)(edu(\.[a-z]{2})?|ac\.[a-z]{2}|edu\.au|university|schule)($|\.)/.test(domain) || domain.endsWith('.edu') || domain.includes('.edu.') || domain.includes('.ac.');

        if (!email || !institutional || personalDomains.includes(domain)) {
            errorBox.style.display = 'block';
            errorBox.textContent = 'Use an official university or institution email ending in .edu or a recognized academic .ac.* domain. Personal email providers are not allowed.';
            emailInput.style.borderColor = '#dc2626';
            return false;
        }

        errorBox.style.display = 'none';
        emailInput.style.borderColor = '#16a34a';
        return true;
    }

    function updateStudentRequirements() {
        const active = isStudentCartSelected();
        document.getElementById('student_verification_alert').style.display = active ? 'block' : 'none';
        document.getElementById('student_credentials_box').style.display = active ? 'block' : 'none';
        document.getElementById('email_label').textContent = active ? 'Official Student Email Address *' : 'Email Address *';
        ['student_institution','student_id_number','student_id_proof'].forEach(id => {
            document.getElementById(id).required = active;
        });
        validateStudentEmailRealtime();
    }

    // Initial call to set student requirements visibility
    updateStudentRequirements();

    function openCheckoutNotice(title, message, iconClass = 'fa-graduation-cap', error = false) {
        const modal = document.getElementById('checkoutNoticeModal');
        document.getElementById('checkoutNoticeTitle').textContent = title;
        document.getElementById('checkoutNoticeMessage').innerHTML = message;
        const icon = document.getElementById('checkoutNoticeIcon');
        icon.className = 'checkout-notice-icon' + (error ? ' error' : '');
        icon.innerHTML = '<i class="fa-solid ' + iconClass + '"></i>';
        modal.style.display = 'flex';
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeCheckoutNotice() {
        const modal = document.getElementById('checkoutNoticeModal');
        modal.classList.remove('active');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') closeCheckoutNotice();
    });
</script>

<?php include 'includes/footer.php'; ?>
