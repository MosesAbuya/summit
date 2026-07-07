<?php include 'includes/header.php'; ?>

<style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        padding: 2rem 0;
    }
    .gallery-item {
        position: relative;
        border-radius: var(--border-radius-md);
        overflow: hidden;
        aspect-ratio: 4 / 3;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        cursor: pointer;
    }
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .gallery-item:hover img {
        transform: scale(1.05);
    }
    .gallery-item::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0);
        transition: background 0.3s ease;
    }
    .gallery-item:hover::after {
        background: rgba(15, 23, 42, 0.3);
    }
</style>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('assets/past-summit/231130-101322.jpg') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">Event Gallery</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">Highlights from past Global Pro Bono Summits and events.</p>
    </div>
</div>

<main>
    <section class="section bg-white">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-eyebrow">Visual Memories</span>
                <h2>Impact in Action</h2>
                <span class="african-divider-sm center"></span>
                <p class="subtitle mt-1">A look back at the people and moments that define our multidisciplinary movement.</p>
            </div>

            <div class="gallery-grid">
                <?php
                $images = [
                    '231130-101322.jpg',
                    '231201-101415.jpg',
                    '231201-131346.jpg',
                    '231201-135335.jpg',
                    '231201-153912.jpg',
                    '231201-193053.jpg',
                    '231201-205336.jpg'
                ];
                
                foreach($images as $img) {
                    echo "<div class='gallery-item african-frame'>
                            <img src='assets/past-summit/{$img}' alt='Past Summit Memory' loading='lazy'>
                          </div>";
                }
                ?>
            </div>
            
            <div class="text-center mt-4">
                <p style="color: var(--text-muted); margin-bottom: 1rem;">Want to see your organization featured here?</p>
                <a href="partners" class="btn btn-secondary">Become a Partner</a>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
