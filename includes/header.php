<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Pro-bono Summit Africa 2026</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="main-header" style="position: fixed; top: 1rem; left: 2%; width: 96%; z-index: 1000; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); transition: all 0.3s ease;">
        <style>
            .main-header .main-title { color: white !important; }
            .main-header .sub-brand { color: rgba(255,255,255,0.8) !important; }
            .main-nav ul li a { color: white !important; font-weight: 500; font-size: 0.95rem; }
            .main-nav ul li a:hover { color: var(--secondary-color) !important; text-shadow: 0 0 10px rgba(234,179,8,0.5); }
            /* Force the carousel to occupy full viewport now that header floats */
            .hero-carousel { height: 100vh !important; }
            /* Ensure page headers (breadcrumbs) don't collide with the fixed nav */
            .page-header { padding-top: 10rem !important; padding-bottom: 4rem !important; }
        </style>
        <div class="top-bar bg-dark text-light py-1" style="background-color: transparent; color: white; padding: 0.5rem 0; font-size: 0.85rem; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div class="container" style="display: flex; justify-content: space-between;">
                <span>Nairobi, Kenya | October 12-15, 2026</span>
                <span style="opacity: 0.8;">Hosted by Jitolee Good Friends Foundation</span>
            </div>
        </div>
        <div class="container header-container">
            <div class="logo-wrapper">
                <a href="index" class="logo" style="display: flex; align-items: center; gap: 0.75rem;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 17L12 22L22 17" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div class="logo-text" style="display: flex; flex-direction: column;">
                        <span class="main-title" style="font-weight: 700; font-size: 1.25rem; color: var(--text-main); line-height: 1.1;">Summit Africa</span>
                        <span class="sub-brand" style="font-size: 0.75rem; color: var(--text-muted); font-weight: 500;">By Jitolee Foundation</span>
                    </div>
                </a>
            </div>
            <div class="nav-wrapper">
                <nav class="main-nav">
                    <ul>
                        <li><a href="index">Home</a></li>
                        <li><a href="program">Summit Program</a></li>
                        <li><a href="projects">Pro-bono Projects</a></li>
                        <li><a href="resources">Resource Library</a></li>
                        <li><a href="contact">Contact Us</a></li>
                    </ul>
                </nav>
                <div class="header-cta">
                    <a href="register" class="btn btn-secondary">Register as Delegate</a>
                </div>
            </div>
            <button class="mobile-toggle" aria-label="Toggle Navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.querySelector('.mobile-toggle');
            const navWrapper = document.querySelector('.nav-wrapper');
            if(toggle && navWrapper) {
                toggle.addEventListener('click', () => {
                    navWrapper.classList.toggle('active');
                    const icon = toggle.querySelector('i');
                    if(navWrapper.classList.contains('active')) {
                        icon.classList.replace('fa-bars', 'fa-xmark');
                    } else {
                        icon.classList.replace('fa-xmark', 'fa-bars');
                    }
                });
            }
        });
    </script>
