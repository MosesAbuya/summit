<?php
include 'includes/header.php'; 
?>

<div class="page-header" style="background: linear-gradient(rgba(22, 101, 52, 0.85), rgba(22, 101, 52, 0.9)), url('assets/hero-bg.png') center/cover; padding: 6rem 0; text-align: center; color: white;">
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
                            <p style="color: var(--text-muted); margin: 0;">General: info@jitoleegoodfriendsfoundation.org<br>Logistics: logistics@summitafrica.org</p>
                        </div>
                    </div>
                    
                    <div class="contact-method" style="display: flex; gap: 1.5rem;">
                        <div style="font-size: 2rem; color: var(--secondary-color);"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <h4>Phone / WhatsApp</h4>
                            <p style="color: var(--text-muted); margin: 0;"><a href="tel:+254724408810" style="color: var(--text-muted);">+254 724 408810</a></p>
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
                    <form id="contactForm" style="background: white; padding: 3rem; border-radius: var(--border-radius-lg); border: 1px solid #e2e8f0; box-shadow: var(--box-shadow); position: relative;">
                        <h3 style="margin-bottom: 1rem; font-size: 1.8rem; color: var(--text-main);">Send a Message</h3>
                        
                        <!-- Styled Popup Container -->
                        <div id="formStatus" style="display: none; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid transparent;"></div>
                        
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
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-lg" style="width: 100%;">Submit Enquiry</button>
                        </div>
                    </form>
                    
                    <script>
                        document.getElementById('contactForm').addEventListener('submit', function(e) {
                            e.preventDefault();
                            
                            const form = this;
                            const statusDiv = document.getElementById('formStatus');
                            const btn = document.getElementById('submitBtn');
                            
                            btn.disabled = true;
                            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';
                            
                            const formData = new FormData(form);
                            
                            fetch('ajax_contact.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                statusDiv.style.display = 'block';
                                if (data.status === 'success') {
                                    statusDiv.style.backgroundColor = '#dcfce7';
                                    statusDiv.style.color = '#166534';
                                    statusDiv.style.borderColor = '#bbf7d0';
                                    statusDiv.innerHTML = '<strong><i class="fa-solid fa-check-circle"></i> Success!</strong> ' + data.message;
                                    form.reset();
                                } else {
                                    statusDiv.style.backgroundColor = '#fee2e2';
                                    statusDiv.style.color = '#991b1b';
                                    statusDiv.style.borderColor = '#fecaca';
                                    statusDiv.innerHTML = '<strong><i class="fa-solid fa-triangle-exclamation"></i> Error:</strong> ' + data.message;
                                }
                            })
                            .catch(error => {
                                statusDiv.style.display = 'block';
                                statusDiv.style.backgroundColor = '#fee2e2';
                                statusDiv.style.color = '#991b1b';
                                statusDiv.style.borderColor = '#fecaca';
                                statusDiv.innerHTML = '<strong><i class="fa-solid fa-triangle-exclamation"></i> Error:</strong> Could not connect to server.';
                            })
                            .finally(() => {
                                btn.disabled = false;
                                btn.innerHTML = 'Submit Enquiry';
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
