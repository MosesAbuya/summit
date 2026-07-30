<?php include 'includes/header.php'; ?>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.95)), url('assets/past-summit/231201-131346.jpg') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">Partner With Us</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">Join the Global Pro Bono Practice ecosystem and make a lasting impact.</p>
    </div>
</div>

<main>
    <section class="section bg-light">
        <div class="container" style="max-width: 800px;">
            <div class="african-frame" style="background: white; border-radius: var(--border-radius-lg); padding: 3rem; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <h2 style="margin-bottom: 1rem; color: var(--primary-color);">Partnership Application Form</h2>
                <p style="color: var(--text-muted); margin-bottom: 2rem;">Please fill out the form below to express your interest in partnering with the Global Pro Bono Summit Africa.</p>
                
                <form action="process_partner_application.php" method="POST">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group">
                            <label for="org_name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Organization Name <span style="color: var(--terracotta);">*</span></label>
                            <input type="text" id="org_name" name="org_name" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: var(--border-radius-sm);">
                        </div>
                        <div class="form-group">
                            <label for="org_type" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Organization Type <span style="color: var(--terracotta);">*</span></label>
                            <select id="org_type" name="org_type" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: var(--border-radius-sm);">
                                <option value="">Select Type</option>
                                <option value="Corporate">Corporate / Enterprise</option>
                                <option value="NGO">NGO / Civil Society</option>
                                <option value="Government">Government / Public Sector</option>
                                <option value="Academia">Academic Institution</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group">
                            <label for="contact_name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Primary Contact Name <span style="color: var(--terracotta);">*</span></label>
                            <input type="text" id="contact_name" name="contact_name" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: var(--border-radius-sm);">
                        </div>
                        <div class="form-group">
                            <label for="contact_email" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email Address <span style="color: var(--terracotta);">*</span></label>
                            <input type="email" id="contact_email" name="contact_email" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: var(--border-radius-sm);">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="partnership_level" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Interested Partnership Level <span style="color: var(--terracotta);">*</span></label>
                        <select id="partnership_level" name="partnership_level" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: var(--border-radius-sm);">
                            <option value="">Select Level</option>
                            <option value="Headline">Headline Partner</option>
                            <option value="Strategic">Strategic Partner</option>
                            <option value="Session">Session Sponsor</option>
                            <option value="Exhibitor">Exhibitor</option>
                            <option value="In-Kind">In-Kind Contributor</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 2rem;">
                        <label for="message" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">How would you like to contribute? (Brief summary) <span style="color: var(--terracotta);">*</span></label>
                        <textarea id="message" name="message" rows="5" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: var(--border-radius-sm);"></textarea>
                    </div>

                    <div style="text-align: center;">
                        <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; max-width: 300px;">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
