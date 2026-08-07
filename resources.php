<?php
require 'includes/db.php';

$stmt_whitepapers = $pdo->prepare("SELECT * FROM resources WHERE category = 'Whitepapers & Research' ORDER BY created_at DESC");
$stmt_whitepapers->execute();
$whitepapers = $stmt_whitepapers->fetchAll();

$stmt_casestudies = $pdo->prepare("SELECT * FROM resources WHERE category = 'Case Studies' ORDER BY created_at DESC");
$stmt_casestudies->execute();
$casestudies = $stmt_casestudies->fetchAll();

$stmt_media = $pdo->prepare("SELECT * FROM resources WHERE category = 'Media Toolkit' ORDER BY created_at DESC");
$stmt_media->execute();
$media = $stmt_media->fetchAll();

$stmt_historical = $pdo->prepare("SELECT * FROM resources WHERE category = 'Historical Report' ORDER BY title DESC");
$stmt_historical->execute();
$historical_reports = $stmt_historical->fetchAll();

include 'includes/header.php'; 
?>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('assets/hero-bg.png') center/cover; padding: 6rem 0; text-align: center; color: white;">
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
                <span class="african-divider-sm" style="margin: 0.5rem 0 1.5rem;"></span>
            </div>
            
            <div style="display: grid; gap: 1.5rem;">
                <?php if (count($whitepapers) > 0): ?>
                    <?php foreach($whitepapers as $wp): ?>
                    <div style="border: 1px solid #e2e8f0; padding: 1.5rem; border-radius: var(--border-radius-md); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div style="flex: 1; min-width: 250px;">
                            <h4 style="margin: 0 0 0.25rem 0;"><?php echo htmlspecialchars($wp['title']); ?></h4>
                            <p style="margin: 0; color: var(--text-muted); font-size: 0.95rem;"><?php echo htmlspecialchars($wp['description']); ?></p>
                            <p style="margin: 0.25rem 0 0 0; color: <?php echo $wp['status'] == 'Active' ? 'var(--primary-color)' : 'var(--terracotta)'; ?>; font-size: 0.8rem; font-weight: 600;">Status: <?php echo htmlspecialchars($wp['status']); ?></p>
                        </div>
                        <?php if ($wp['status'] == 'Active' && !empty($wp['file_url'])): ?>
                            <a href="<?php echo htmlspecialchars($wp['file_url']); ?>" target="_blank" class="btn btn-primary" style="min-width: 120px;"><i class="fa-solid fa-download"></i> Download</a>
                        <?php elseif ($wp['status'] == 'For Summit Delegates Only' && !empty($wp['file_url'])): ?>
                            <a href="<?php echo htmlspecialchars($wp['file_url']); ?>" target="_blank" class="btn btn-primary" style="min-width: 120px;"><i class="fa-solid fa-download"></i> Early Access</a>
                        <?php else: ?>
                            <button class="btn btn-outline" style="min-width: 120px;" disabled><i class="fa-solid fa-lock"></i> Locked</button>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: var(--text-muted);">Check back soon for upcoming whitepapers.</p>
                <?php endif; ?>
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
                <span class="african-divider-sm" style="margin: 0.5rem 0 1.5rem;"></span>
            </div>
 
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <?php if (count($casestudies) > 0): ?>
                    <?php foreach($casestudies as $cs): ?>
                    <div style="background: white; border-radius: var(--border-radius-md); overflow: hidden; box-shadow: var(--box-shadow); border: 1px solid #e2e8f0; padding: 1.5rem; display: flex; flex-direction: column;">
                        <span class="badge" style="background: var(--bg-alt); color: var(--primary-color); align-self: flex-start; margin-bottom: 1rem;">Case Study</span>
                        <h4 style="margin: 0 0 0.5rem 0;"><?php echo htmlspecialchars($cs['title']); ?></h4>
                        <p style="color: var(--text-main); font-size: 0.95rem; line-height: 1.5; flex-grow: 1;"><?php echo htmlspecialchars($cs['description']); ?></p>
                        <?php if ($cs['status'] == 'Active' && !empty($cs['file_url'])): ?>
                            <a href="<?php echo htmlspecialchars($cs['file_url']); ?>" target="_blank" style="color: var(--primary-color); font-weight: 600; text-decoration: none; display: inline-block; margin-top: 1rem;"><i class="fa-solid fa-file-pdf"></i> Read Full Study &rarr;</a>
                        <?php else: ?>
                            <p style="margin-top: 1rem; font-size: 0.85rem; color: var(--terracotta); font-weight: 600;"><i class="fa-solid fa-lock"></i> <?php echo htmlspecialchars($cs['status']); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: var(--text-muted);">More case studies will be published soon.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section id="historical-reports" class="section bg-dark text-light" style="scroll-margin-top: 8rem; background: linear-gradient(rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.95)), url('https://globalprobono.org/wp-content/uploads/2018/02/Lisbon-2017-recap-cover.jpg') center/cover; padding: 6rem 0; color: white;">
        <div class="container" style="max-width: 900px; margin: 0 auto;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 3rem;">
                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.1); color: var(--terracotta); display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.5rem;">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <h2 style="color: white; margin: 0;">Past Global Summit Reports</h2>
            </div>

            <div style="display: grid; gap: 1.5rem;">
                <?php if (count($historical_reports) > 0): ?>
                    <?php foreach($historical_reports as $hr): ?>
                    <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 1.5rem; border-radius: var(--border-radius-md); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; backdrop-filter: blur(10px);">
                        <div style="flex: 1; min-width: 250px;">
                            <h4 style="margin: 0 0 0.25rem 0; color: white;"><?php echo htmlspecialchars($hr['title']); ?></h4>
                            <p style="margin: 0; color: rgba(255,255,255,0.7); font-size: 0.95rem;"><?php echo htmlspecialchars($hr['description']); ?></p>
                        </div>
                        <?php if (!empty($hr['file_url'])): ?>
                            <a href="<?php echo htmlspecialchars($hr['file_url']); ?>" target="_blank" class="btn btn-outline" style="min-width: 120px; color: white; border-color: rgba(255,255,255,0.3);"><i class="fa-solid fa-download"></i> Download</a>
                        <?php else: ?>
                            <button class="btn btn-outline" style="min-width: 120px; color: rgba(255,255,255,0.5); border-color: rgba(255,255,255,0.2);" disabled><i class="fa-solid fa-lock"></i> Coming Soon</button>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: rgba(255,255,255,0.7);">Check back soon for historical reports.</p>
                <?php endif; ?>
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
            
            <?php if (count($media) > 0): ?>
                <?php $m = $media[0]; ?>
                <?php if ($m['status'] == 'Active' && !empty($m['file_url'])): ?>
                    <a href="<?php echo htmlspecialchars($m['file_url']); ?>" class="btn btn-primary btn-lg" download><i class="fa-solid fa-file-zipper"></i> Download Brand Asset Pack (.ZIP)</a>
                <?php else: ?>
                    <button class="btn btn-outline btn-lg" disabled><i class="fa-solid fa-lock"></i> <?php echo htmlspecialchars($m['status']); ?></button>
                <?php endif; ?>
            <?php else: ?>
                <a href="assets/summit-brand-assets.zip" class="btn btn-primary btn-lg" download><i class="fa-solid fa-file-zipper"></i> Download Brand Asset Pack (.ZIP)</a>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
