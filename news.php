<?php
require 'includes/db.php';

// Fetch News
$stmt = $pdo->query("SELECT * FROM news WHERE status = 'Published' ORDER BY created_at DESC");
$news_items = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('assets/hero-bg.png') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">News & Updates</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">Stay informed on the latest developments, announcements, and impact stories.</p>
    </div>
</div>

<main>
    <section class="section bg-white">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem;">
                
                <?php if (count($news_items) > 0): ?>
                    <?php foreach($news_items as $news): ?>
                        <div class="african-frame" style="background: white; border-radius: var(--border-radius-lg); border: 1px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column;">
                            <div style="height: 220px; overflow: hidden; position: relative;">
                                <img src="<?php echo htmlspecialchars($news['image_url']); ?>" alt="<?php echo htmlspecialchars($news['title']); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                <div style="position: absolute; top: 1rem; right: 1rem; background: var(--kente-gold); color: #fff; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    <?php echo date('M d, Y', strtotime($news['created_at'])); ?>
                                </div>
                            </div>
                            <div style="padding: 2rem; flex-grow: 1; display: flex; flex-direction: column;">
                                <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #0f172a; line-height: 1.3;"><?php echo htmlspecialchars($news['title']); ?></h3>
                                <p style="color: var(--text-muted); margin-bottom: 1.5rem; line-height: 1.6; flex-grow: 1;"><?php echo htmlspecialchars($news['excerpt']); ?></p>
                                <button onclick="document.getElementById('modal-<?php echo $news['id']; ?>').style.display='flex'" class="btn btn-outline" style="border-color: var(--secondary-color); color: var(--secondary-color); font-weight: 600; width: fit-content;">Read Full Article &rarr;</button>
                            </div>
                        </div>

                        <!-- Modal for Full Content -->
                        <div id="modal-<?php echo $news['id']; ?>" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center; padding: 2rem;">
                            <div style="background: white; border-radius: var(--border-radius-lg); max-width: 800px; width: 100%; max-height: 90vh; overflow-y: auto; position: relative;">
                                <button onclick="document.getElementById('modal-<?php echo $news['id']; ?>').style.display='none'" style="position: absolute; top: 1.5rem; right: 1.5rem; background: #fee2e2; border: none; width: 40px; height: 40px; border-radius: 50%; color: #991b1b; font-size: 1.2rem; cursor: pointer; z-index: 10;"><i class="fa-solid fa-times"></i></button>
                                
                                <img src="<?php echo htmlspecialchars($news['image_url']); ?>" style="width: 100%; height: 300px; object-fit: cover;">
                                
                                <div style="padding: 3rem;">
                                    <div style="color: var(--terracotta); font-weight: 700; font-size: 0.9rem; letter-spacing: 1px; margin-bottom: 0.5rem; text-transform: uppercase;">Published <?php echo date('F j, Y', strtotime($news['created_at'])); ?></div>
                                    <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem; color: #0f172a; line-height: 1.2;"><?php echo htmlspecialchars($news['title']); ?></h2>
                                    <div style="color: #334155; line-height: 1.8; font-size: 1.1rem;">
                                        <?php echo nl2br(htmlspecialchars($news['content'])); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; background: var(--bg-alt); border-radius: var(--border-radius-lg);">
                        <i class="fa-regular fa-newspaper" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                        <h3 style="color: var(--text-main);">No News Yet</h3>
                        <p style="color: var(--text-muted);">Check back later for updates and announcements regarding the Summit.</p>
                    </div>
                <?php endif; ?>
                
            </div>
        </div>
    </section>
</main>

<script>
// Close modal on escape key or outside click
window.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('[id^="modal-"]').forEach(modal => modal.style.display = 'none');
    }
});
window.addEventListener('click', function(e) {
    if (e.target.matches('[id^="modal-"]')) {
        e.target.style.display = 'none';
    }
});
</script>

<?php include 'includes/footer.php'; ?>
