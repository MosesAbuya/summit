<?php include 'includes/header.php'; ?>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">Resource Center</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">Equipping partners and practitioners with actionable insights.</p>
    </div>
</div>

<main>
    <section id="whitepapers" class="section bg-white" style="scroll-margin-top: 8rem;">
        <div class="container" style="max-width: 900px; margin: 0 auto;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                <div style="width: 50px; height: 50px; background: var(--bg-alt); color: var(--primary-color); display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.5rem;">
                    <i class="fa-solid fa-file-pdf"></i>
                </div>
                <h2>Whitepapers & Research</h2>
            </div>
            
            <div style="display: grid; gap: 1.5rem;">
                <div style="border: 1px solid #e2e8f0; padding: 1.5rem; border-radius: var(--border-radius-md); display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="margin: 0 0 0.25rem 0;">The State of Corporate Volunteering in Sub-Saharan Africa</h4>
                        <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">Published: Jan 2026 • 24 Pages</p>
                    </div>
                    <button class="btn btn-outline" style="min-width: 120px;"><i class="fa-solid fa-download"></i> Download</button>
                </div>
                <!-- More items can follow here -->
            </div>
        </div>
    </section>

    <section id="casestudies" class="section section-alt" style="scroll-margin-top: 8rem;">
        <div class="container" style="max-width: 900px; margin: 0 auto;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                <div style="width: 50px; height: 50px; background: rgba(234,179,8,0.2); color: #a16207; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.5rem;">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h2>Featured Case Studies</h2>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div style="background: white; border-radius: var(--border-radius-md); overflow: hidden; box-shadow: var(--box-shadow);">
                    <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=800&auto=format&fit=crop" style="width: 100%; height: 200px; object-fit: cover;">
                    <div style="padding: 1.5rem;">
                        <span class="badge" style="background: var(--bg-alt); color: var(--primary-color);">Tech Deployment</span>
                        <h4 style="margin: 1rem 0 0.5rem 0;">Digitalizing Rural Clinics in Kenya</h4>
                        <p style="color: var(--text-main); font-size: 0.95rem; line-height: 1.5;">How pro-bono engineers deployed open-source health tracking to 50 rural facilities.</p>
                        <a href="#" style="color: var(--primary-color); font-weight: 600; text-decoration: none; display: inline-block; margin-top: 1rem;">Read Full Study &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="media-toolkit" class="section bg-white" style="scroll-margin-top: 8rem; margin-bottom: 4rem;">
        <div class="container" style="max-width: 900px; margin: 0 auto; text-align: center;">
            <div style="width: 80px; height: 80px; background: var(--bg-alt); color: var(--secondary-color); display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 2.5rem; margin: 0 auto 1.5rem;">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <h2>Partner Brand & Media Toolkit</h2>
            <p style="color: var(--text-main); font-size: 1.1rem; max-width: 600px; margin: 1rem auto 2rem;">Access official Summit logos, typography guidelines, and pre-approved marketing copy for your organization's PR channels.</p>
            <button class="btn btn-primary btn-lg"><i class="fa-solid fa-file-zipper"></i> Download Brand Asset Pack (.ZIP)</button>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
