<?php
require 'includes/db.php';

// Fetch Latest 3 News
$stmt = $pdo->query("SELECT * FROM news WHERE status = 'Published' ORDER BY created_at DESC LIMIT 3");
$latest_news = $stmt->fetchAll();

// Fetch Speakers
$stmt = $pdo->query("SELECT * FROM speakers ORDER BY id ASC");
$speakers = $stmt->fetchAll();

// Fetch Major Partners
$stmt = $pdo->query("SELECT * FROM partners WHERE is_major = 1 ORDER BY id ASC");
$major_partners = $stmt->fetchAll();

// Fetch Ecosystem Partners
$stmt = $pdo->query("SELECT * FROM partners WHERE is_major = 0 ORDER BY id ASC");
$ecosystem_partners = $stmt->fetchAll();

include 'includes/header.php';
?>
<!-- 1. Sick Interactive Hero Carousel -->
<style>
    .hero-carousel {
        position: relative;
        height: 95vh;
        min-height: 600px;
        width: 100%;
        overflow: hidden;
        background: #000;
    }

    .carousel-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        transition: opacity 1s cubic-bezier(0.4, 0, 0.2, 1), transform 1s cubic-bezier(0.4, 0, 0.2, 1);
        transform: scale(1.05);
    }

    .carousel-slide.active {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
        z-index: 2;
    }

    .carousel-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 1;
        filter: brightness(0.45);
    }

    .carousel-content {
        position: relative;
        z-index: 3;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        padding: 0 10%;
    }

    .carousel-title {
        font-size: clamp(3rem, 6vw, 5.5rem);
        color: white;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        font-weight: 800;
        transform: translateY(40px);
        opacity: 0;
        transition: all 0.8s 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .carousel-subtitle {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.9);
        max-width: 600px;
        margin-bottom: 2.5rem;
        transform: translateY(30px);
        opacity: 0;
        transition: all 0.8s 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .carousel-actions {
        transform: translateY(30px);
        opacity: 0;
        transition: all 0.8s 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .carousel-slide.active .carousel-title,
    .carousel-slide.active .carousel-subtitle,
    .carousel-slide.active .carousel-actions {
        transform: translateY(0);
        opacity: 1;
    }

    /* Thumbnails */
    .carousel-thumbnails {
        position: absolute;
        bottom: 3rem;
        right: 10%;
        z-index: 10;
        display: flex;
        gap: 1rem;
    }

    .thumb {
        width: 140px;
        height: 85px;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s;
        position: relative;
    }

    .thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.5;
        transition: 0.3s;
    }

    .thumb:hover img {
        opacity: 0.8;
    }

    .thumb.active {
        border-color: var(--secondary-color);
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
    }

    .thumb.active img {
        opacity: 1;
    }

    .thumb-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        color: white;
        font-size: 0.7rem;
        padding: 15px 8px 5px;
        text-transform: uppercase;
        font-weight: 700;
        text-align: center;
    }

    /* Progress Bar */
    .carousel-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 5px;
        background: rgba(255, 255, 255, 0.1);
        width: 100%;
        z-index: 10;
    }

    .progress-bar {
        height: 100%;
        background: var(--secondary-color);
        width: 0;
        transition: width 6s linear;
    }

    .carousel-slide.active~.carousel-progress .progress-bar {
        width: 100%;
    }

    @media (max-width: 768px) {
        .carousel-thumbnails {
            display: none;
        }
    }
</style>

<div class="hero-carousel" id="homeHero">

    <!-- Slide 1 -->
    <div class="carousel-slide active" data-index="0">
        <img class="carousel-bg" src="assets/hero_slide_1_v3.jpg" alt="Summit Main">
        <div class="carousel-content">
            <span
                style="display: inline-block; padding: 0.5rem 1.2rem; background: rgba(255,255,255,0.1); border-radius: 30px; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: white; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.5rem;">Nov
                24-27 • Nairobi, Kenya</span>
            <h1 class="carousel-title" style="font-size: clamp(2.5rem, 5vw, 4.5rem);">GLOBAL SUMMIT ON<br>PRO BONO
                PRACTICE<br>AFRICA</h1>
            <p class="carousel-subtitle">"Leveraging Multidisciplinary Pro Bono for SDGs and Agenda 2063"</p>
            <div class="carousel-actions" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="register" class="btn btn-primary btn-lg">Secure Your Pass</a>
                <a href="program" class="btn btn-outline btn-lg"
                    style="color: white; border-color: rgba(255,255,255,0.5);">View Itinerary</a>
            </div>
        </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-slide" data-index="1">
        <img class="carousel-bg" src="assets/hero_slide_2.png" alt="Partner">
        <div class="carousel-content">
            <span
                style="display: inline-block; padding: 0.5rem 1.2rem; background: rgba(234,179,8,0.2); border-radius: 30px; border: 1px solid rgba(234,179,8,0.5); backdrop-filter: blur(10px); color: var(--secondary-color); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.5rem;">Strategic
                Alliances</span>
            <h1 class="carousel-title">Become a Corporate<br>Partner</h1>
            <p class="carousel-subtitle">Align your brand with Africa's premier social impact event. Explore Diamond,
                Platinum, and Gold sponsorship tiers to supercharge your ESG goals.</p>
            <div class="carousel-actions" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="partners" class="btn btn-secondary btn-lg" style="color: #000;">View Corporate Tiers</a>
                <a href="contact" class="btn btn-outline btn-lg"
                    style="color: white; border-color: rgba(255,255,255,0.5);">Request Deck</a>
            </div>
        </div>
    </div>

    <!-- Slide 3 -->
    <div class="carousel-slide" data-index="2">
        <img class="carousel-bg" src="assets/hero_slide_3.png" alt="Support">
        <div class="carousel-content">
            <span
                style="display: inline-block; padding: 0.5rem 1.2rem; background: rgba(255,255,255,0.1); border-radius: 30px; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: white; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.5rem;">Empower
                Grassroots</span>
            <h1 class="carousel-title">Support The<br>Movement</h1>
            <p class="carousel-subtitle">Cannot attend? Your financial support can sponsor an African grassroots NGO
                leader to access the summit fully subsidized.</p>
            <div class="carousel-actions" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="register" class="btn btn-primary btn-lg">Sponsor a grassroot Pro Bono Subsidiary/StartUp leader from outside Kenya.</a>
            </div>
        </div>
    </div>

    <!-- Slide 4 -->
    <div class="carousel-slide" data-index="3">
        <img class="carousel-bg" src="assets/hero_slide_4.png" alt="Gala">
        <div class="carousel-content">
            <span
                style="display: inline-block; padding: 0.5rem 1.2rem; background: rgba(255,255,255,0.1); border-radius: 30px; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: white; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.5rem;">Day
                4 Conclusion</span>
            <h1 class="carousel-title">The Global Impact<br>Awards Gala</h1>
            <p class="carousel-subtitle">Join us for a night of elegance, celebrating the pioneers of Pan-African
                volunteerism.</p>
            <div class="carousel-actions" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="program#day4" class="btn btn-secondary btn-lg" style="color: #000;">View Gala Details</a>
            </div>
        </div>
    </div>

    <div class="carousel-thumbnails">
        <div class="thumb active" data-target="0">
            <img src="assets/hero_slide_1_v3.jpg">
            <div class="thumb-label">The Summit</div>
        </div>
        <div class="thumb" data-target="1">
            <img src="assets/hero_slide_2.png">
            <div class="thumb-label">Partner</div>
        </div>
        <div class="thumb" data-target="2">
            <img src="assets/hero_slide_3.png">
            <div class="thumb-label">Support</div>
        </div>
        <div class="thumb" data-target="3">
            <img src="assets/hero_slide_4.png">
            <div class="thumb-label">Gala Dinner</div>
        </div>
    </div>

    <div class="carousel-progress">
        <div class="progress-bar"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('.carousel-slide');
        const thumbs = document.querySelectorAll('.thumb');
        let currentSlide = 0;
        let slideInterval;
        let progressBar = document.querySelector('.progress-bar');

        const resetProgress = () => {
            progressBar.style.transition = 'none';
            progressBar.style.width = '0';
            setTimeout(() => {
                progressBar.style.transition = 'width 6s linear';
                progressBar.style.width = '100%';
            }, 50);
        };

        const goToSlide = (index) => {
            slides[currentSlide].classList.remove('active');
            thumbs[currentSlide].classList.remove('active');

            resetProgress();

            currentSlide = index;
            slides[currentSlide].classList.add('active');
            thumbs[currentSlide].classList.add('active');
        };

        const nextSlide = () => {
            let next = (currentSlide + 1) % slides.length;
            goToSlide(next);
        };

        const startTimer = () => {
            slideInterval = setInterval(nextSlide, 6000);
        };

        thumbs.forEach((thumb, idx) => {
            thumb.addEventListener('click', () => {
                clearInterval(slideInterval);
                goToSlide(idx);
                startTimer();
            });
        });

        // initial progress bar start
        resetProgress();
        startTimer();
    });
</script>

<!-- 2. Founder's Welcome -->
<!-- Full Width Banner 1 -->
<div style="width: 100%; overflow: hidden;">
    <img src="assets/banners/banner 1.jpeg" alt="Global Summit Banner 1" style="width: 100%; height: auto; display: block;">
</div>

<section id="about" class="section section-alt">
    <div class="container">
        <div class="welcome-grid">
            <div class="welcome-text">
                <h2 class="welcome-title">Welcome to the Global Pro Bono Summit Africa</h2>
                <p>In a world facing interconnected crises including climate disasters, AI job shifts, and educational
                    gaps, this Summit is designed to regenerate and transform the landscape of professional pro bono
                    service and volunteerism to intervene and address these polycrises.</p>
                <p>Organized by the Global Pro Bono Network and Jitolee Good Friends Foundation, the Summit drives a
                    <strong>'Multidisciplinary Revolution'</strong> grounded in four strategic pillars: Inclusive
                    Economic Empowerment, Education & Skills Development, Decent Work & Institutional Excellence, and
                    Climate Action.</p>
                
                <p>Convened in explicit recognition of the United Nations International Year of Volunteers for Sustainable Development (IVY 2026) under Resolution 78/127, the Summit serves as Africa's premier continental platform to translate global volunteer momentum into practical African action.</p>

                <p>The Conference is set to take place from <strong>November 24th to 27th, 2026 in Nairobi,
                        Kenya</strong>. This year's core focus:</p>

                <div class="blockquote-highlight mt-2">
                    <p class="quote-text">"Leveraging Multidisciplinary Pro Bono for SDGs and Agenda 2063."</p>
                    <p class="quote-sub">Aligning with the United Nations Agenda 2030 and the African Union Agenda 2063
                        to co-create high-impact sustainable solutions.</p>
                </div>
            </div>
            <div class="welcome-image-wrapper african-frame">
                <img src="assets/fredsadia.png" alt="Fredrick Sadia - Founder" class="founder-img"
                    style="object-position: top;">
                <div class="play-button-overlay">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- African Premiere CTA -->
<section class="section" style="position: relative; background: url('assets/african_cta_bg.jpg') center/cover no-repeat; padding: 8rem 0; overflow: hidden;">
    <!-- African geometric overlay for texture -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: var(--pattern-ankara); background-size: 150px; opacity: 0.15; z-index: 1;"></div>
    <!-- Gradient overlay for text readability -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(90deg, rgba(15,23,42,0.95) 0%, rgba(15,23,42,0.7) 100%); z-index: 2;"></div>
    
    <div class="container" style="position: relative; z-index: 3; display: flex; flex-direction: column; align-items: flex-start; max-width: 900px; margin: 0 auto; text-align: left;">
        
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
            <div style="width: 60px; height: 2px; background-color: var(--terracotta);"></div>
            <span style="font-family: var(--font-heading); text-transform: uppercase; letter-spacing: 3px; color: var(--kente-gold); font-size: 1rem; font-weight: 700;">A Historic Premiere</span>
        </div>
        
        <h2 style="font-size: clamp(3rem, 6vw, 4.5rem); color: white; line-height: 1.1; margin-bottom: 1.5rem; text-shadow: 0 4px 15px rgba(0,0,0,0.5); font-family: var(--font-heading);">
            A GLOBAL MOVEMENT.<br>
            <span style="color: var(--kente-gold); font-style: italic;">AN AFRICAN DAWN.</span>
        </h2>
        
        <p style="font-size: 1.25rem; line-height: 1.8; color: rgba(255,255,255,0.9); margin-bottom: 3rem; font-weight: 300; border-left: 4px solid var(--terracotta); padding-left: 1.5rem;">
            After making its transformative impacts on Pro Bono Practitioners and Subsidiaries in the Americas, Europe, and Asia... the Global Pro Bono Summit makes its historic debut in the youthful continent of Africa, in Nairobi, the capital city of Kenya and Africa's premier meeting venue.<br><br>
            Join us as we center and amplify African voices, drive sustainable pro bono impact, and ignite a continental era of professional volunteerism.
        </p>
        
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="resources#historical-reports" class="btn btn-primary" style="background-color: var(--terracotta); border-color: var(--terracotta); color: white; padding: 1.25rem 2.5rem; font-size: 1.1rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 10px 25px rgba(193, 68, 14, 0.4); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 30px rgba(193, 68, 14, 0.5)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(193, 68, 14, 0.4)';">Explore Past Summits</a>
            
            <a href="about" class="btn btn-outline" style="border-color: rgba(255,255,255,0.3); color: white; padding: 1.25rem 2.5rem; font-size: 1.1rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; backdrop-filter: blur(5px); transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)'; this.style.borderColor='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='rgba(255,255,255,0.3)';">Discover Our Vision</a>
        </div>
    </div>
</section>

<!-- Landscape Banner 2 -->
<section style="background: #f8fafc; padding: 4rem 0;">
    <div class="container" style="display: flex; justify-content: center;">
        <img src="assets/banners/banner 2.jpeg" alt="Global Summit Banner 2" style="max-width: 100%; height: auto; border-radius: var(--border-radius-lg); box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
    </div>
</section>

<!-- 3. The Theme Section -->
<section class="section bg-white border-y" style="border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
    <div class="container">
        <div class="grid-2-col align-center">
            <div class="theme-overview-text">
                <span class="section-eyebrow">2026 Summit Theme</span>
                <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem; color: #0f172a;">A Multidisciplinary Revolution</h2>
                <p style="font-size: 1.1rem; line-height: 1.8; color: var(--text-main);">
                    While African pro bono initiatives have traditionally focused on legal services, this Summit expands the horizon. By bridging the gap between professional expertise and community needs, we aim to deliver tangible Return on Investment (ROI): enhanced corporate ESG profiles, skilled talent development, and community resilience gains.
                </p>
                <div style="flex: 1; min-width: 300px;">
                    <p>The Summit focuses on four critical pillars: Inclusive Economic Empowerment, Education & Skills Development, Decent Work, and Climate Action, directly advancing AU Agenda 2063 Aspirations for a Prosperous and People-driven Africa.</p>
                </div>
            </div>
            <div class="theme-overview-image" style="position: relative;">
                <div class="african-frame-bold image-wrapper shadow-lg radius-lg" style="position: relative; z-index: 2;">
                    <img src="assets/past-summit/231130-101322.jpg" alt="Conference Audience">
                </div>
                <div style="position: absolute; bottom: -20px; left: -20px; width: 150px; height: 150px; background-image: var(--pattern-ankara); background-size: 48px 48px; background-color: var(--kente-gold); z-index: 1; border-radius: 12px; opacity: 0.7;"></div>
            </div>
        </div>
    </div>
</section>

<!-- 4. Massive Typographic Section & Goals (Moved Lower) -->
<section class="section bg-white">
    <div class="container">
        <!-- Big Typographic Header -->
        <div class="massive-title-section text-center">
            <h2 class="massive-title">
                GLOBAL PRO BONO<br>
                <span>SUMMIT AFRICA</span>
            </h2>
            <span class="african-divider" style="margin-top: 1.5rem;"></span>
        </div>
        
        <!-- The 4 Core Objectives -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 4rem;">
            <div class="goal-box">
                <h3 class="serif-heading" style="color: var(--terracotta); font-size: 2rem;">15</h3>
                <p><strong>Cross-Sector Partnerships:</strong> Secure MoUs between corporates, academics, and NGOs for joint pro bono delivery.</p>
            </div>
            <div class="goal-box">
                <h3 class="serif-heading" style="color: var(--savannah-sand); font-size: 2rem;">50</h3>
                <p><strong>Pro Bono Initiatives:</strong> Launch scalable blueprints impacting 5,000 Africans, with a global ripple to 50,000 via shared toolkits.</p>
            </div>
            <div class="goal-box">
                <h3 class="serif-heading" style="color: var(--primary-color); font-size: 2rem;">3</h3>
                <p><strong>University Curricula:</strong> Integrate pro bono practice into at least 2-3 higher learning institutions by the end of 2027.</p>
            </div>
            <div class="goal-box">
                <h3 class="serif-heading" style="color: var(--secondary-color); font-size: 2rem;">200</h3>
                <p><strong>Accord Signatories:</strong> Adopt the Nairobi Pro Bono Accord/Declaration committing participants to 10,000 pro bono hours.</p>
            </div>
        </div>
    </div>
</section>

<!-- 5. Program Tracks -->
<section id="program" class="section section-alt">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-eyebrow">Program Architecture</span>
            <h2>Summit Program Tracks</h2>
            <span class="african-divider-sm center"></span>
            <p class="subtitle mt-1">Structured engagement designed for maximum collaborative impact.</p>
        </div>

        <div class="tracks-grid">
            <div class="track-card">
                <div class="track-header" style="color: var(--terracotta); font-weight: 700;">SDG 1 & AU Asp 1</div>
                <h3 style="font-size: 1.25rem;">Pillar I: Poverty Reduction</h3>
                <p>Support microfinance training, property rights clinics, and enterprise mentoring.</p>
            </div>
            <div class="track-card">
                <div class="track-header" style="color: var(--savannah-sand); font-weight: 700;">SDG 4 & AU Asp 1</div>
                <h3 style="font-size: 1.25rem;">Pillar II: Education</h3>
                <p>Provide mentorship, tutoring, and digital learning support for both in and out-of-school youth and children.</p>
            </div>
            <div class="track-card">
                <div class="track-header" style="color: var(--primary-color); font-weight: 700;">SDG 8 & AU Asp 1</div>
                <h3 style="font-size: 1.25rem;">Pillar III: Decent Work</h3>
                <p>Deliver skills workshops and entrepreneurship support for youth and SMEs.</p>
            </div>
            <div class="track-card track-highlight" style="background: var(--deep-ebony);">
                <div class="track-header" style="color: var(--secondary-color); font-weight: 700;">SDG 13 & AU Asp 7</div>
                <h3 style="color: white; margin-bottom: 0.5rem; font-size: 1.25rem;">Pillar IV: Climate Action</h3>
                <p style="color: rgba(255,255,255,0.8); margin: 0;">Support resilience planning, climate-smart agriculture, and adaptation solutions.</p>
            </div>
        </div>
    </div>
</section>

<!-- 6. 4 Days, 4 Venues -->
<section id="venues" class="section bg-white border-y">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-eyebrow">The Summit Experience</span>
            <h2>4 Days. 4 Landmark Venues.</h2>
            <span class="african-divider-sm center"></span>
            <p class="subtitle mt-1">An immersive journey through Nairobi's most iconic institutions.</p>
        </div>
        
        <div class="venue-grid mt-4">
            <div class="venue-card" style="background-image: url('assets/venues/kicc.jpg');">
                <div class="venue-overlay"></div>
                <div class="venue-content">
                    <span class="venue-day">Day 1</span>
                    <h3>Venue to be confirmed</h3>
                    <p class="venue-event">Future Leaders & Academia</p>
                    <p class="venue-desc">Kicking off the summit, bridging the gap between student innovation and corporate pro-bono architectures.</p>
                    <a href="program#day1" style="display: inline-block; margin-top: 1rem; color: var(--secondary-color); font-weight: 600; text-decoration: none; position: relative; z-index: 3;">View Itinerary &rarr;</a>
                </div>
            </div>
            <div class="venue-card" style="background-image: url('assets/strath.jpg');">
                <div class="venue-overlay"></div>
                <div class="venue-content">
                    <span class="venue-day">Day 2</span>
                    <h3>Venue to be confirmed</h3>
                    <p class="venue-event">Policy, Compliance & ESG</p>
                    <p class="venue-desc">A deep dive into regulatory frameworks and corporate governance and policy.</p>
                    <a href="program#day2" style="display: inline-block; margin-top: 1rem; color: var(--secondary-color); font-weight: 600; text-decoration: none; position: relative; z-index: 3;">View Itinerary &rarr;</a>
                </div>
            </div>
            <div class="venue-card" style="background-image: url('assets/venues/placeholder_venue_3.jpg');">
                <div class="venue-overlay"></div>
                <div class="venue-content">
                    <span class="venue-day">Day 3</span>
                    <h3>Venue to be confirmed</h3>
                    <p class="venue-event">Global Networking & Main Summit</p>
                    <p class="venue-desc">The primary institutional gathering featuring global keynotes and strategy sessions.</p>
                    <a href="program#day3" style="display: inline-block; margin-top: 1rem; color: var(--secondary-color); font-weight: 600; text-decoration: none; position: relative; z-index: 3;">View Itinerary &rarr;</a>
                </div>
            </div>
            <div class="venue-card" style="background-image: url('assets/venues/placeholder_gala.jpg');">
                <div class="venue-overlay"></div>
                <div class="venue-content">
                    <span class="venue-day">Day 4</span>
                    <h3>Venue to be confirmed</h3>
                    <p class="venue-event">Gala Dinner & Impact Awards</p>
                    <p class="venue-desc">Closing the summit with an elegant evening of celebration, recognizing outstanding pro-bono contributions across Africa.</p>
                    <a href="program#day4" style="display: inline-block; margin-top: 1rem; color: var(--secondary-color); font-weight: 600; text-decoration: none; position: relative; z-index: 3;">View Itinerary &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 7. Global Speaker Gallery -->
<section id="speakers" class="section bg-dark text-light" style="background-color: var(--night-sky); background-image: var(--pattern-adinkra); background-size: 80px 80px; color: white;">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-eyebrow" style="color: var(--kente-gold);">Global Speaker Gallery</span>
            <h2 class="text-white" style="color: white;">Voices of Impact</h2>
            <span class="african-divider-sm center" style="opacity: 0.7;"></span>
        </div>
        
        <div class="speaker-spotlight-wrapper" style="margin-top: 3rem;">
            <?php if (count($speakers) > 0): ?>
                <div class="speaker-list">
                    <?php foreach ($speakers as $index => $speaker): ?>
                        <button class="speaker-btn <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>" 
                            data-name="<?php echo htmlspecialchars($speaker['name']); ?>" 
                            data-role="<?php echo htmlspecialchars($speaker['role']); ?>"
                            data-track="<?php echo htmlspecialchars($speaker['track']); ?>"
                            data-bio="<?php echo htmlspecialchars($speaker['bio']); ?>"
                            data-image="<?php echo htmlspecialchars($speaker['image_url']); ?>"
                            data-video="<?php echo htmlspecialchars($speaker['video_url']); ?>">
                            <div class="sb-name"><?php echo htmlspecialchars($speaker['name']); ?></div>
                            <div class="sb-role"><?php echo htmlspecialchars($speaker['role']); ?></div>
                        </button>
                    <?php endforeach; ?>
                </div>
                <div class="speaker-display">
                    <div class="sd-image" style="position: relative;">
                        <?php
                        $firstSpeakerImg = $speakers[0]['image_url'] ? htmlspecialchars($speakers[0]['image_url']) : 'https://ui-avatars.com/api/?name=' . urlencode($speakers[0]['name']) . '&background=random&size=500';
                        if ($speakers[0]['name'] == 'Fredrick Sadia' && !$speakers[0]['image_url']) {
                            $firstSpeakerImg = 'assets/fredsadia.png';
                        }
                        ?>
                        <img id="sd-img" src="<?php echo $firstSpeakerImg; ?>" alt="<?php echo htmlspecialchars($speakers[0]['name']); ?>">
                        <div id="sd-video-btn" class="video-play-btn" style="display: <?php echo $speakers[0]['video_url'] ? 'flex' : 'none'; ?>;" onclick="openVideoModal(document.querySelector('.speaker-btn.active').getAttribute('data-video'))">
                            <i class="fa-solid fa-play"></i>
                        </div>
                    </div>
                    <div class="sd-content">
                        <span class="badge" id="sd-track"><?php echo htmlspecialchars($speakers[0]['track']); ?></span>
                        <h3 id="sd-name" style="color: white;"><?php echo htmlspecialchars($speakers[0]['name']); ?></h3>
                        <p class="sd-bio" id="sd-bio"><?php echo htmlspecialchars($speakers[0]['bio']); ?></p>
                    </div>
                </div>
            <?php else: ?>
                    <p style="color: var(--text-muted); text-align: center; width: 100%;">Keynote speakers will be announced soon.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Video Modal -->
<div id="videoModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.9);">
    <div class="modal-content" style="margin: 10% auto; width: 80%; max-width: 800px; position: relative;">
        <span class="close" onclick="closeVideoModal()" style="color: white; float: right; font-size: 28px; font-weight: bold; cursor: pointer; position: absolute; right: -30px; top: -30px;">&times;</span>
        <div style="padding-top: 56.25%; position: relative;">
            <iframe id="videoIframe" src="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowfullscreen></iframe>
        </div>
    </div>
</div>

<style>
.video-play-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60px;
    height: 60px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    transition: transform 0.3s;
}
.video-play-btn:hover {
    transform: translate(-50%, -50%) scale(1.1);
}
</style>

<script>
function openVideoModal(url) {
    if(!url) return;
    let embedUrl = url;
    if(url.includes('youtube.com/watch?v=')) {
        embedUrl = url.replace('watch?v=', 'embed/');
    } else if(url.includes('youtu.be/')) {
        embedUrl = url.replace('youtu.be/', 'youtube.com/embed/');
    }
    document.getElementById('videoIframe').src = embedUrl;
    document.getElementById('videoModal').style.display = 'block';
}
function closeVideoModal() {
    document.getElementById('videoIframe').src = '';
    document.getElementById('videoModal').style.display = 'none';
}
</script>

<!-- 8. Delegate Logistics Re-design -->
<section id="logistics" class="section" style="background: url('https://images.unsplash.com/photo-1547471080-7fc2caa6f57e?q=80&w=2070&auto=format&fit=crop') center/cover; position: relative; padding: 8rem 0;">
    <div style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(13,27,42,0.88); background-image: var(--pattern-adinkra); background-size: 80px 80px;"></div>
    <div class="container" style="position: relative; z-index: 2;">
        <div class="section-header text-center text-light" style="margin-bottom: 4rem;">
            <span class="section-eyebrow" style="color: var(--kente-gold);">Seamless Experience</span>
            <h2 style="color: white;">Delegate Logistics</h2>
            <span class="african-divider-sm center" style="opacity: 0.8; display:block; margin: 0.75rem auto;"></span>
        </div>
        
        <div class="logistics-glass-grid">
            <div class="glass-card">
                <div class="glass-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                </div>
                <h3>Visa & Entry</h3>
                <p>Navigate the Kenyan e-Visa portal effortlessly. We provide official invitation letters to all registered international delegates within 48 hours for expedited processing.</p>
                <a href="logistics#visa" class="glass-link">Get Visa Info &rarr;</a>
            </div>
            
            <div class="glass-card">
                <div class="glass-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <h3>Premium Accommodation</h3>
                <p>Enjoy negotiated corporate rates at our 5-star partner hotels situated within a 2-kilometer radius of our primary venues. Complimentary daily shuttles included.</p>
                <a href="accommodations" class="glass-link">View Partner Hotels &rarr;</a>
            </div>
            
            <div class="glass-card">
                <div class="glass-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <h3>Transport & Navigation</h3>
                <p>From VIP airport transfers to dedicated Summit transport covering all 4 event venues, your entire itinerary is managed by our delegate concierge team.</p>
                <a href="logistics#transport" class="glass-link">View Transport Map &rarr;</a>
            </div>
            
            <!-- Adding the Tourism card link to the grid -->
            <div class="glass-card" style="grid-column: 1 / -1; display: flex; flex-direction: column; align-items: flex-start; gap: 1.5rem; padding: 2rem;">
                <div>
                    <h3 style="margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span style="color: var(--secondary-color);"><i class="fa-solid fa-earth-africa"></i></span> Post-Summit Touring
                    </h3>
                    <p style="margin: 0; max-width: 600px;">Extend your trip and experience the magical Maasai Mara or Nairobi National Park. We coordinate bespoke Safari extensions.</p>
                </div>
                <a href="logistics#tourism" class="btn btn-secondary">Explore Safaris</a>
            </div>
        </div>
    </div>
</section>

<!-- 6.5 Latest News & Updates -->
<section id="news" class="section bg-white">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-eyebrow">Stay Informed</span>
            <h2>News & Updates</h2>
            <span class="african-divider-sm center"></span>
            <p class="subtitle mt-1">Latest announcements and impact stories from the Summit.</p>
        </div>
        
        <div class="grid-3-col" style="margin-top: 3rem;">
            <?php if (count($latest_news) > 0): ?>
                    <?php foreach ($latest_news as $news): ?>
                            <div class="african-frame" style="background: white; border-radius: var(--border-radius-lg); border: 1px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column; cursor: pointer;" onclick="window.location.href='news_article?id=<?php echo $news['id']; ?>'">
                                <div style="height: 200px; overflow: hidden; position: relative;">
                                    <img src="<?php echo htmlspecialchars($news['image_url']); ?>" alt="News" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                </div>
                                <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                                    <div style="color: var(--kente-gold); font-size: 0.8rem; font-weight: 700; margin-bottom: 0.5rem; text-transform: uppercase;">
                                        <?php echo date('M d, Y', strtotime($news['created_at'])); ?>
                                    </div>
                                    <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; color: #0f172a; line-height: 1.3;"><?php echo htmlspecialchars($news['title']); ?></h3>
                                    <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1rem; flex-grow: 1;">
                                        <?php echo htmlspecialchars($news['excerpt']); ?>
                                    </p>
                                    <a href="news_article?id=<?php echo $news['id']; ?>" style="color: var(--secondary-color); font-weight: 600; font-size: 0.9rem; text-decoration: none;">Read More &rarr;</a>
                                </div>
                            </div>
                    <?php endforeach; ?>
            <?php else: ?>
                    <p style="text-align: center; color: var(--text-muted); grid-column: 1 / -1;">No news updates currently available.</p>
            <?php endif; ?>
        </div>
        
        <div style="text-align: center; margin-top: 4rem;">
            <a href="news" class="btn btn-primary" style="padding: 1rem 3rem; font-size: 1.1rem;"><i class="fa-solid fa-newspaper" style="margin-right: 0.5rem;"></i> View All News Updates</a>
        </div>
    </div>
</section>

<!-- 9. The Resource Center (Think Pieces) -->
<section id="resources" class="section section-alt">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-eyebrow">Knowledge Hub</span>
            <h2>The Resource Center</h2>
            <span class="african-divider-sm center"></span>
        </div>
        
        <div class="grid-3-col" style="margin-top: 3rem;">
            <div class="resource-card-mini">
                <div class="rc-icon"><i class="fa-solid fa-file-pdf"></i></div>
                <h4>Whitepapers</h4>
                <p>Downloadable research on the state of pro-bono in Africa.</p>
                <a href="resources#whitepapers">Access Library &rarr;</a>
            </div>
            <div class="resource-card-mini">
                <div class="rc-icon"><i class="fa-solid fa-chart-line"></i></div>
                <h4>Case Studies</h4>
                <p>Success stories and metrics from Jitolee’s flagship past projects.</p>
                <a href="resources#casestudies">Read Cases &rarr;</a>
            </div>
            <div class="resource-card-mini">
                <div class="rc-icon"><i class="fa-solid fa-layer-group"></i></div>
                <h4>Media Toolkit</h4>
                <p>Branding assets, logos, and templates for partners to share.</p>
                <a href="resources#media-toolkit">Download Kit &rarr;</a>
            </div>
        </div>
    </div>
</section>

<!-- 10. Major Partners -->
<section id="major-partners" class="section bg-light">
    <div class="container text-center">
        <span class="section-eyebrow">Supported By</span>
        <h2>Major Partners</h2>
        <span class="african-divider-sm center"></span>
        <div class="partners-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 3rem; align-items: center;">
            <?php if (count($major_partners) > 0): ?>
                    <?php foreach ($major_partners as $partner): ?>
                            <div class="partner-card" style="background: white; padding: 2rem; border-radius: var(--border-radius); box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                                <?php if ($partner['image_url']): ?>
                                        <img src="<?php echo htmlspecialchars($partner['image_url']); ?>" alt="<?php echo htmlspecialchars($partner['name']); ?>" style="max-width: 100%; max-height: 100px; object-fit: contain;">
                                <?php else: ?>
                                        <h4 style="color: var(--primary-color); margin: 0;"><?php echo htmlspecialchars($partner['name']); ?></h4>
                                <?php endif; ?>
                                <?php if ($partner['description']): ?>
                                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 1rem;"><?php echo htmlspecialchars($partner['description']); ?></p>
                                <?php endif; ?>
                            </div>
                    <?php endforeach; ?>
            <?php else: ?>
                    <p style="color: var(--text-muted); grid-column: 1 / -1;">Our partners will be announced soon.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- 11. Partners & Global Network -->
<section id="partners" class="section bg-white border-y">
    <div class="container text-center">
        <span class="section-eyebrow">The Ecosystem</span>
        <h2>Partners & Global Network</h2>
        <span class="african-divider-sm center"></span>
        
        <div class="partners-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 3rem; align-items: center;">
            <?php if (count($ecosystem_partners) > 0): ?>
                    <?php foreach ($ecosystem_partners as $partner): ?>
                            <div class="partner-card" style="background: white; padding: 2rem; border-radius: var(--border-radius); box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                                <?php if ($partner['image_url']): ?>
                                        <img src="<?php echo htmlspecialchars($partner['image_url']); ?>" alt="<?php echo htmlspecialchars($partner['name']); ?>" style="max-width: 100%; max-height: 100px; object-fit: contain;">
                                <?php else: ?>
                                        <h4 style="color: var(--primary-color); margin: 0;"><?php echo htmlspecialchars($partner['name']); ?></h4>
                                <?php endif; ?>
                                <?php if ($partner['description']): ?>
                                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 1rem;"><?php echo htmlspecialchars($partner['description']); ?></p>
                                <?php endif; ?>
                            </div>
                    <?php endforeach; ?>
            <?php else: ?>
                    <p style="color: var(--text-muted); grid-column: 1 / -1;">Our global network will be updated soon.</p>
            <?php endif; ?>
        </div>

        <div class="gpbn-cta" style="margin-top: 4rem; padding: 4rem 2rem; background: linear-gradient(rgba(15,23,42,0.85), rgba(15,23,42,0.95)), url('assets/gpbn_cta_bg.jpg') center/cover; border-radius: var(--border-radius-lg); text-align: center; color: white; box-shadow: var(--shadow-lg);">
            <img src="assets/globalprobono.png" alt="Global Pro Bono Network" style="max-height: 90px; margin: 0 auto 1.5rem; filter: brightness(0) invert(1);">
            <h3 style="font-size: 2rem; margin-bottom: 1rem; color: white; font-family: var(--font-heading);">A Proud Member of the Global Pro Bono Network</h3>
            <p style="font-size: 1.15rem; color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto 2.5rem; line-height: 1.6;">Connecting with visionary leaders worldwide to drive sustainable impact and empower communities across continents through professional volunteerism.</p>
            <a href="https://globalprobono.org" target="_blank" class="btn btn-primary btn-lg" style="background: var(--terracotta); border-color: var(--terracotta); color: white;">Explore The Network &rarr;</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
