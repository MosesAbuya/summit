<?php
require 'includes/db.php';

// Fetch the specific news item
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$article = null;

if ($id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
        $stmt->execute([$id]);
        $article = $stmt->fetch();
    } catch (PDOException $e) {
        $error = "Failed to load article.";
    }
}

if (!$article) {
    // Redirect back to news if not found
    header("Location: news");
    exit;
}

include 'includes/header.php'; 
?>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.95)), url('<?php echo htmlspecialchars($article['image_url']); ?>') center/cover; padding: 8rem 0 4rem; text-align: left; color: white;">
    <div class="container" style="max-width: 800px;">
        <span class="badge" style="background: var(--terracotta); color: white; margin-bottom: 1rem; display: inline-block;">
            <?php echo date('F d, Y', strtotime($article['created_at'])); ?>
        </span>
        <h1 style="color: white; font-size: 2.5rem; margin-bottom: 1rem; line-height: 1.2; font-family: var(--font-heading);">
            <?php echo htmlspecialchars($article['title']); ?>
        </h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8); font-size: 1.1rem;">
            <?php echo htmlspecialchars($article['excerpt']); ?>
        </p>
    </div>
</div>

<main>
    <section class="section bg-white">
        <div class="container" style="max-width: 800px;">
            <div style="margin-bottom: 3rem;">
                <a href="news" style="color: var(--secondary-color); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                    &larr; Back to News
                </a>
            </div>
            
            <div class="article-content" style="font-size: 1.1rem; line-height: 1.8; color: var(--text-main);">
                <?php 
                // Using nl2br to convert newlines to paragraphs/breaks
                // This is a simple formatting approach for standard text content
                $content = htmlspecialchars($article['content']);
                echo nl2br($content); 
                ?>
            </div>

            <div style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h4 style="margin: 0; color: var(--primary-color);">Share this story</h4>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($article['title']); ?>" target="_blank" class="btn btn-outline" style="padding: 0.5rem 1rem; border-color: #cbd5e1; color: var(--text-main);">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>&title=<?php echo urlencode($article['title']); ?>" target="_blank" class="btn btn-outline" style="padding: 0.5rem 1rem; border-color: #cbd5e1; color: var(--text-main);">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
