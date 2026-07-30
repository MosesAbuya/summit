<?php 
require 'includes/db.php';
$stmt = $pdo->query("SELECT * FROM accommodations ORDER BY created_at DESC");
$accommodations = $stmt->fetchAll();
include 'includes/header.php'; 
?>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('assets/hero-bg.png') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">Event Accommodations</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">Premium stays with our official hotel partners.</p>
    </div>
</div>

<main>
    <section class="section bg-light">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-eyebrow">Where to Stay</span>
                <h2>Preferred Event Accommodations</h2>
                <span class="african-divider-sm center"></span>
                <p class="subtitle mt-1" style="max-width: 800px; margin: 1rem auto 0;">We have partnered with leading highly-rated Nairobi hotels positioned near our primary venues. Registered delegates using the unique code <strong style="color: var(--secondary-color);">PROBONO26</strong> receive exclusive Summit rates.</p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 4rem;">
                <?php if (count($accommodations) > 0): ?>
                    <?php foreach($accommodations as $hotel): ?>
                    <div class="african-frame" style="background: white; border-radius: var(--border-radius-lg); border: 1px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column;">
                        <?php if ($hotel['image_url']): ?>
                        <div style="height: 200px; overflow: hidden;">
                            <img src="<?php echo htmlspecialchars($hotel['image_url']); ?>" alt="<?php echo htmlspecialchars($hotel['hotel_name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <?php endif; ?>
                        <div style="padding: 2rem; display: flex; flex-direction: column; flex-grow: 1;">
                            <h3 style="color: #0f172a; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($hotel['hotel_name']); ?></h3>
                            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; flex-grow: 1;">
                                <?php echo htmlspecialchars($hotel['description']); ?>
                            </p>
                            <?php if ($hotel['booking_link']): ?>
                                <a href="<?php echo htmlspecialchars($hotel['booking_link']); ?>" target="_blank" class="btn btn-secondary" style="margin-top: 1.5rem; text-align: center;">Book at Summit Rate</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: var(--text-muted); grid-column: 1 / -1;">Accommodation partners will be updated soon.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
