<?php
include 'includes/header.php'; 
?>

<div class="page-header" style="background: linear-gradient(rgba(22, 101, 52, 0.85), rgba(22, 101, 52, 0.9)), url('assets/hero-bg.png') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">Call for Papers & Speakers</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">Submit your papers, abstracts, and presentations on our thematic areas.</p>
    </div>
</div>

<main>
    <section class="section bg-white">
        <div class="container">
            <div class="grid-2-col">
                <!-- Left: Information -->
                <div class="contact-info-panel" style="background: var(--bg-alt); padding: 3rem; border-radius: var(--border-radius-lg); height: fit-content;">
                    <h2 style="margin-bottom: 1.5rem; color: var(--primary-color);">Become a Speaker</h2>
                    <p style="margin-bottom: 1.5rem; color: var(--text-main); font-size: 1.1rem;">We invite thought leaders, researchers, and practitioners to share their insights, papers, and presentations on our thematic areas and breakout sessions.</p>
                    
                    <div style="background: #fff7ed; border-left: 4px solid var(--terracotta); padding: 1.5rem; margin-bottom: 2rem; border-radius: 0 var(--border-radius-md) var(--border-radius-md) 0;">
                        <h4 style="color: #c2410c; margin-bottom: 0.5rem;"><i class="fa-solid fa-circle-info"></i> Important Notice</h4>
                        <p style="color: #9a3412; margin: 0; font-size: 0.95rem;">Please note that all speakers and presenters are expected to meet all their attendance and participation costs, including travel, accommodation, and summit registration.</p>
                    </div>

                    <h4 style="margin-bottom: 1rem; color: var(--text-main);">4.0 Thematic Priorities</h4>
                    <ul style="list-style-type: disc; padding-left: 1.5rem; color: var(--text-muted); line-height: 1.8; margin-bottom: 2rem;">
                        <li><strong>Poverty Reduction (SDG 1 & AU Asp. 1):</strong> Support microfinance training, property rights clinics, and enterprise mentoring.</li>
                        <li><strong>Education (SDG 4 & AU Asp. 1):</strong> Provide mentorship, tutoring, and digital learning support for out-of-school youth.</li>
                        <li><strong>Decent Work (SDG 8 & AU Asp. 1):</strong> Deliver skills workshops and entrepreneurship support for youth and SMEs.</li>
                        <li><strong>Climate Action (SDG 13 & AU Asp. 7):</strong> Support resilience planning, climate-smart agriculture, and adaptation solutions.</li>
                    </ul>

                    <div class="contact-method" style="display: flex; gap: 1.5rem;">
                        <div style="font-size: 2rem; color: var(--secondary-color);"><i class="fa-regular fa-envelope"></i></div>
                        <div>
                            <h4>Questions?</h4>
                            <p style="color: var(--text-muted); margin: 0;">program@summitafrica.org</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Application Form -->
                <div class="registration-form-panel">
                    <style>
                        .form-group { margin-bottom: 1.5rem; }
                        .form-label { display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-main); font-size: 0.95rem; }
                        .form-control { width: 100%; padding: 0.85rem 1rem; border: 1px solid #cbd5e1; border-radius: var(--border-radius-md); font-family: var(--font-body); font-size: 1rem; transition: border-color 0.3s; background: white; }
                        .form-control:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.1); }
                    </style>
                    <form id="speakerForm" style="background: white; padding: 3rem; border-radius: var(--border-radius-lg); border: 1px solid #e2e8f0; box-shadow: var(--box-shadow); position: relative;">
                        <h3 style="margin-bottom: 1rem; font-size: 1.8rem; color: var(--text-main);">Submit Abstract/Proposal</h3>
                        
                        <div id="formStatus" style="display: none; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid transparent;"></div>
                        
                        <!-- Hidden subject to route through the generic contact handler cleanly -->
                        <input type="hidden" name="subject" value="Speaker/Paper Proposal Submission">
                        
                        <div class="form-group">
                            <label class="form-label">Full Name <span style="color:red;">*</span></label>
                            <input type="text" name="full_name" class="form-control" required placeholder="Dr. Jane Doe">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email Address <span style="color:red;">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="jane@university.edu">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Presentation Title <span style="color:red;">*</span></label>
                            <input type="text" name="presentation_title" class="form-control" required placeholder="Title of your paper or talk">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Abstract / Overview <span style="color:red;">*</span></label>
                            <textarea class="form-control" name="message" required rows="6" placeholder="Provide a brief overview of your presentation, thematic area, and key takeaways..."></textarea>
                        </div>

                        <div class="form-group" style="margin-top: 2rem;">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-lg" style="width: 100%;"><i class="fa-solid fa-paper-plane" style="margin-right: 0.5rem;"></i> Submit Proposal</button>
                        </div>
                    </form>
                    
                    <script>
                        document.getElementById('speakerForm').addEventListener('submit', function(e) {
                            e.preventDefault();
                            
                            const form = this;
                            const statusDiv = document.getElementById('formStatus');
                            const btn = document.getElementById('submitBtn');
                            
                            btn.disabled = true;
                            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';
                            
                            // To map the presentation title into the message for the generic ajax_contact.php
                            const formData = new FormData(form);
                            const title = formData.get('presentation_title');
                            const originalMessage = formData.get('message');
                            
                            formData.set('message', "Presentation Title: " + title + "\n\nAbstract:\n" + originalMessage);
                            
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
                                    statusDiv.innerHTML = '<strong><i class="fa-solid fa-check-circle"></i> Success!</strong> Your proposal has been submitted successfully.';
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
                                btn.innerHTML = '<i class="fa-solid fa-paper-plane" style="margin-right: 0.5rem;"></i> Submit Proposal';
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
