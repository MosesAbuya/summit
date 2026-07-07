<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Pro-bono Summit Africa 2026</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- African Patterns & Theme -->
    <link rel="stylesheet" href="css/african-patterns.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      /* Override heading font to use Playfair Display for African elegance */
      :root { --font-heading: 'Playfair Display', 'Outfit', serif; }
      h1, h2, h3 { font-family: var(--font-heading); }
      /* Keep nav, buttons, eyebrows in Outfit */
      .main-nav a, .btn, .section-eyebrow, .badge, .venue-day, .track-header { font-family: 'Outfit', sans-serif; }
      
      /* Dropdown styles */
      .dropdown { position: relative; }
      .dropdown-menu { display: none; position: absolute; top: 100%; left: 0; background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(10px); min-width: 150px; border-radius: 8px; padding: 0.5rem 0; box-shadow: 0 10px 25px rgba(0,0,0,0.5); z-index: 10; border: 1px solid rgba(255,255,255,0.1); flex-direction: column; }
      .dropdown:hover .dropdown-menu { display: flex; }
      .dropdown-menu li { margin: 0; }
      .dropdown-menu li a { padding: 0.5rem 1rem !important; display: block; font-size: 0.9rem !important; border-radius: 0; }
      .dropdown-menu li a:hover { background: rgba(255,255,255,0.1); }
      
      /* Mega Menu Styles */
      .mega-menu-wrapper { position: relative; display: flex; align-items: center; margin-right: 1rem; }
      .mega-toggle { cursor: pointer; color: white; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; transition: background 0.3s; }
      .mega-toggle:hover { background: rgba(255,255,255,0.1); }
      .mega-menu { display: none; position: absolute; top: 120%; right: -20px; background: rgba(15, 23, 42, 0.98); backdrop-filter: blur(15px); width: 600px; max-width: 90vw; border-radius: 12px; padding: 2rem; box-shadow: 0 20px 40px rgba(0,0,0,0.6); z-index: 100; border: 1px solid rgba(255,255,255,0.1); grid-template-columns: 1fr 1fr; gap: 2rem; }
      .mega-menu.active { display: grid; }
      .mega-close { position: absolute; top: 1rem; right: 1.5rem; color: white; cursor: pointer; font-size: 1.5rem; transition: color 0.3s; }
      .mega-close:hover { color: var(--terracotta); }
      .mega-menu h4 { color: var(--kente-gold); font-size: 1rem; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.5rem; font-family: var(--font-heading); }
      .mega-menu ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem; }
      .mega-menu ul li a { color: white !important; text-decoration: none; font-size: 0.95rem !important; transition: color 0.2s; font-weight: 400 !important; }
      .mega-menu ul li a:hover { color: var(--secondary-color) !important; padding-left: 5px; }
    </style>
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
                <span>Nairobi, Kenya | November 24-27, 2026</span>
                <span style="opacity: 0.8;">Hosted by Global Pro Bono Network & Jitolee Foundation</span>
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
                    <ul style="gap: 1rem;">
                        <li><a href="index">Home</a></li>
                        <li><a href="about">About</a></li>
                        <li><a href="program">Program</a></li>
                        <li><a href="projects">Projects</a></li>
                        <li><a href="resources">Resources</a></li>
                        <li><a href="news">News</a></li>
                        <li><a href="contact">Contact</a></li>
                    </ul>
                </nav>
                <div class="mega-menu-wrapper">
                    <div class="mega-toggle">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </div>
                    <div class="mega-menu">
                        <div class="mega-close" aria-label="Close menu"><i class="fa-solid fa-xmark"></i></div>
                        <div>
                            <h4>Summit Information</h4>
                            <ul>
                                <li><a href="about">About the Foundation</a></li>
                                <li><a href="program">Summit Program Tracks</a></li>
                                <li><a href="speakers">Keynote Speakers</a></li>
                                <li><a href="logistics">Delegate Logistics</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4>Explore & Engage</h4>
                            <ul>
                                <li><a href="projects">Pro-bono Projects</a></li>
                                <li><a href="partners">Our Partners</a></li>
                                <li><a href="gallery">Event Gallery</a></li>
                                <li><a href="faq">Frequently Asked Questions</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
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
            const header = document.querySelector('.main-header');

            /* ── Mobile Nav Toggle ── */
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

            /* ── Mega Menu Toggle ── */
            const megaToggle = document.querySelector('.mega-toggle');
            const megaMenu = document.querySelector('.mega-menu');
            const megaClose = document.querySelector('.mega-close');
            
            if (megaToggle && megaMenu) {
                megaToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    megaMenu.classList.toggle('active');
                });
                if (megaClose) {
                    megaClose.addEventListener('click', () => {
                        megaMenu.classList.remove('active');
                    });
                }
                document.addEventListener('click', (e) => {
                    if (!megaMenu.contains(e.target) && !megaToggle.contains(e.target)) {
                        megaMenu.classList.remove('active');
                    }
                });
            }

            /* ── Smart Sticky Navbar: hide on scroll-down, reveal on scroll-up ── */
            let lastScrollY = window.scrollY;
            let ticking = false;

            window.addEventListener('scroll', () => {
                if (!ticking) {
                    window.requestAnimationFrame(() => {
                        const currentY = window.scrollY;

                        /* Add 'scrolled' class once past 50px for darker glass */
                        if (currentY > 50) {
                            header.classList.add('scrolled');
                        } else {
                            header.classList.remove('scrolled');
                        }

                        /* Hide when scrolling DOWN past 100px, show on scroll-UP */
                        if (currentY > lastScrollY && currentY > 100) {
                            header.classList.add('nav-hidden');
                        } else {
                            header.classList.remove('nav-hidden');
                        }

                        lastScrollY = currentY;
                        ticking = false;
                    });
                    ticking = true;
                }
            }, { passive: true });

            /* ── Active Nav Link Detection ── */
            const currentPath = window.location.pathname.split('/').pop().replace('.php', '') || 'index';
            document.querySelectorAll('.main-nav a').forEach(link => {
                const href = link.getAttribute('href').replace('.php', '');
                if (href === currentPath || (currentPath === '' && href === 'index')) {
                    link.classList.add('active');
                }
            });
        });
    </script>
