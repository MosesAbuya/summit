<?php 
require 'includes/db.php';

// Fetch Latest 3 News
$stmt = $pdo->query("SELECT * FROM news WHERE status = 'Published' ORDER BY created_at DESC LIMIT 3");
$latest_news = $stmt->fetchAll();

include 'includes/header.php'; 
?>
<!-- 1. Sick Interactive Hero Carousel -->
<style>
    .hero-carousel { position: relative; height: 95vh; min-height: 600px; width: 100%; overflow: hidden; background: #000; }
    .carousel-slide { position: absolute; top:0; left:0; width: 100%; height: 100%; opacity: 0; visibility: hidden; transition: opacity 1s cubic-bezier(0.4, 0, 0.2, 1), transform 1s cubic-bezier(0.4, 0, 0.2, 1); transform: scale(1.05); }
    .carousel-slide.active { opacity: 1; visibility: visible; transform: scale(1); z-index: 2; }
    .carousel-bg { position: absolute; top:0; left:0; width: 100%; height: 100%; object-fit: cover; z-index: 1; filter: brightness(0.45); }
    .carousel-content { position: relative; z-index: 3; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: flex-start; padding: 0 10%; }
    
    .carousel-title { font-size: clamp(3rem, 6vw, 5.5rem); color: white; line-height: 1.1; margin-bottom: 1.5rem; font-weight: 800; transform: translateY(40px); opacity: 0; transition: all 0.8s 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .carousel-subtitle { font-size: 1.25rem; color: rgba(255,255,255,0.9); max-width: 600px; margin-bottom: 2.5rem; transform: translateY(30px); opacity: 0; transition: all 0.8s 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    .carousel-actions { transform: translateY(30px); opacity: 0; transition: all 0.8s 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
    
    .carousel-slide.active .carousel-title, .carousel-slide.active .carousel-subtitle, .carousel-slide.active .carousel-actions { transform: translateY(0); opacity: 1; }

    /* Thumbnails */
    .carousel-thumbnails { position: absolute; bottom: 3rem; right: 10%; z-index: 10; display: flex; gap: 1rem; }
    .thumb { width: 140px; height: 85px; border-radius: 8px; overflow: hidden; cursor: pointer; border: 2px solid transparent; transition: all 0.3s; position: relative; }
    .thumb img { width: 100%; height: 100%; object-fit: cover; opacity: 0.5; transition: 0.3s; }
    .thumb:hover img { opacity: 0.8; }
    .thumb.active { border-color: var(--secondary-color); transform: scale(1.05); box-shadow: 0 10px 20px rgba(0,0,0,0.5); }
    .thumb.active img { opacity: 1; }
    .thumb-label { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; font-size: 0.7rem; padding: 15px 8px 5px; text-transform: uppercase; font-weight: 700; text-align: center; }
    
    /* Progress Bar */
    .carousel-progress { position: absolute; bottom: 0; left: 0; height: 5px; background: rgba(255,255,255,0.1); width: 100%; z-index: 10; }
    .progress-bar { height: 100%; background: var(--secondary-color); width: 0; transition: width 6s linear; }
    .carousel-slide.active ~ .carousel-progress .progress-bar { width: 100%; }
    
    @media (max-width: 768px) {
        .carousel-thumbnails { display: none; }
    }
</style>

<div class="hero-carousel" id="homeHero">

    <!-- Slide 1 -->
    <div class="carousel-slide active" data-index="0">
        <img class="carousel-bg" src="assets/hero_slide_1.png" alt="Summit Main">
        <div class="carousel-content">
            <span style="display: inline-block; padding: 0.5rem 1.2rem; background: rgba(255,255,255,0.1); border-radius: 30px; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: white; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.5rem;">Nov 24-27 • Nairobi, Kenya</span>
            <h1 class="carousel-title" style="font-size: clamp(2.5rem, 5vw, 4.5rem);">GLOBAL SUMMIT ON<br>PRO BONO PRACTICE<br>AFRICA</h1>
            <p class="carousel-subtitle">"Leveraging Multidisciplinary Pro Bono for SDGs and Agenda 2063"</p>
            <div class="carousel-actions">
                <a href="register" class="btn btn-primary btn-lg">Secure Your Pass</a>
                <a href="program" class="btn btn-outline btn-lg" style="color: white; border-color: rgba(255,255,255,0.5);">View Itinerary</a>
            </div>
        </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-slide" data-index="1">
        <img class="carousel-bg" src="assets/hero_slide_2.png" alt="Partner">
        <div class="carousel-content">
            <span style="display: inline-block; padding: 0.5rem 1.2rem; background: rgba(234,179,8,0.2); border-radius: 30px; border: 1px solid rgba(234,179,8,0.5); backdrop-filter: blur(10px); color: var(--secondary-color); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.5rem;">Strategic Alliances</span>
            <h1 class="carousel-title">Become a Corporate<br>Partner</h1>
            <p class="carousel-subtitle">Align your brand with Africa's premier social impact event. Explore Diamond, Platinum, and Gold sponsorship tiers to supercharge your ESG goals.</p>
            <div class="carousel-actions">
                <a href="partners" class="btn btn-secondary btn-lg" style="color: #000;">View Corporate Tiers</a>
                <a href="contact" class="btn btn-outline btn-lg" style="color: white; border-color: rgba(255,255,255,0.5);">Request Deck</a>
            </div>
        </div>
    </div>

    <!-- Slide 3 -->
    <div class="carousel-slide" data-index="2">
        <img class="carousel-bg" src="assets/hero_slide_3.png" alt="Support">
        <div class="carousel-content">
            <span style="display: inline-block; padding: 0.5rem 1.2rem; background: rgba(255,255,255,0.1); border-radius: 30px; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: white; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.5rem;">Empower Grassroots</span>
            <h1 class="carousel-title">Support The<br>Movement</h1>
            <p class="carousel-subtitle">Cannot attend? Your financial support can sponsor an African grassroots NGO leader to access the summit fully subsidized.</p>
            <div class="carousel-actions">
                <a href="register" class="btn btn-primary btn-lg">Sponsor a Delegate</a>
            </div>
        </div>
    </div>

    <!-- Slide 4 -->
    <div class="carousel-slide" data-index="3">
        <img class="carousel-bg" src="assets/hero_slide_4.png" alt="Gala">
        <div class="carousel-content">
            <span style="display: inline-block; padding: 0.5rem 1.2rem; background: rgba(255,255,255,0.1); border-radius: 30px; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: white; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.5rem;">Day 4 Conclusion</span>
            <h1 class="carousel-title">The Global Impact<br>Awards Gala</h1>
            <p class="carousel-subtitle">Join us at the Nairobi Safari Club for a night of elegance, celebrating the pioneers of Pan-African volunteerism.</p>
            <div class="carousel-actions">
                <a href="program#day4" class="btn btn-secondary btn-lg" style="color: #000;">View Gala Details</a>
            </div>
        </div>
    </div>

    <div class="carousel-thumbnails">
        <div class="thumb active" data-target="0">
            <img src="assets/hero_slide_1.png">
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
<section id="about" class="section section-alt">
    <div class="container">
        <div class="welcome-grid">
            <div class="welcome-text">
                <h2 class="welcome-title">Welcome to the Global Summit on Pro Bono Practice</h2>
                <p>In a world facing interconnected crises including climate disasters, AI job shifts, and educational gaps, this Summit is designed to regenerate and transform the landscape of professional pro bono service and volunteerism to intervene and address these polycrises.</p>
                <p>Organized by the Global Pro Bono Network and Jitolee Good Friends Foundation, the Summit drives a <strong>'Multidisciplinary Revolution'</strong> by embedding healthcare, technology, education, climate, and finance into the ecosystem.</p>
                <p>The Conference is set to take place from <strong>November 24th to 27th, 2026 in Nairobi, Kenya</strong>. This year's core focus:</p>
                
                <div class="blockquote-highlight mt-2">
                    <p class="quote-text">"Leveraging Multidisciplinary Pro Bono for SDGs and Agenda 2063."</p>
                    <p class="quote-sub">Aligning with the United Nations Agenda 2030 and the African Union Agenda 2063 to co-create high-impact sustainable solutions.</p>
                </div>
            </div>
            <div class="welcome-image-wrapper african-frame">
                <img src="assets/fredsadia.png" alt="Fredrick Sadia - Founder" class="founder-img" style="object-position: top;">
                <div class="play-button-overlay">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. The Theme Section -->
<section class="section bg-white border-y" style="border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
    <div class="container">
        <div class="grid-2-col align-center">
            <div class="theme-overview-text">
                <span class="section-eyebrow">2026 Summit Theme</span>
                <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem; color: #0f172a;">A Multidisciplinary Revolution</h2>
                <p class="lead-text">Embedding healthcare, technology, education, and climate action.</p>
                <p style="font-size: 1.1rem; line-height: 1.8; color: var(--text-main);">
                    While African pro bono initiatives have traditionally focused on legal services, this Summit expands the horizon. By bridging the gap between professional expertise and community needs, we aim to deliver tangible Return on Investment (ROI): enhanced corporate ESG profiles, skilled talent development, and community resilience gains.
                    <br><br>
                    The Summit focuses on four critical SDGs: No Poverty (1), Quality Education (4), Decent Work (8), and Climate Action (13), directly advancing AU Agenda 2063 Aspirations for a Prosperous and People-driven Africa.
                </p>
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
                GLOBAL PRO-BONO<br>
                <span>SUMMIT AFRICA 2026</span>
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
        <div class="tracks-grid">
            <div class="track-card">
                <div class="track-header" style="color: var(--terracotta); font-weight: 700;">SDG 1 & AU Asp 1</div>
                <h3>No Poverty</h3>
                <p>Pro bono financial advisory, microfinance training, and property rights clinics to break intergenerational poverty cycles.</p>
            </div>
            <div class="track-card">
                <div class="track-header" style="color: var(--savannah-sand); font-weight: 700;">SDG 4 & AU Asp 1</div>
                <h3>Quality Education</h3>
                <p>Bridging the education gap for out-of-school youth with tech-driven mentorship and digital learning platforms.</p>
            </div>
            <div class="track-card">
                <div class="track-header" style="color: var(--primary-color); font-weight: 700;">SDG 8 & AU Asp 1</div>
                <h3>Decent Work</h3>
                <p>Harnessing the youth bulge through multidisciplinary pro bono for SME growth, employability, and tech/finance skills.</p>
            </div>
            <div class="track-card track-highlight" style="background: var(--deep-ebony);">
                <div class="track-header" style="color: var(--secondary-color); font-weight: 700;">SDG 13 & AU Asp 7</div>
                <h3 style="color: white; margin-bottom: 0.5rem;">Climate Action</h3>
                <p style="color: rgba(255,255,255,0.8); margin: 0;">Exporting resilience: Nature-based solutions and expert climate volunteering to protect vulnerable livelihoods.</p>
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
            <div class="venue-card" style="background-image: url('assets/venues/uon.jpg');">
                <div class="venue-overlay"></div>
                <div class="venue-content">
                    <span class="venue-day">Day 1</span>
                    <h3>UON Main Hall</h3>
                    <p class="venue-event">Future Leaders & Academia</p>
                    <p class="venue-desc">Kicking off the summit at the University of Nairobi, bridging the gap between student innovation and corporate pro-bono architectures.</p>
                    <a href="program#day1" style="display: inline-block; margin-top: 1rem; color: var(--secondary-color); font-weight: 600; text-decoration: none; position: relative; z-index: 3;">View Itinerary &rarr;</a>
                </div>
            </div>
            <div class="venue-card" style="background-image: url('assets/venues/kra.jpg');">
                <div class="venue-overlay"></div>
                <div class="venue-content">
                    <span class="venue-day">Day 2</span>
                    <h3>KRA Hall</h3>
                    <p class="venue-event">Policy, Compliance & ESG</p>
                    <p class="venue-desc">A deep dive into regulatory frameworks and corporate governance, hosted at the prestigious Kenya Revenue Authority complex.</p>
                    <a href="program#day2" style="display: inline-block; margin-top: 1rem; color: var(--secondary-color); font-weight: 600; text-decoration: none; position: relative; z-index: 3;">View Itinerary &rarr;</a>
                </div>
            </div>
            <div class="venue-card" style="background-image: url('assets/venues/kicc.jpg');">
                <div class="venue-overlay"></div>
                <div class="venue-content">
                    <span class="venue-day">Day 3</span>
                    <h3>KICC Plenary</h3>
                    <p class="venue-event">Global Networking & Main Summit</p>
                    <p class="venue-desc">The primary institutional gathering at the Kenyatta International Convention Centre, featuring global keynotes and strategy sessions.</p>
                    <a href="program#day3" style="display: inline-block; margin-top: 1rem; color: var(--secondary-color); font-weight: 600; text-decoration: none; position: relative; z-index: 3;">View Itinerary &rarr;</a>
                </div>
            </div>
            <div class="venue-card" style="background-image: url('assets/venues/nairobisafariclub.jpg');">
                <div class="venue-overlay"></div>
                <div class="venue-content">
                    <span class="venue-day">Day 4</span>
                    <h3>Nairobi Safari Club</h3>
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
            <div class="speaker-list">
                <button class="speaker-btn active" data-index="0">
                    <div class="sb-name">Fredrick Sadia</div>
                    <div class="sb-role">Founder, Jitolee Foundation</div>
                </button>
                <button class="speaker-btn" data-index="1">
                    <div class="sb-name">Dr. Amina Mohamed</div>
                    <div class="sb-role">Policy Director, Africa NGO Council</div>
                </button>
                <button class="speaker-btn" data-index="2">
                    <div class="sb-name">David Okello</div>
                    <div class="sb-role">Head of Corporate ESG</div>
                </button>
                <button class="speaker-btn" data-index="3">
                    <div class="sb-name">Sarah Jenkins</div>
                    <div class="sb-role">Global Volunteer Coordinator</div>
                </button>
            </div>
            <div class="speaker-display">
                <div class="sd-image">
                    <img id="sd-img" src="assets/fredsadia.png" alt="Fredrick Sadia">
                </div>
                <div class="sd-content">
                    <span class="badge" id="sd-track">Keynote & Panel: Strengthening Civil Society</span>
                    <h3 id="sd-name" style="color: white;">Fredrick Sadia</h3>
                    <p class="sd-bio" id="sd-bio">Fredrick is a visionary leader in social impact and a board member of the Global Pro Bono Network. He has dedicated over a decade to building frameworks that empower communities through structured volunteerism across Africa.</p>
                </div>
            </div>
        </div>
    </div>
</section>

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
                <a href="logistics#accommodation" class="glass-link">View Partner Hotels &rarr;</a>
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
            <div class="glass-card" style="grid-column: 1 / -1; display: flex; align-items: center; justify-content: space-between; padding: 2rem;">
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
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 3rem;">
            <?php if (count($latest_news) > 0): ?>
                <?php foreach($latest_news as $news): ?>
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
        
        <div style="text-align: center; margin-top: 3rem;">
            <a href="news" class="btn btn-outline" style="border-color: #cbd5e1; color: var(--text-main);">View All News</a>
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

<!-- 10. Partners & Global Network -->
<section id="partners" class="section bg-white border-y">
    <div class="container text-center">
        <span class="section-eyebrow">The Ecosystem</span>
        <h2>Partners & Global Network</h2>
        <span class="african-divider-sm center"></span>
        
        <div class="sponsor-tiers" style="margin-top: 3rem;">
            <div class="tier">
                <h4 class="tier-name" style="color: #64748b;">Platinum Sponsors (KES 5M)</h4>
                <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">Exclusive Naming Rights</p>
                <div class="tier-logos">
                    <div class="logo-box">Safaricom (Invited)</div>
                    <div class="logo-box">BMW Foundation (Invited)</div>
                </div>
            </div>
            <div class="tier" style="margin-top: 2rem;">
                <h4 class="tier-name" style="color: var(--secondary-color);">Gold (KES 3M) & Silver (KES 1.5M)</h4>
                <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">Lead Workshops & Exhibition Priority</p>
                <div class="tier-logos small">
                    <div class="logo-box">Deloitte (Invited)</div>
                    <div class="logo-box">Strathmore Univ.</div>
                    <div class="logo-box">Kenya Red Cross</div>
                </div>
            </div>
            <div class="tier" style="margin-top: 2rem;">
                <h4 class="tier-name" style="color: var(--terracotta);">Bronze Sponsors (KES 500K)</h4>
                <p style="font-size: 0.9rem; color: var(--text-muted);">Registration Desks</p>
            </div>
        </div>

        <div class="network-marquee" style="margin-top: 4rem;">
            <p class="marquee-title">Proud members of the Global Pro Bono Network</p>
            <div class="marquee-track">
                <span>Continental Impact</span> • <span>Jitolee Foundation</span> • <span>Africa NGO Council</span> • <span>Global Pro Bono Network</span>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
