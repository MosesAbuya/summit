<?php
$message_status = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_form'])) {
    require 'includes/db.php';
    try {
        $stmt = $pdo->prepare("INSERT INTO enquiries (full_name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $_POST['full_name'],
            $_POST['email'],
            $_POST['subject'],
            $_POST['message']
        ]);
        $message_status = "success";
    } catch (PDOException $e) {
        $message_status = "error";
    }
}
include 'includes/header.php'; 
?>

<div class="page-header" style="background: linear-gradient(rgba(22, 101, 52, 0.85), rgba(22, 101, 52, 0.9)), url('https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069&auto=format&fit=crop') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">Contact Us</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">Reach out to the Jitolee Foundation concierge team for any general enquiries.</p>
    </div>
</div>

<main>
    <section class="section bg-white">
        <div class="container">
            <div class="grid-2-col">
                <!-- Left: Contact Details -->
                <div class="contact-info-panel" style="background: var(--bg-alt); padding: 3rem; border-radius: var(--border-radius-lg); height: fit-content;">
                    <h2 style="margin-bottom: 1.5rem; color: var(--primary-color);">Get In Touch</h2>
                    <p style="margin-bottom: 2.5rem; color: var(--text-main); font-size: 1.1rem;">For delegate tickets or sponsorship passes, please visit our dedicated <a href="register" style="color: var(--secondary-color); font-weight: 600; text-decoration: underline;">Registration Portal</a>.</p>
                    
                    <div class="contact-method" style="display: flex; gap: 1.5rem; margin-bottom: 2rem;">
                        <div style="font-size: 2rem; color: var(--secondary-color);"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <h4>Global Headquarters</h4>
                            <p style="color: var(--text-muted); margin: 0;">Jitolee Good Friends Foundation<br>14th Floor, Impact Tower<br>Nairobi, Kenya</p>
                        </div>
                    </div>
                    
                    <div class="contact-method" style="display: flex; gap: 1.5rem; margin-bottom: 2rem;">
                        <div style="font-size: 2rem; color: var(--secondary-color);"><i class="fa-regular fa-envelope"></i></div>
                        <div>
                            <h4>Email Desks</h4>
                            <p style="color: var(--text-muted); margin: 0;">General: info@summitafrica.org<br>Logistics: logistics@summitafrica.org</p>
                        </div>
                    </div>
                    
                    <div class="contact-method" style="display: flex; gap: 1.5rem;">
                        <div style="font-size: 2rem; color: var(--secondary-color);"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <h4>Phone Lines</h4>
                            <p style="color: var(--text-muted); margin: 0;">East Africa: +254 700 123 456<br>Intl Toll Free: +1 800 234 5678</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Clean Contact Form -->
                <div class="registration-form-panel">
                    <style>
                        .form-group { margin-bottom: 1.5rem; }
                        .form-label { display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-main); font-size: 0.95rem; }
                        .form-control { width: 100%; padding: 0.85rem 1rem; border: 1px solid #cbd5e1; border-radius: var(--border-radius-md); font-family: var(--font-body); font-size: 1rem; transition: border-color 0.3s; background: white; }
                        .form-control:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.1); }
                    </style>
                    <form action="contact" method="POST" style="background: white; padding: 3rem; border-radius: var(--border-radius-lg); border: 1px solid #e2e8f0; box-shadow: var(--box-shadow);">
                        <input type="hidden" name="contact_form" value="1">
                        
                        <?php if ($message_status === 'success'): ?>
                            <div style="text-align: center; padding: 2rem 0;">
                                <div style="width: 80px; height: 80px; background: #dcfce7; color: #166534; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 1.5rem; box-shadow: 0 4px 10px rgba(22, 101, 52, 0.2);">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <h3 style="margin-bottom: 1rem; font-size: 1.8rem; color: var(--text-main);">Message Sent!</h3>
                                <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 2rem;">Thank you for reaching out. Our concierge team will reply to your enquiry within 24 hours.</p>
                                <a href="index" class="btn btn-primary btn-lg">Return to Home</a>
                            </div>
                        <?php else: ?>
                            <h3 style="margin-bottom: 1rem; font-size: 1.8rem; color: var(--text-main);">Send a Message</h3>
                            
                            <?php if ($message_status === 'error'): ?>
                                <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #fecaca;">
                                    <strong>Error:</strong> Could not connect to the database. Ensure database.sql is imported.
                                </div>
                            <?php endif; ?>
                        
                        <div class="form-group">
                            <label class="form-label">Full Name <span style="color:red;">*</span></label>
                            <input type="text" name="full_name" class="form-control" required placeholder="Jane Doe">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email Address <span style="color:red;">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="jane@organization.org">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Subject Line <span style="color:red;">*</span></label>
                            <input type="text" name="subject" class="form-control" required placeholder="E.g., Event Itinerary Question">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Your Message <span style="color:red;">*</span></label>
                            <textarea class="form-control" name="message" required rows="5" placeholder="How can we help you today?"></textarea>
                        </div>

                        <div class="form-group" style="margin-top: 2rem;">
                            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">Submit Enquiry</button>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
