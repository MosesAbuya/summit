<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Pro Bono Summit Africa</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">
    <link rel="shortcut icon" href="assets/favicon/favicon.ico">
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

      /* New Global Mega Menu Styles */
      .nav-item-mega { position: relative; }
      .global-mega-menu { display: none; position: absolute; top: calc(100% + 1rem); left: 50%; transform: translateX(-50%); background: rgba(15, 23, 42, 0.98); backdrop-filter: blur(15px); width: 800px; max-width: 90vw; border-radius: 12px; padding: 2rem; box-shadow: 0 20px 40px rgba(0,0,0,0.6); z-index: 100; border: 1px solid rgba(255,255,255,0.1); grid-template-columns: 1.5fr 1fr 1fr; gap: 2rem; opacity: 0; transition: opacity 0.3s ease, top 0.3s ease; pointer-events: none; }
      .global-mega-menu.active { display: grid; opacity: 1; pointer-events: auto; top: calc(100% + 0.5rem); }
      .global-mega-menu::before { content: ''; position: absolute; top: -10px; left: 0; right: 0; height: 10px; } /* hover bridge */
      
      .dynamic-col { border-right: 1px solid rgba(255,255,255,0.1); padding-right: 2rem; display: flex; flex-direction: column; justify-content: center; }
      .dynamic-col img { width: 100%; height: 140px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem; border: 1px solid rgba(255,255,255,0.1); }
      .dynamic-col h3 { color: var(--secondary-color); font-size: 1.25rem; margin-bottom: 0.5rem; }
      .dynamic-col p { color: rgba(255,255,255,0.8); font-size: 0.9rem; line-height: 1.5; margin-bottom: 0; }

      @media (max-width: 950px) {
          .global-mega-menu {
              position: relative !important;
              top: 0 !important;
              left: 0 !important;
              transform: none !important;
              width: 100% !important;
              grid-template-columns: 1fr !important;
              padding: 1rem !important;
              gap: 1rem !important;
              margin-top: 1rem;
          }
          .dynamic-col {
              border-right: none;
              border-bottom: 1px solid rgba(255,255,255,0.1);
              padding-right: 0;
              padding-bottom: 1rem;
          }
          .dynamic-col img { height: auto; max-height: 120px; }
          .mobile-mega-btn { display: list-item !important; }
      }
      .mobile-mega-btn { display: none; }

    </style>
</head>
<body>
    <header class="main-header" style="position: fixed; top: 1rem; left: 2%; width: 96%; z-index: 1000; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); transition: all 0.3s ease;">
        <style>
            .main-header .main-title { color: white !important; }
            .main-header .sub-brand { color: rgba(255,255,255,0.8) !important; }
            .main-nav ul li a { color: white !important; font-weight: 500; font-size: 0.95rem; white-space: nowrap; }
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
                    <img src="assets/banners/logo.png" alt="Global Summit on pro bono practice Africa Logo" style="height: 45px; width: auto; object-fit: contain;">
                    <div class="logo-text" style="display: flex; flex-direction: column;">
                        <span class="main-title" style="font-weight: 700; font-size: 0.95rem; color: var(--text-main); line-height: 1.2; max-width: 180px; white-space: normal;">Global Summit on pro bono practice Africa</span>
                    </div>
                </a>
            </div>
            <div class="nav-wrapper">
                <nav class="main-nav">
                    <ul style="gap: 1rem; position: relative;">
                        <li><a href="index">Home</a></li>
                        <li class="nav-item-mega" data-mega="about"><a href="about">About</a></li>
                        <li class="nav-item-mega" data-mega="program"><a href="program">Program</a></li>
                        <li class="nav-item-mega" data-mega="projects"><a href="best_practices">Best Practices</a></li>
                        <li class="nav-item-mega" data-mega="resources"><a href="resources">Resources</a></li>
                        <li><a href="news">News</a></li>
                        <li><a href="call-for-speakers" style="color: var(--terracotta); font-weight: 600;">Call for Speakers</a></li>
                        <li><a href="contact">Contact</a></li>
                        <li class="mobile-mega-btn"><a href="#" id="mobile-mega-trigger">Explore More <i class="fa-solid fa-chevron-down" style="font-size: 0.8rem; margin-left: 0.5rem;"></i></a></li>
                    </ul>
                </nav>
                
                <!-- Global Mega Menu -->
                <div class="global-mega-menu" id="global-mega-menu">
                    <div class="dynamic-col" id="mega-dynamic-col">
                        <!-- Dynamic Content Inserted Here via JS -->
                        <img src="assets/past-summit/231130-101322.jpg" alt="Dynamic">
                        <h3>Global Pro Bono</h3>
                        <p>Leveraging multidisciplinary expertise for sustainable development across the continent.</p>
                    </div>
                    <div class="mega-static-col">
                        <h4 style="color: var(--kente-gold); font-size: 1rem; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.5rem; font-family: var(--font-heading);">Summit Information</h4>
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                            <li><a href="about" style="color: white; text-decoration: none; font-size: 0.95rem; font-weight: 400; transition: color 0.2s;">About the Foundation</a></li>
                            <li><a href="program" style="color: white; text-decoration: none; font-size: 0.95rem; font-weight: 400; transition: color 0.2s;">Summit Program Tracks</a></li>
                            <li><a href="speakers" style="color: white; text-decoration: none; font-size: 0.95rem; font-weight: 400; transition: color 0.2s;">Keynote Speakers</a></li>
                            <li><a href="logistics" style="color: white; text-decoration: none; font-size: 0.95rem; font-weight: 400; transition: color 0.2s;">Delegate Logistics</a></li>
                            <li><a href="resources#historical-reports" style="color: white; text-decoration: none; font-size: 0.95rem; font-weight: 400; transition: color 0.2s;">Past Global Summit Reports</a></li>
                        </ul>
                    </div>
                    <div class="mega-static-col">
                        <h4 style="color: var(--kente-gold); font-size: 1rem; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.5rem; font-family: var(--font-heading);">Explore & Engage</h4>
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                            <li><a href="projects" style="color: white; text-decoration: none; font-size: 0.95rem; font-weight: 400; transition: color 0.2s;">Pro-bono Projects</a></li>
                            <li><a href="partners" style="color: white; text-decoration: none; font-size: 0.95rem; font-weight: 400; transition: color 0.2s;">Our Partners</a></li>
                            <li><a href="gallery" style="color: white; text-decoration: none; font-size: 0.95rem; font-weight: 400; transition: color 0.2s;">Event Gallery</a></li>
                            <li><a href="faq" style="color: white; text-decoration: none; font-size: 0.95rem; font-weight: 400; transition: color 0.2s;">Frequently Asked Questions</a></li>
                        </ul>
                    </div>
                </div>
                <div class="header-cta">
                    <a href="register" class="btn btn-secondary" style="white-space: nowrap;">Register as Delegate</a>
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

            /* ── Global Mega Menu Toggle ── */
            const megaItems = document.querySelectorAll('.nav-item-mega');
            const globalMegaMenu = document.getElementById('global-mega-menu');
            const dynamicCol = document.getElementById('mega-dynamic-col');
            let megaTimeout;

            const megaData = {
                'about': {
                    img: 'assets/past-summit/231130-101322.jpg',
                    title: 'About the Summit',
                    desc: 'Fostering Sustainable Development through Global Pro bono practice and strategic partnerships.'
                },
                'program': {
                    img: 'assets/past-summit/231201-101415.jpg',
                    title: 'Summit Program',
                    desc: 'Explore the 4 Strategic Pillars driving impactful sessions and multi-disciplinary workshops.'
                },
                'projects': {
                    img: 'assets/past-summit/231201-153912.jpg',
                    title: 'Best Practices',
                    desc: 'Showcasing high-impact models that redefine corporate social responsibility in Africa.'
                },
                'resources': {
                    img: 'assets/past-summit/231201-135335.jpg',
                    title: 'Resource Center',
                    desc: 'Access whitepapers, case studies, and blueprints for measurable development impact.'
                }
            };

            megaItems.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    if (window.innerWidth <= 950) return; // Ignore hover on mobile
                    clearTimeout(megaTimeout);
                    const key = item.getAttribute('data-mega');
                    if(megaData[key]) {
                        dynamicCol.innerHTML = `
                            <img src="${megaData[key].img}" alt="${megaData[key].title}">
                            <h3>${megaData[key].title}</h3>
                            <p>${megaData[key].desc}</p>
                        `;
                    }
                    globalMegaMenu.classList.add('active');
                });
                
                item.addEventListener('mouseleave', () => {
                    if (window.innerWidth <= 950) return; // Ignore on mobile
                    megaTimeout = setTimeout(() => {
                        globalMegaMenu.classList.remove('active');
                    }, 200);
                });
            });

            if(globalMegaMenu) {
                globalMegaMenu.addEventListener('mouseenter', () => {
                    if (window.innerWidth <= 950) return;
                    clearTimeout(megaTimeout);
                });
                globalMegaMenu.addEventListener('mouseleave', () => {
                    if (window.innerWidth <= 950) return;
                    megaTimeout = setTimeout(() => {
                        globalMegaMenu.classList.remove('active');
                    }, 200);
                });
            }

            /* ── Mobile Explore More Toggle ── */
            const mobileMegaTrigger = document.getElementById('mobile-mega-trigger');
            if (mobileMegaTrigger) {
                mobileMegaTrigger.addEventListener('click', (e) => {
                    e.preventDefault();
                    const isActive = globalMegaMenu.classList.contains('active');
                    
                    if (!isActive) {
                        // Ensure dynamic col has some default content on mobile
                        if (dynamicCol.innerHTML.trim() === '') {
                            const defaultKey = 'about';
                            dynamicCol.innerHTML = `
                                <img src="${megaData[defaultKey].img}" alt="${megaData[defaultKey].title}">
                                <h3>${megaData[defaultKey].title}</h3>
                                <p>${megaData[defaultKey].desc}</p>
                            `;
                        }
                        globalMegaMenu.classList.add('active');
                        mobileMegaTrigger.querySelector('i').classList.replace('fa-chevron-down', 'fa-chevron-up');
                    } else {
                        globalMegaMenu.classList.remove('active');
                        mobileMegaTrigger.querySelector('i').classList.replace('fa-chevron-up', 'fa-chevron-down');
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
