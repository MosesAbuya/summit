<?php
$message_status = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_form'])) {
    require 'includes/db.php';
    try {
        $stmt = $pdo->prepare("INSERT INTO registrations (registration_type, first_name, last_name, email, phone, organization, country, passport, dietary_requirements, accessibility_needs) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['registration_type'],
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['organization'],
            $_POST['country'],
            $_POST['passport'],
            $_POST['dietary_requirements'],
            $_POST['accessibility_needs']
        ]);
        $message_status = "success";
    } catch (PDOException $e) {
        $message_status = "error";
    }
}
include 'includes/header.php'; 
?>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('assets/hero-bg.png') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">Registration & Support</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">Secure your pass, sponsor our mission, or support a local NGO.</p>
    </div>
</div>

<main>
    <section class="section bg-white" style="padding-bottom: 2rem;">
        <div class="container" style="max-width: 1100px; margin: 0 auto;">
            
            <div class="text-center" style="margin-bottom: 4rem;">
                <span class="section-eyebrow">Participation Options</span>
                <h2 style="font-size: 2.5rem; margin-top: 0.5rem; color: #0f172a;">Join The Movement</h2>
                <p class="lead-text" style="max-width: 700px; margin: 1rem auto 0; font-size: 1.1rem; color: var(--text-main);">The Global Pro-bono Summit facilitates attendance through direct delegate passes, corporate sponsorships, and philanthropic support tickets.</p>
            </div>

            <!-- Pricing / Tiers Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 5rem;">
                
                <!-- Support Ticket -->
                <div style="border: 1px solid #e2e8f0; border-radius: var(--border-radius-lg); padding: 2.5rem; background: white; text-align: left; box-shadow: var(--box-shadow); display: flex; flex-direction: column;">
                    <div style="background: var(--bg-alt); padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; color: var(--text-main); display: inline-block; margin-bottom: 1rem; align-self: flex-start;">DONATION</div>
                    <div style="font-size: 2.3rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem;">Custom</div>
                    <p style="color: var(--text-main); margin-bottom: 1.5rem; line-height: 1.6; flex-grow: 1;">Cannot attend but want to help? Your contribution directly subsidizes attendance for an African grassroots NGO leader.</p>
                    <ul class="feature-list" style="margin-bottom: 2rem; color: var(--text-muted); font-size: 0.95rem;">
                        <li><svg class="icon-check" viewBox="0 0 24 24" style="color: var(--primary-color);"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> Sponsors 1 NGO Delegate</li>
                        <li><svg class="icon-check" viewBox="0 0 24 24" style="color: var(--primary-color);"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> Post-Summit Impact Report</li>
                        <li><svg class="icon-check" viewBox="0 0 24 24" style="color: var(--primary-color);"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> Recognition on Website</li>
                    </ul>
                    <button class="btn btn-outline" style="width: 100%; border-color: #cbd5e1; color: var(--text-main);" onclick="document.getElementById('typeSelect').value='Support Ticket (Donation)'; document.getElementById('regForm').scrollIntoView({behavior: 'smooth'})">Support an NGO</button>
                </div>

                <!-- Delegate Pass -->
                <div style="border: 2px solid var(--primary-color); border-radius: var(--border-radius-lg); padding: 2.5rem; background: var(--bg-alt); text-align: left; box-shadow: 0 20px 25px -5px rgba(22, 101, 52, 0.1), 0 10px 10px -5px rgba(22, 101, 52, 0.04); position: relative; overflow: hidden; transform: scale(1.03); z-index: 2; display: flex; flex-direction: column;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; background: var(--primary-color); color: white; text-align: center; font-size: 0.75rem; font-weight: 700; padding: 0.5rem; letter-spacing: 1px;">STANDARD ATTENDANCE</div>
                    <div style="background: rgba(22,101,52,0.1); padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; color: var(--primary-color); display: inline-block; margin-bottom: 1rem; align-self: flex-start; margin-top: 1rem;">DELEGATE PASS</div>
                    <div style="font-size: 2.3rem; font-weight: 800; color: var(--primary-color); margin-bottom: 0.5rem;">Upon App</div>
                    <p style="color: #334155; margin-bottom: 1.5rem; line-height: 1.6; flex-grow: 1;">Full-access 4-day pass including all plenary sessions, specialized workshops, and Gala dinner entry.</p>
                    <ul class="feature-list" style="margin-bottom: 2rem; color: #475569; font-size: 0.95rem;">
                        <li><svg class="icon-check" viewBox="0 0 24 24" style="color: var(--primary-color);"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> Priority Hotel Shuttle Access</li>
                        <li><svg class="icon-check" viewBox="0 0 24 24" style="color: var(--primary-color);"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> Automated Visa Letter processing</li>
                        <li><svg class="icon-check" viewBox="0 0 24 24" style="color: var(--primary-color);"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> Gala Dinner & Awards Access</li>
                    </ul>
                    <button class="btn btn-primary" style="width: 100%; box-shadow: 0 4px 6px rgba(22, 101, 52, 0.2);" onclick="document.getElementById('typeSelect').value='Standard Delegate Pass'; document.getElementById('regForm').scrollIntoView({behavior: 'smooth'})">Select Delegate Pass</button>
                </div>

                <!-- Corporate Partner -->
                <div style="border: 1px solid #e2e8f0; border-radius: var(--border-radius-lg); padding: 2.5rem; background: white; text-align: left; box-shadow: var(--box-shadow); display: flex; flex-direction: column;">
                    <div style="background: rgba(234,179,8,0.1); padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; color: #a16207; display: inline-block; margin-bottom: 1rem; align-self: flex-start;">SPONSORSHIP</div>
                    <div style="font-size: 2.3rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem;">Bespoke</div>
                    <p style="color: var(--text-main); margin-bottom: 1.5rem; line-height: 1.6; flex-grow: 1;">Align your brand with impact. Includes delegate passes, exhibition space, and global branding.</p>
                    <ul class="feature-list" style="margin-bottom: 2rem; color: var(--text-muted); font-size: 0.95rem;">
                        <li><svg class="icon-check" viewBox="0 0 24 24" style="color: var(--secondary-color);"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> Main Stage Branding</li>
                        <li><svg class="icon-check" viewBox="0 0 24 24" style="color: var(--secondary-color);"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> 5+ VIP Access Passes</li>
                        <li><svg class="icon-check" viewBox="0 0 24 24" style="color: var(--secondary-color);"><path d="M20 6L9 17l-5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg> NGO B2B Matchmaking</li>
                    </ul>
                    <button class="btn btn-outline" style="width: 100%; border-color: var(--secondary-color); color: #a16207;" onclick="document.getElementById('typeSelect').value='Corporate Sponsorship'; document.getElementById('regForm').scrollIntoView({behavior: 'smooth'})">Become a Partner</button>
                </div>
            </div>

        </div>
    </section>

    <section id="regForm" class="section bg-white border-y" style="padding-top: 2rem; scroll-margin-top: 2rem;">
        <div class="container" style="max-width: 800px; margin: 0 auto;">
            <!-- Massive Form -->
            <div class="registration-form-panel">
                <style>
                    .form-group { margin-bottom: 1.5rem; }
                    .form-label { display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-main); font-size: 0.95rem; }
                    .form-control { width: 100%; padding: 0.85rem 1rem; border: 1px solid #cbd5e1; border-radius: var(--border-radius-md); font-family: var(--font-body); font-size: 1rem; transition: border-color 0.3s; background: white; }
                    .form-control:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.1); }
                    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
                    @media(max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
                </style>
                <form action="register#regForm" method="POST" style="background: white; padding: 3rem; border-radius: var(--border-radius-lg); border: 1px solid #e2e8f0; box-shadow: var(--box-shadow);">
                    <input type="hidden" name="register_form" value="1">
                    
                    <?php if ($message_status === 'success'): ?>
                        <div style="text-align: center; padding: 4rem 0;">
                            <div style="width: 90px; height: 90px; background: #dcfce7; color: #166534; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto 1.5rem; box-shadow: 0 4px 15px rgba(22, 101, 52, 0.2);">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <h3 style="margin-bottom: 1rem; font-size: 2rem; color: var(--text-main);">Application Received!</h3>
                            <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 2.5rem; max-width: 500px; margin-left: auto; margin-right: auto; line-height: 1.6;">Your registration details have been securely transmitted to the Jitolee Foundation. Our team will review your application and contact you shortly.</p>
                            <a href="index" class="btn btn-primary btn-lg">Return to Home</a>
                        </div>
                    <?php else: ?>
                        <h3 style="margin-bottom: 1rem; font-size: 1.8rem; color: var(--text-main);">Global Delegate Portal</h3>
                        
                        <?php if ($message_status === 'error'): ?>
                            <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #fecaca;">
                                <strong>Database Error:</strong> Failed to save registration. Please ensure the backend database is imported.
                            </div>
                        <?php endif; ?>
                    
                    <div class="form-group">
                        <label class="form-label">Registration Type <span style="color:red;">*</span></label>
                        <select id="typeSelect" name="registration_type" class="form-control" required>
                            <option value="" disabled selected>Please select an option...</option>
                            <option value="Standard Delegate Pass">Standard Delegate Pass (Pending Review)</option>
                            <option value="Corporate Sponsorship">Corporate Sponsorship (Bespoke Application)</option>
                            <option value="Support Ticket (Donation)">Support Ticket (Custom Donation)</option>
                            <option value="Speaker Application">Speaker Application Submission</option>
                            <option value="Press & Media Pass">Press & Media Pass</option>
                        </select>
                    </div>

                    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 2rem 0;">

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name <span style="color:red;">*</span></label>
                            <input type="text" name="first_name" class="form-control" required placeholder="Jane">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name <span style="color:red;">*</span></label>
                            <input type="text" name="last_name" class="form-control" required placeholder="Doe">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Email Address <span style="color:red;">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="jane@organization.org">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone / WhatsApp</label>
                            <input type="tel" name="phone" class="form-control" placeholder="+123 456 7890">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Organization Name <span style="color:red;">*</span></label>
                            <input type="text" name="organization" class="form-control" required placeholder="E.g., UN, Acme Corp, Law Firm">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Country of Origin <span style="color:red;">*</span></label>
                            <input type="text" name="country" class="form-control" required placeholder="E.g., Nigeria">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Passport Number (For Visa Letters)</label>
                            <input type="text" name="passport" class="form-control" placeholder="Optional unless requesting Visa letter">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Dietary Requirements</label>
                            <select name="dietary_requirements" class="form-control">
                                <option>None</option>
                                <option>Vegetarian</option>
                                <option>Vegan</option>
                                <option>Halal</option>
                                <option>Kosher</option>
                                <option>Gluten-Free</option>
                                <option>Other (Specify below)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Accessibility Needs / Additional Info</label>
                        <textarea class="form-control" name="accessibility_needs" rows="3" placeholder="Please specify any specific accessibility requirements..."></textarea>
                    </div>

                    <div class="form-group" style="margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">Proceed to Secure Checkout</button>
                    </div>
                    <p style="font-size: 0.8rem; color: var(--text-muted); text-align: center; margin-top: 1rem;">Payments processed securely via global SSL. Read our Data Privacy Policy.</p>
                    
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
