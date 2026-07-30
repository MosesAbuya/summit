<?php 
require 'includes/db.php';
$stmt = $pdo->query("SELECT * FROM speakers ORDER BY id ASC");
$speakers = $stmt->fetchAll();
include 'includes/header.php'; 
?>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('assets/past-summit/231201-101415.jpg') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">Keynote Speakers</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">Visionaries leading the Multidisciplinary Revolution across Africa.</p>
    </div>
</div>

<main>
    <section class="section bg-white">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-eyebrow">The Lineup</span>
                <h2>Plenary & Keynote Sessions</h2>
                <span class="african-divider-sm center"></span>
                <p class="subtitle mt-1" style="max-width: 700px; margin: 0 auto;">Our speakers represent the forefront of corporate ESG, academia, government policy, and grassroots civil society organizations driving the Nairobi Pro Bono Accord.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; margin-top: 4rem;">
                <?php if (count($speakers) > 0): ?>
                    <?php foreach($speakers as $speaker): ?>
                    <div class="african-frame" style="background: white; border-radius: var(--border-radius-lg); border: 1px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column; text-align: center;">
                        <div style="height: 250px; overflow: hidden; background: var(--light-bg); display: flex; align-items: center; justify-content: center;">
                            <?php if ($speaker['image_url']): ?>
                                <img src="<?php echo htmlspecialchars($speaker['image_url']); ?>" alt="<?php echo htmlspecialchars($speaker['name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <h1 style="color: var(--text-muted); opacity: 0.5; font-size: 5rem; margin: 0;"><?php echo strtoupper(substr($speaker['name'], 0, 1)); ?></h1>
                            <?php endif; ?>
                        </div>
                        <div style="padding: 2rem;">
                            <span class="badge" style="background: rgba(193, 68, 14, 0.1); color: var(--terracotta); margin-bottom: 1rem; display: inline-block;">
                                <?php echo htmlspecialchars($speaker['track']); ?>
                            </span>
                            <h3 style="color: #0f172a; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($speaker['name']); ?></h3>
                            <p style="color: var(--primary-color); font-weight: 600; margin-bottom: 1rem; font-size: 0.9rem;">
                                <?php echo htmlspecialchars($speaker['role']); ?>
                            </p>
                            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">
                                <?php echo htmlspecialchars($speaker['bio']); ?>
                            </p>
                            <?php if ($speaker['video_url']): ?>
                                <a href="<?php echo htmlspecialchars($speaker['video_url']); ?>" target="_blank" class="btn btn-outline" style="margin-top: 1rem;">Watch Video</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: var(--text-muted); grid-column: 1 / -1;">Speakers will be announced soon.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section section-alt text-center">
        <div class="container">
            <h2>Call for Speaker Submissions</h2>
            <p style="max-width: 600px; margin: 1rem auto 2rem; color: var(--text-main);">We are actively seeking breakout session leaders and panel moderators with actionable models to share.</p>
            <a href="contact" class="btn btn-primary btn-lg">Apply to Speak</a>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
