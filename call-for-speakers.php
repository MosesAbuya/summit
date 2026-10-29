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
                            <p style="color: var(--text-muted); margin: 0;">info@globalsummitafrica.org</p>
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
                        .speaker-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; }
                        @media (max-width: 640px) {
                            .speaker-form-row { grid-template-columns: 1fr !important; }
                        }
                    </style>
                    <form id="speakerForm" style="background: white; padding: 3rem; border-radius: var(--border-radius-lg); border: 1px solid #e2e8f0; box-shadow: var(--box-shadow); position: relative;">
                        <h3 style="margin-bottom: 1rem; font-size: 1.8rem; color: var(--text-main);">Submit Abstract/Proposal</h3>
                        
                        <div id="formStatus" style="display: none; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid transparent;"></div>
                        
                        <!-- Hidden subject to route through the generic contact handler cleanly -->
                        <input type="hidden" name="subject" value="Speaker/Paper Proposal Submission">
                        
                        <div class="speaker-form-row">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">First Name <span style="color:red;">*</span></label>
                                <input type="text" name="first_name" id="speaker_first_name" class="form-control" required placeholder="Dr. Jane">
                            </div>
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">Last Name <span style="color:red;">*</span></label>
                                <input type="text" name="last_name" id="speaker_last_name" class="form-control" required placeholder="Doe">
                            </div>
                        </div>
                        
                        <div class="speaker-form-row">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">Email Address <span style="color:red;">*</span></label>
                                <input type="email" name="email" id="speaker_email" class="form-control" required placeholder="jane@university.edu">
                            </div>
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">Mobile Phone Number <span style="color:red;">*</span></label>
                                <input type="tel" name="phone" id="speaker_phone" class="form-control" required placeholder="+254 700 000000">
                            </div>
                        </div>

                        <div class="speaker-form-row">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">Organization / Institution <span style="color:red;">*</span></label>
                                <input type="text" name="organization" id="speaker_organization" class="form-control" required placeholder="University / Company / NGO">
                            </div>
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">Job Title / Role</label>
                                <input type="text" name="job_title" id="speaker_job_title" class="form-control" placeholder="e.g. Associate Professor / Director">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Presentation Title <span style="color:red;">*</span></label>
                            <input type="text" name="presentation_title" id="speaker_presentation_title" class="form-control" required placeholder="Title of your paper or talk">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Abstract / Overview <span style="color:red;">*</span></label>
                            <textarea class="form-control" name="message" id="speaker_message" required rows="6" placeholder="Provide a brief overview of your presentation, thematic area, and key takeaways..."></textarea>
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
                            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="margin-right: 0.5rem;"></i> Submitting...';
                            
                            const formData = new FormData(form);
                            const firstName = (formData.get('first_name') || '').trim();
                            const lastName = (formData.get('last_name') || '').trim();
                            const fullName = (firstName + ' ' + lastName).trim();
                            const email = (formData.get('email') || '').trim();
                            const phone = (formData.get('phone') || '').trim();
                            const organization = (formData.get('organization') || '').trim();
                            const jobTitle = (formData.get('job_title') || '').trim();
                            const title = (formData.get('presentation_title') || '').trim();
                            const originalMessage = (formData.get('message') || '').trim();
                            
                            // Ensure generic ajax_contact.php receives full_name and structured message
                            formData.set('full_name', fullName);
                            
                            let formattedMessage = "Presentation Title: " + title + "\n\n";
                            if (organization) formattedMessage += "Organization: " + organization + "\n";
                            if (jobTitle) formattedMessage += "Job Title: " + jobTitle + "\n";
                            if (phone) formattedMessage += "Phone: " + phone + "\n\n";
                            formattedMessage += "Abstract / Overview:\n" + originalMessage;
                            
                            formData.set('message', formattedMessage);
                            
                            fetch('ajax_contact.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    // Do not display success confirmation; show redirecting status and redirect
                                    statusDiv.style.display = 'block';
                                    statusDiv.style.backgroundColor = '#eff6ff';
                                    statusDiv.style.color = '#1d4ed8';
                                    statusDiv.style.borderColor = '#bfdbfe';
                                    statusDiv.innerHTML = '<div style="display: flex; align-items: center; gap: 0.75rem;"><i class="fa-solid fa-spinner fa-spin" style="font-size: 1.25rem;"></i> <div><strong>Redirecting to Registration...</strong><div style="font-size: 0.9rem; margin-top: 0.2rem; opacity: 0.9;">Please complete your speaker pass registration.</div></div></div>';
                                    
                                    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="margin-right: 0.5rem;"></i> Redirecting...';
                                    
                                    const params = new URLSearchParams({
                                        ticket: 'Speakers',
                                        first_name: firstName,
                                        last_name: lastName,
                                        email: email,
                                        phone: phone,
                                        organization: organization,
                                        job_title: jobTitle
                                    });
                                    
                                    for (const [key, value] of [...params.entries()]) {
                                        if (!value) params.delete(key);
                                    }
                                    
                                    setTimeout(() => {
                                        const targetPage = window.location.pathname.endsWith('.php') ? 'register.php' : 'register';
                                        window.location.href = targetPage + '?' + params.toString();
                                    }, 600);
                                } else {
                                    statusDiv.style.display = 'block';
                                    statusDiv.style.backgroundColor = '#fee2e2';
                                    statusDiv.style.color = '#991b1b';
                                    statusDiv.style.borderColor = '#fecaca';
                                    statusDiv.innerHTML = '<strong><i class="fa-solid fa-triangle-exclamation"></i> Error:</strong> ' + data.message;
                                    btn.disabled = false;
                                    btn.innerHTML = '<i class="fa-solid fa-paper-plane" style="margin-right: 0.5rem;"></i> Submit Proposal';
                                }
                            })
                            .catch(error => {
                                statusDiv.style.display = 'block';
                                statusDiv.style.backgroundColor = '#fee2e2';
                                statusDiv.style.color = '#991b1b';
                                statusDiv.style.borderColor = '#fecaca';
                                statusDiv.innerHTML = '<strong><i class="fa-solid fa-triangle-exclamation"></i> Error:</strong> Could not connect to server.';
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
