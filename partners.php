<?php 
require 'includes/db.php';
$stmt_major = $pdo->query("SELECT * FROM partners WHERE is_major = 1 ORDER BY id ASC");
$major_partners = $stmt_major->fetchAll();

$stmt_minor = $pdo->query("SELECT * FROM partners WHERE is_major = 0 ORDER BY id ASC");
$minor_partners = $stmt_minor->fetchAll();

include 'includes/header.php'; 
?>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('assets/hero-bg.png') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">Our Partners</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">The global network making structured impact possible.</p>
    </div>
</div>

<main>
    <section class="section bg-white text-center">
        <div class="container">
            <span class="section-eyebrow">The Ecosystem</span>
            <h2>Global Pro Bono Network Alliances</h2>
            <span class="african-divider-sm center"></span>
            <p style="max-width: 800px; margin: 1.5rem auto 3rem; font-size: 1.1rem; line-height: 1.7; color: var(--text-main);">
                The Global Pro Bono Summit Africa is calling upon an international coalition of corporate entities, philanthropic trusts, and governmental bodies to join us. By becoming sponsors, your organization will play a critical role in actively closing the socioeconomic divide across the continent.
            </p>

            <div class="sponsor-tiers" style="margin-top: 3rem;">
                
                <?php if(count($major_partners) > 0): ?>
                <div class="tier" style="margin-bottom: 4rem;">
                    <h4 class="tier-name" style="color: #0f172a; font-size: 1.8rem; margin-bottom: 1.5rem;">Diamond & Platinum Partners</h4>
                    <div class="tier-logos" style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
                        <?php foreach($major_partners as $p): ?>
                            <?php if(!empty($p['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($p['image_url']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" style="max-height: 120px; max-width: 280px; object-fit: contain;">
                            <?php else: ?>
                                <div class="logo-box" style="width: 280px; height: 120px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; color: #64748b; background: white; border-radius: var(--border-radius-md); box-shadow: var(--box-shadow);"><?php echo htmlspecialchars($p['name']); ?></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(count($minor_partners) > 0): ?>
                <div class="tier" style="margin-bottom: 4rem;">
                    <h4 class="tier-name" style="color: #0f172a; font-size: 1.5rem; margin-bottom: 1.5rem;">Gold, Silver & Bronze Partners</h4>
                    <div class="tier-logos small" style="display: flex; justify-content: center; gap: 1.5rem; flex-wrap: wrap;">
                        <?php foreach($minor_partners as $p): ?>
                            <?php if(!empty($p['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($p['image_url']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" style="max-height: 100px; max-width: 200px; object-fit: contain;">
                            <?php else: ?>
                                <div class="logo-box" style="width: 200px; height: 100px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: 600; color: #94a3b8; background: white; border-radius: var(--border-radius-md);"><?php echo htmlspecialchars($p['name']); ?></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div style="margin-top: 5rem; text-align: left; max-width: 900px; margin-left: auto; margin-right: auto; padding: 2rem; background: #f8fafc; border-radius: var(--border-radius-lg); border-left: 4px solid var(--primary-color);">
                <h3 style="color: var(--primary-color); font-size: 1.8rem; margin-bottom: 1rem;">Sponsorship Packages</h3>
                <p style="color: var(--text-main); line-height: 1.6; margin-bottom: 2rem;">Every tier delivers unmatched ROI in reputation, talent, and impact.</p>
                <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 1rem;">
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-crown" style="color: #64748b; font-size: 1.25rem; margin-top: 4px;"></i>
                        <div>
                            <strong style="color: #0f172a; font-size: 1.1rem;">Platinum Sponsors (KES 5M)</strong> - Secures Naming Rights.
                        </div>
                    </li>
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-medal" style="color: #fbbf24; font-size: 1.25rem; margin-top: 4px;"></i>
                        <div>
                            <strong style="color: #0f172a; font-size: 1.1rem;">Gold Sponsors (KES 3M)</strong> - Lead Workshops.
                        </div>
                    </li>
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-medal" style="color: #94a3b8; font-size: 1.25rem; margin-top: 4px;"></i>
                        <div>
                            <strong style="color: #0f172a; font-size: 1.1rem;">Silver Sponsors (KES 1.5M)</strong> - Secures exhibition priority.
                        </div>
                    </li>
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fa-solid fa-medal" style="color: #b45309; font-size: 1.25rem; margin-top: 4px;"></i>
                        <div>
                            <strong style="color: #0f172a; font-size: 1.1rem;">Bronze Sponsors (KES 500K)</strong> - Registration Desks.
                        </div>
                    </li>
                </ul>
            </div>
            
            <div style="background-image: var(--pattern-kente); background-size: 40px 40px; background-color: var(--savannah-cream); padding: 4rem 2rem; border-radius: var(--border-radius-lg); margin-top: 4rem; text-align: left; border: 1px solid rgba(193,68,14,0.2);">
                <div class="grid-2-col align-center">
                    <div>
                        <h3 style="color: var(--primary-color); font-size: 1.8rem;">Become a Corporate Sponsor</h3>
                        <p style="margin-top: 1rem; color: var(--text-main); line-height: 1.6;">Align your brand with Africa's fastest-growing social impact movement. Sponsoring the Global Pro Bono Summit Africa not only fulfills your ESG targets but places your leadership directly in front of policymakers, global foundations, and key innovators.</p>
                        <a href="partner_application" class="btn btn-secondary" style="margin-top: 1.5rem;">Request Sponsorship Deck</a>
                    </div>
                    <div style="display: flex; justify-content: center;">
                        <div class="african-frame" style="max-width: 400px; width: 100%;">
                            <img src="assets/past-summit/231201-101415.jpg" style="width: 100%; border-radius: var(--border-radius-md); box-shadow: var(--box-shadow);" alt="Corporate Networking">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
