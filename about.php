<?php include 'includes/header.php'; ?>

<style>
    /* ─── About Page Specific Styles ─── */
    .stat-banner { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 0; }
    .stat-banner-item { padding: 2.5rem 1.5rem; text-align: center; border-right: 1px solid rgba(255,255,255,0.1); }
    .stat-banner-item:last-child { border-right: none; }
    .stat-banner-item .num { font-size: 3rem; font-weight: 800; line-height: 1; font-family: var(--font-heading); }
    .stat-banner-item .label { font-size: 0.85rem; color: rgba(255,255,255,0.7); margin-top: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em; }

    .timeline { position: relative; padding-left: 2rem; }
    .timeline::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; background: linear-gradient(to bottom, var(--primary-color), var(--kente-gold), var(--terracotta)); border-radius: 3px; }
    .timeline-item { position: relative; padding: 0 0 3rem 2.5rem; }
    .timeline-item::before { content: ''; position: absolute; left: -2.35rem; top: 5px; width: 16px; height: 16px; border-radius: 50%; background: var(--kente-gold); border: 3px solid var(--primary-color); box-shadow: 0 0 0 4px rgba(212,160,23,0.2); }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-item .day-badge { display: inline-block; background: var(--deep-ebony); color: var(--kente-gold); font-size: 0.8rem; font-weight: 700; padding: 0.25rem 0.75rem; border-radius: 20px; margin-bottom: 0.75rem; border: 1px solid rgba(212,160,23,0.3); text-transform: uppercase; letter-spacing: 0.05em; }

    .partner-value-card { background: white; border-radius: var(--border-radius-lg); border: 1px solid #e2e8f0; padding: 2rem; display: flex; flex-direction: column; gap: 1rem; transition: transform 0.3s, box-shadow 0.3s; }
    .partner-value-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,0.1); }
    .partner-value-card .icon-circle { width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }

    .outcome-row { display: grid; grid-template-columns: auto 1fr; gap: 1.5rem; align-items: start; padding: 1.25rem 0; border-bottom: 1px solid #e2e8f0; }
    .outcome-row:last-child { border-bottom: none; }
    .outcome-icon { width: 48px; height: 48px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem; flex-shrink: 0; }

    .doc-download-card { background: var(--deep-ebony); border: 1px solid rgba(212,160,23,0.3); border-radius: var(--border-radius-lg); padding: 2rem; display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap; transition: border-color 0.3s; }
    .doc-download-card:hover { border-color: var(--kente-gold); }

    .quote-block { padding: 1.5rem 2rem; background: #f8fafc; border-radius: 12px; font-style: italic; font-size: 1.15rem; color: var(--text-main); line-height: 1.7; border: 1px solid #e2e8f0; }
</style>

<!-- ═══ PAGE HERO ═══ -->
<div class="page-header" style="background: linear-gradient(135deg, rgba(15,23,42,0.92) 0%, rgba(22,101,52,0.85) 100%), url('assets/past-summit/231201-101415.jpg') center/cover no-repeat; padding-top: 10rem; padding-bottom: 5rem; color: white;">
    <div class="container">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
            <span class="african-divider-sm" style="display: inline-block; width: 40px; border-color: var(--kente-gold);"></span>
            <span style="color: var(--kente-gold); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.85rem; font-family: 'Outfit', sans-serif;">About the Summit</span>
        </div>
        <h1 style="color: white; font-size: clamp(2rem, 5vw, 3.5rem); max-width: 750px; line-height: 1.2; margin-bottom: 1.5rem;">Africa's Pro Bono Revolution Starts in Nairobi</h1>
        <p style="color: rgba(255,255,255,0.8); font-size: 1.15rem; max-width: 650px; line-height: 1.8; margin-bottom: 2.5rem;">A landmark convening bringing together governments, corporates, universities, NGOs, and global networks to leverage multidisciplinary expertise in service of Africa's development agenda.</p>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="register" class="btn btn-secondary">Register as Delegate</a>
            <a href="#documents" class="btn btn-outline" style="border-color: rgba(255,255,255,0.4); color: white;">Read the Documents &darr;</a>
        </div>
    </div>
</div>

<!-- ═══ STATS BANNER ═══ -->
<div style="background: var(--deep-ebony); border-top: 3px solid var(--kente-gold);">
    <div class="stat-banner">
        <div class="stat-banner-item">
            <div class="num" style="color: var(--kente-gold);">400M</div>
            <div class="label">Africans in Extreme Poverty</div>
        </div>
        <div class="stat-banner-item">
            <div class="num" style="color: var(--terracotta);">100M+</div>
            <div class="label">Out-of-School African Youth</div>
        </div>
        <div class="stat-banner-item">
            <div class="num" style="color: var(--secondary-color);">60%</div>
            <div class="label">World's Unemployed Youth in Africa</div>
        </div>
        <div class="stat-banner-item">
            <div class="num" style="color: #34d399);">70%</div>
            <div class="label">African Livelihoods Threatened by Drought</div>
        </div>
        <div class="stat-banner-item">
            <div class="num" style="color: white;">13.9M</div>
            <div class="label">Volunteers in Kenya Alone (3.66% GDP)</div>
        </div>
    </div>
</div>

<main>

    <!-- ═══ SECTION 1: THE CONCEPT ═══ -->
    <section class="section bg-white" id="concept">
        <div class="container">
            <div class="grid-2-col align-center" style="gap: 4rem;">
                <div>
                    <span class="section-eyebrow">Executive Summary</span>
                    <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem;">A Convening Built for Africa's Critical Juncture</h2>
                    <p style="color: var(--text-main); line-height: 1.8; margin-bottom: 1.25rem;">In a world facing interconnected crises: climate disasters displacing 21 million annually, 700 million living in extreme poverty amid AI job shifts, 250 million children out of school, and conflicts driving migration, the <strong>Global Summit on Pro Bono Practice</strong> is designed to regenerate and transform the landscape of professional pro bono service and volunteerism.</p>
                    <p style="color: var(--text-main); line-height: 1.8; margin-bottom: 1.25rem;">While African pro bono initiatives have traditionally focused on legal services, this Summit drives a <strong>'Multidisciplinary Revolution'</strong> by embedding healthcare, technology, education, climate, and finance into the ecosystem to confront systemic global challenges.</p>
                    <p style="color: var(--text-main); line-height: 1.8;">By aligning with the <strong>United Nations Agenda 2030</strong> and the <strong>African Union Agenda 2063</strong>, the summit provides a robust strategic platform for governments, corporates, NGOs, and academia to co-create high-impact sustainable solutions that empower marginalized communities whose livelihoods are threatened.</p>
                </div>
                <div style="position: relative;">
                    <div class="african-frame-bold image-wrapper shadow-lg radius-lg">
                        <img src="assets/past-summit/231201-131346.jpg" alt="Summit in action" style="width: 100%; height: 380px; object-fit: cover; border-radius: var(--border-radius-lg);">
                    </div>
                    <div style="position: absolute; bottom: -20px; right: -20px; background: var(--primary-color); border-radius: 12px; padding: 1.5rem; color: white; text-align: center; box-shadow: 0 8px 24px rgba(0,0,0,0.2);">
                        <div style="font-size: 2rem; font-weight: 800; font-family: var(--font-heading); line-height: 1;">Nov 24–27</div>
                        <div style="font-size: 0.85rem; opacity: 0.8; margin-top: 0.25rem;">Nairobi, Kenya 2026</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ SECTION 2: RATIONALE ═══ -->
    <section class="section section-alt" id="rationale">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-eyebrow">Why This. Why Now.</span>
                <h2>The Rationale for a Multidisciplinary Revolution</h2>
                <span class="african-divider-sm center"></span>
            </div>
            <div style="max-width: 820px; margin: 3rem auto 0;">
                <div class="quote-block" style="margin-bottom: 3rem;">
                    "AU Agenda 2063 envisions a prosperous Continent based on inclusive growth, the 'Africa We Want.' This summit arrives at a critical juncture. The world needs to bridge the massive skills gap in Africa through professional services."
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 2rem;">
                    <div style="background: white; padding: 2rem; border-radius: var(--border-radius-md); border: 1px solid #e2e8f0;">
                        <h4 style="color: var(--terracotta); margin-bottom: 0.75rem;"><i class="fa-solid fa-bolt-lightning"></i> The Skills Multiplier</h4>
                        <p style="color: var(--text-main); font-size: 0.95rem; line-height: 1.7;">While Africa's GDP continues to grow, systemic barriers in healthcare, infrastructure, and justice remain. Pro bono services act as a <strong>"Force Multiplier,"</strong> giving communities access to high-level technical expertise that would otherwise be cost-prohibitive.</p>
                    </div>
                    <div style="background: white; padding: 2rem; border-radius: var(--border-radius-md); border: 1px solid #e2e8f0;">
                        <h4 style="color: var(--savannah-sand); margin-bottom: 0.75rem;"><i class="fa-solid fa-people-group"></i> Youth & Women as Drivers</h4>
                        <p style="color: var(--text-main); font-size: 0.95rem; line-height: 1.7;">Aligning with the AU's priority on "Engaged and Empowered Youth," the summit focuses on pro bono as a tool for mentorship and economic inclusion, enhancing digital and financial literacy among youth paramount to empowerment.</p>
                    </div>
                    <div style="background: white; padding: 2rem; border-radius: var(--border-radius-md); border: 1px solid #e2e8f0;">
                        <h4 style="color: var(--primary-color); margin-bottom: 0.75rem;"><i class="fa-solid fa-globe-africa"></i> A Hub for Multilateralism</h4>
                        <p style="color: var(--text-main); font-size: 0.95rem; line-height: 1.7;">Nairobi hosts UN agencies, UNEP, premier academic institutions, top-notch corporates, and a vibrant civil society, positioning Kenya as a <strong>strategic global partner</strong> in the pro bono movement towards realizing the African Dream.</p>
                    </div>
                </div>
                <div style="margin-top: 2.5rem; background: white; padding: 2rem; border-radius: var(--border-radius-md);">
                    <h4 style="margin-bottom: 1.25rem; color: var(--text-main);">Global Proof Points That Inspire This Summit</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
                        <div style="display: flex; gap: 1rem; align-items: start;"><span style="color: var(--kente-gold); font-size: 1.25rem; margin-top: 2px;"><i class="fa-solid fa-check-circle"></i></span><span style="color: var(--text-main); font-size: 0.95rem;"><strong>IBM's</strong> tech volunteering digitized <strong>1,000+ NGOs</strong> worldwide.</span></div>
                        <div style="display: flex; gap: 1rem; align-items: start;"><span style="color: var(--kente-gold); font-size: 1.25rem; margin-top: 2px;"><i class="fa-solid fa-check-circle"></i></span><span style="color: var(--text-main); font-size: 0.95rem;"><strong>Deloitte's</strong> skills-based programs lifted <strong>50,000 out of poverty.</strong></span></div>
                        <div style="display: flex; gap: 1rem; align-items: start;"><span style="color: var(--kente-gold); font-size: 1.25rem; margin-top: 2px;"><i class="fa-solid fa-check-circle"></i></span><span style="color: var(--text-main); font-size: 0.95rem;"><strong>Safaricom</strong> digitized <strong>500 SMEs</strong> via tech volunteers, a model replicable in Asia & Latin America.</span></div>
                        <div style="display: flex; gap: 1rem; align-items: start;"><span style="color: var(--kente-gold); font-size: 1.25rem; margin-top: 2px;"><i class="fa-solid fa-check-circle"></i></span><span style="color: var(--text-main); font-size: 0.95rem;"><strong>VSO's</strong> education programs boosted literacy <strong>up to 30%,</strong> informing UNESCO strategies.</span></div>
                        <div style="display: flex; gap: 1rem; align-items: start;"><span style="color: var(--kente-gold); font-size: 1.25rem; margin-top: 2px;"><i class="fa-solid fa-check-circle"></i></span><span style="color: var(--text-main); font-size: 0.95rem;">Climate volunteering <strong>restored 500K hectares</strong> continent-wide, exporting resilience to Pacific islands.</span></div>
                        <div style="display: flex; gap: 1rem; align-items: start;"><span style="color: var(--kente-gold); font-size: 1.25rem; margin-top: 2px;"><i class="fa-solid fa-check-circle"></i></span><span style="color: var(--text-main); font-size: 0.95rem;"><strong>Kenya Red Cross:</strong> 280,000 volunteers reaching over <strong>3.4 million Kenyans.</strong></span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ SECTION 3: OBJECTIVES ═══ -->
    <section class="section bg-white" id="objectives">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-eyebrow">Our Goals</span>
                <h2>Summit Objectives</h2>
                <span class="african-divider-sm center"></span>
                <p class="subtitle mt-1">Four bold, time-bound, measurable outcomes by the close of the Summit and through 2027.</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 2rem; margin-top: 3.5rem;">
                <div style="text-align: center; padding: 2.5rem 2rem; background: #f8fafc; border-radius: var(--border-radius-lg);">
                    <div style="font-size: 3.5rem; font-weight: 900; color: var(--primary-color); font-family: var(--font-heading); line-height: 1;">15</div>
                    <h3 style="font-size: 1.15rem; margin: 0.75rem 0 0.5rem;">Cross-Sector Partnerships</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6;">Secure MoUs between 5 corporates, 5 academics, and 5 NGOs for joint pro bono delivery, tracked via signed agreements.</p>
                </div>
                <div style="text-align: center; padding: 2.5rem 2rem; background: #f8fafc; border-radius: var(--border-radius-lg);">
                    <div style="font-size: 3.5rem; font-weight: 900; color: var(--savannah-sand); font-family: var(--font-heading); line-height: 1;">50</div>
                    <h3 style="font-size: 1.15rem; margin: 0.75rem 0 0.5rem;">Pro Bono Initiatives</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6;">Actionable project blueprints impacting <strong>5,000 Africans directly</strong>, with a global ripple to 50,000 via shared toolkits. 80% implemented quarterly.</p>
                </div>
                <div style="text-align: center; padding: 2.5rem 2rem; background: #f8fafc; border-radius: var(--border-radius-lg);">
                    <div style="font-size: 3.5rem; font-weight: 900; color: var(--terracotta); font-family: var(--font-heading); line-height: 1;">2 to 3</div>
                    <h3 style="font-size: 1.15rem; margin: 0.75rem 0 0.5rem;">University Curricula</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6;">Integrate pro bono practice into at least 2 to 3 university curricula by the end of 2027, creating award-credit service-learning programs.</p>
                </div>
                <div style="text-align: center; padding: 2.5rem 2rem; background: #f8fafc; border-radius: var(--border-radius-lg);">
                    <div style="font-size: 3.5rem; font-weight: 900; color: var(--secondary-color); font-family: var(--font-heading); line-height: 1;">200</div>
                    <h3 style="font-size: 1.15rem; margin: 0.75rem 0 0.5rem;">Nairobi Accord Signatories</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6;">Adopt the landmark Nairobi Pro Bono Declaration, committing 200 stakeholders to <strong>10,000+ pro bono hours</strong> post-summit.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ SECTION 4: THEMATIC AREAS ═══ -->
    <section class="section section-alt" id="themes">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-eyebrow">What We Will Tackle</span>
                <h2>Four Africa-Critical Thematic Areas</h2>
                <span class="african-divider-sm center"></span>
                <p class="subtitle mt-1">Each theme is tied to a specific SDG and AU Agenda 2063 Aspiration, ensuring every session maps to measurable development impact.</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-top: 3.5rem;">
                <div style="background: white; border-radius: var(--border-radius-lg); overflow: hidden; border: 1px solid #e2e8f0;">
                    <div style="height: 180px; overflow: hidden;">
                        <img src="assets/past-summit/231130-101322.jpg" alt="No Poverty" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 1.75rem;">
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap;">
                            <span class="badge" style="background: rgba(193,68,14,0.1); color: var(--terracotta);">SDG 1</span>
                            <span class="badge" style="background: #f0fdf4; color: var(--primary-color);">AU Aspiration 1</span>
                        </div>
                        <h3 style="font-size: 1.3rem; margin-bottom: 0.75rem; color: var(--terracotta);">No Poverty</h3>
                        <p style="color: var(--text-main); font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">400 million Africans, nearly 60% of the global poor, need targeted intervention. Pro bono financial advisors deliver microfinance training and property rights clinics to smallholder farmers. Corporates provide business mentoring with dedicated funding pipelines for women- and youth-led enterprises.</p>
                        <p style="color: var(--text-muted); font-size: 0.85rem; border-top: 1px solid #e2e8f0; padding-top: 1rem;"><strong>Target:</strong> Break intergenerational poverty cycles with market linkages and structured funding pipelines.</p>
                    </div>
                </div>
                <div style="background: white; border-radius: var(--border-radius-lg); overflow: hidden; border: 1px solid #e2e8f0;">
                    <div style="height: 180px; overflow: hidden;">
                        <img src="assets/past-summit/231201-101415.jpg" alt="Quality Education" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 1.75rem;">
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap;">
                            <span class="badge" style="background: rgba(234,179,8,0.1); color: var(--savannah-sand);">SDG 4</span>
                            <span class="badge" style="background: #f0fdf4; color: var(--primary-color);">AU Aspiration 1</span>
                        </div>
                        <h3 style="font-size: 1.3rem; margin-bottom: 0.75rem; color: var(--savannah-sand);">Quality Education</h3>
                        <p style="color: var(--text-main); font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">Over 100 million African youth face acute barriers to quality education. Pro bono educators and tech experts deliver mentorship and digital learning platforms, while universities pioneer student-led tutoring programs integrated into curricula.</p>
                        <p style="color: var(--text-muted); font-size: 0.85rem; border-top: 1px solid #e2e8f0; padding-top: 1rem;"><strong>Target:</strong> A 20% enrollment increase in pilot communities within 12 months, scalable nationally.</p>
                    </div>
                </div>
                <div style="background: white; border-radius: var(--border-radius-lg); overflow: hidden; border: 1px solid #e2e8f0;">
                    <div style="height: 180px; overflow: hidden;">
                        <img src="assets/past-summit/231201-135335.jpg" alt="Decent Work" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 1.75rem;">
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap;">
                            <span class="badge" style="background: rgba(22,101,52,0.1); color: var(--primary-color);">SDG 8</span>
                            <span class="badge" style="background: #f0fdf4; color: var(--primary-color);">AU Aspiration 1</span>
                        </div>
                        <h3 style="font-size: 1.3rem; margin-bottom: 0.75rem; color: var(--primary-color);">Decent Work</h3>
                        <p style="color: var(--text-main); font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">Africa is home to 60% of the world's unemployed youth despite comprising only 16% of the global population. Pro bono professionals deliver skills workshops in tech, finance, and agri-business, while corporate volunteers match with SMEs for hands-on mentoring.</p>
                        <p style="color: var(--text-muted); font-size: 0.85rem; border-top: 1px solid #e2e8f0; padding-top: 1rem;"><strong>Target:</strong> Employer-recognized credentials for immediate employability through entrepreneurship certification curricula.</p>
                    </div>
                </div>
                <div style="background: white; border-radius: var(--border-radius-lg); overflow: hidden; border: 1px solid #e2e8f0;">
                    <div style="height: 180px; overflow: hidden;">
                        <img src="assets/past-summit/231201-153912.jpg" alt="Climate Action" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 1.75rem;">
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap;">
                            <span class="badge" style="background: rgba(14,165,233,0.1); color: #0ea5e9;">SDG 13</span>
                            <span class="badge" style="background: #f0fdf4; color: var(--primary-color);">AU Aspiration 7</span>
                        </div>
                        <h3 style="font-size: 1.3rem; margin-bottom: 0.75rem; color: #0ea5e9;">Climate Action</h3>
                        <p style="color: var(--text-main); font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">Droughts threaten 70% of African livelihoods, mirroring global climate displacement of 21 million annually. Pro bono engineers and agronomists develop climate resilience plans including drought-resistant farming and water harvesting, anchored in UNEA-7 nature-based solutions.</p>
                        <p style="color: var(--text-muted); font-size: 0.85rem; border-top: 1px solid #e2e8f0; padding-top: 1rem;"><strong>Target:</strong> Deploy proven adaptive strategies among smallholder farmers via youth innovation pitch forums.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ SECTION 5: VALUE PROPOSITION ═══ -->
    <section class="section bg-white" id="value">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-eyebrow">Strategic Value</span>
                <h2>Why Partner with This Summit?</h2>
                <span class="african-divider-sm center"></span>
                <p class="subtitle mt-1">The Summit creates a high-impact marketplace where professional expertise delivers measurable development returns for all stakeholders.</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 2rem; margin-top: 3.5rem;">
                <div class="partner-value-card">
                    <div class="icon-circle" style="background: rgba(193,68,14,0.1);">
                        <i class="fa-solid fa-building" style="color: var(--terracotta);"></i>
                    </div>
                    <h3 style="font-size: 1.2rem; color: var(--terracotta);">For Corporates</h3>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                        <li style="display: flex; gap: 0.75rem; align-items: start; font-size: 0.95rem; color: var(--text-main);"><i class="fa-solid fa-star" style="color: var(--kente-gold); margin-top: 3px; flex-shrink: 0;"></i> <span><strong>ESG Leadership:</strong> Position your brand as a "Purpose Before Profit" leader in healthcare, education, and economic empowerment.</span></li>
                        <li style="display: flex; gap: 0.75rem; align-items: start; font-size: 0.95rem; color: var(--text-main);"><i class="fa-solid fa-star" style="color: var(--kente-gold); margin-top: 3px; flex-shrink: 0;"></i> <span><strong>Talent Retention:</strong> Employees are 3x more engaged when applying skills for social good, reducing turnover by 25% (Deloitte Research).</span></li>
                        <li style="display: flex; gap: 0.75rem; align-items: start; font-size: 0.95rem; color: var(--text-main);"><i class="fa-solid fa-star" style="color: var(--kente-gold); margin-top: 3px; flex-shrink: 0;"></i> <span><strong>Brand Purpose:</strong> Lead specialized workshops and high-level leadership dialogues that define ESG benchmarks.</span></li>
                    </ul>
                </div>
                <div class="partner-value-card">
                    <div class="icon-circle" style="background: rgba(234,179,8,0.1);">
                        <i class="fa-solid fa-graduation-cap" style="color: var(--savannah-sand);"></i>
                    </div>
                    <h3 style="font-size: 1.2rem; color: var(--savannah-sand);">For Academia</h3>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                        <li style="display: flex; gap: 0.75rem; align-items: start; font-size: 0.95rem; color: var(--text-main);"><i class="fa-solid fa-star" style="color: var(--kente-gold); margin-top: 3px; flex-shrink: 0;"></i> <span><strong>Service-Learning Innovation:</strong> Pioneer curricula awarding academic credits for pro bono work, building graduate professional identity.</span></li>
                        <li style="display: flex; gap: 0.75rem; align-items: start; font-size: 0.95rem; color: var(--text-main);"><i class="fa-solid fa-star" style="color: var(--kente-gold); margin-top: 3px; flex-shrink: 0;"></i> <span><strong>Supervised Rotations:</strong> Strathmore-style Service-Learning models with corporate partners, creating employer-recognized credentials.</span></li>
                    </ul>
                </div>
                <div class="partner-value-card">
                    <div class="icon-circle" style="background: rgba(22,101,52,0.1);">
                        <i class="fa-solid fa-handshake-angle" style="color: var(--primary-color);"></i>
                    </div>
                    <h3 style="font-size: 1.2rem; color: var(--primary-color);">For NGOs & Civil Society</h3>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                        <li style="display: flex; gap: 0.75rem; align-items: start; font-size: 0.95rem; color: var(--text-main);"><i class="fa-solid fa-star" style="color: var(--kente-gold); margin-top: 3px; flex-shrink: 0;"></i> <span><strong>Expert Technical Assistance:</strong> Access global specialists for grant writing, legal compliance, M&E frameworks worth KES 50M annually.</span></li>
                        <li style="display: flex; gap: 0.75rem; align-items: start; font-size: 0.95rem; color: var(--text-main);"><i class="fa-solid fa-star" style="color: var(--kente-gold); margin-top: 3px; flex-shrink: 0;"></i> <span><strong>Global Best Practice Network:</strong> Join Peer-Learning platforms with 100+ organizations for scalable impact models and collective advocacy.</span></li>
                    </ul>
                </div>
                <div class="partner-value-card">
                    <div class="icon-circle" style="background: rgba(14,165,233,0.1);">
                        <i class="fa-solid fa-earth-africa" style="color: #0ea5e9;"></i>
                    </div>
                    <h3 style="font-size: 1.2rem; color: #0ea5e9;">For Global Networks</h3>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                        <li style="display: flex; gap: 0.75rem; align-items: start; font-size: 0.95rem; color: var(--text-main);"><i class="fa-solid fa-star" style="color: var(--kente-gold); margin-top: 3px; flex-shrink: 0;"></i> <span><strong>Africa's Collaborative Impact:</strong> Co-develop "High Impact Africa Pro Bono Projects" and feature our Impact Report at global convenings (IAVE, Forum IDS, Good Deeds Day).</span></li>
                        <li style="display: flex; gap: 0.75rem; align-items: start; font-size: 0.95rem; color: var(--text-main);"><i class="fa-solid fa-star" style="color: var(--kente-gold); margin-top: 3px; flex-shrink: 0;"></i> <span><strong>Scalable Models:</strong> Export proven African solutions to Asia, Latin America, and Pacific regions through your networks.</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ SECTION 6: TANGIBLE RETURNS ═══ -->
    <section class="section" style="background: var(--deep-ebony);" id="returns">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-eyebrow" style="color: var(--kente-gold);">Measurable Impact</span>
                <h2 style="color: white;">Tangible Partnership Returns</h2>
                <span class="african-divider-sm center" style="border-color: var(--kente-gold);"></span>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 3.5rem; text-align: center;">
                <div style="padding: 2rem; border: 1px solid rgba(255,255,255,0.1); border-radius: var(--border-radius-lg);">
                    <div style="font-size: 2.5rem; font-weight: 900; color: var(--kente-gold); font-family: var(--font-heading);">KES 80M</div>
                    <p style="color: rgba(255,255,255,0.7); margin-top: 0.5rem; font-size: 0.9rem;">Pro bono value generated post-summit (tracked dashboard)</p>
                </div>
                <div style="padding: 2rem; border: 1px solid rgba(255,255,255,0.1); border-radius: var(--border-radius-lg);">
                    <div style="font-size: 2.5rem; font-weight: 900; color: var(--secondary-color); font-family: var(--font-heading);">400K</div>
                    <p style="color: rgba(255,255,255,0.7); margin-top: 0.5rem; font-size: 0.9rem;">Digital reach across corporate & academic networks</p>
                </div>
                <div style="padding: 2rem; border: 1px solid rgba(255,255,255,0.1); border-radius: var(--border-radius-lg);">
                    <div style="font-size: 2.5rem; font-weight: 900; color: var(--terracotta); font-family: var(--font-heading);">15 MoUs</div>
                    <p style="color: rgba(255,255,255,0.7); margin-top: 0.5rem; font-size: 0.9rem;">Positioning partners as Africa development leaders</p>
                </div>
                <div style="padding: 2rem; border: 1px solid rgba(255,255,255,0.1); border-radius: var(--border-radius-lg);">
                    <div style="font-size: 2.5rem; font-weight: 900; color: #34d399; font-family: var(--font-heading);">10,000 hrs</div>
                    <p style="color: rgba(255,255,255,0.7); margin-top: 0.5rem; font-size: 0.9rem;">Committed pro bono hours via digital pledge dashboard</p>
                </div>
                <div style="padding: 2rem; border: 1px solid rgba(255,255,255,0.1); border-radius: var(--border-radius-lg);">
                    <div style="font-size: 2.5rem; font-weight: 900; color: white; font-family: var(--font-heading);">500+</div>
                    <p style="color: rgba(255,255,255,0.7); margin-top: 0.5rem; font-size: 0.9rem;">Youth & women trained with 25% corporate talent retention gains</p>
                </div>
                <div style="padding: 2rem; border: 1px solid rgba(255,255,255,0.1); border-radius: var(--border-radius-lg);">
                    <div style="font-size: 2.5rem; font-weight: 900; color: var(--kente-gold); font-family: var(--font-heading);">KES 100M</div>
                    <p style="color: rgba(255,255,255,0.7); margin-top: 0.5rem; font-size: 0.9rem;">Projected follow-on funding attracted post-accord</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ SECTION 8: KEYNOTE TOPICS ═══ -->
    <section class="section bg-white" id="keynotes">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-eyebrow">Plenary Sessions</span>
                <h2>Suggested Keynote Topics</h2>
                <span class="african-divider-sm center"></span>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 3rem;">
                <?php
                $keynotes = [
                    ["num" => "01", "color" => "var(--terracotta)", "title" => "Africa's Multidisciplinary Pro Bono Revolution", "desc" => "Unlocking Agenda 2063 Prosperity Through Corporate Pro Bono Practice."],
                    ["num" => "02", "color" => "var(--savannah-sand)", "title" => "Youth and Women as Pro Bono Catalysts", "desc" => "Scaling jobs creation and equity among vulnerable groups."],
                    ["num" => "03", "color" => "var(--primary-color)", "title" => "From Expertise to Impact", "desc" => "Institutionalizing Pro Bono Practice for Africa's SDG Priorities: Climate Resilience, Ending Poverty, and Quality Education."],
                    ["num" => "04", "color" => "#0ea5e9", "title" => "Partnerships for Peace and Prosperity", "desc" => "Exporting Resilience to a Polycrisis World through North-South and South-South collaboration."],
                ];
                foreach ($keynotes as $k) {
                    echo "<div style='padding: 2rem; border-radius: var(--border-radius-lg); border: 1px solid #e2e8f0; background: #f8fafc; display: flex; flex-direction: column; gap: 1rem;'>
                        <div style='font-size: 3rem; font-weight: 900; color: {$k['color']}; opacity: 0.3; font-family: var(--font-heading); line-height: 1;'>{$k['num']}</div>
                        <h3 style='font-size: 1.1rem; color: #0f172a; margin: 0;'>\"{$k['title']}\"</h3>
                        <p style='color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin: 0;'>{$k['desc']}</p>
                    </div>";
                }
                ?>
            </div>
        </div>
    </section>

    <!-- ═══ SECTION 9: WORK PLAN ═══ -->
    <section class="section section-alt" id="workplan">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-eyebrow">Implementation Roadmap</span>
                <h2>Summit Work Plan (May to Dec 2026)</h2>
                <span class="african-divider-sm center"></span>
            </div>
            <div style="overflow-x: auto; margin-top: 3rem;">
                <table style="width: 100%; border-collapse: collapse; background: white; border-radius: var(--border-radius-lg); overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    <thead>
                        <tr style="background: var(--deep-ebony); color: white;">
                            <th style="padding: 1rem 1.5rem; text-align: left; font-family: 'Outfit', sans-serif; font-weight: 600;">Phase</th>
                            <th style="padding: 1rem 1.5rem; text-align: left; font-family: 'Outfit', sans-serif; font-weight: 600;">Key Tasks</th>
                            <th style="padding: 1rem 1.5rem; text-align: left; font-family: 'Outfit', sans-serif; font-weight: 600;">Responsibility</th>
                            <th style="padding: 1rem 1.5rem; text-align: left; font-family: 'Outfit', sans-serif; font-weight: 600;">Timeline</th>
                            <th style="padding: 1rem 1.5rem; text-align: left; font-family: 'Outfit', sans-serif; font-weight: 600;">Success Indicators</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 1rem 1.5rem; font-weight: 700; color: var(--terracotta);">Preparation</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-main);">Committee formation, venue securing, sponsorship campaigns</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted);">Organizers / Corporates</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted);">May to Jul 2026</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted);">Sponsorship partnerships signed</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                            <td style="padding: 1rem 1.5rem; font-weight: 700; color: var(--savannah-sand);">Mobilization</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-main);">Delegate registrations, speaker confirmations, program development</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted);">Committee / Academia / Corporates</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted);">Jun to Oct 2026</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted);">200 registered; 30 speakers confirmed</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 1rem 1.5rem; font-weight: 700; color: var(--primary-color);">Execution</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-main);">4-day event delivery, live field visits, blueprint workshops</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted);">Full Summit Team</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted);">Nov 2026</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted);">90% attendance; 15 partnerships forged</td>
                        </tr>
                        <tr style="background: #f8fafc;">
                            <td style="padding: 1rem 1.5rem; font-weight: 700; color: #0ea5e9;">Follow-Up</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-main);">Nairobi Accord rollout, pledge dashboard tracking, progress reports</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted);">Monitoring Team</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted);">Nov to Dec 2026</td>
                            <td style="padding: 1rem 1.5rem; color: var(--text-muted);">80% pledges activated by Dec 2026</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- ═══ SECTION 11: ORGANIZERS ═══ -->
    <section class="section section-alt" id="organizers">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-eyebrow">Who We Are</span>
                <h2>Organized By</h2>
                <span class="african-divider-sm center"></span>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; margin-top: 3.5rem;">
                <div style="background: white; border-radius: var(--border-radius-lg); border: 1px solid #e2e8f0; overflow: hidden;">
                    <div style="height: 220px; overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; padding: 2rem;">
                        <img src="assets/jitoleelogo.png" alt="Jitolee Good Friends Foundation Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>
                    <div style="padding: 2rem;">
                        <span class="badge" style="background: rgba(22,101,52,0.1); color: var(--primary-color); margin-bottom: 1rem; display: inline-block;">Founding Organization</span>
                        <h3 style="margin-bottom: 0.5rem;">Jitolee Good Friends Foundation</h3>
                        <p style="color: var(--text-main); font-size: 0.95rem; line-height: 1.7;">A Nairobi-based foundation championing volunteerism and pro bono practice as a cornerstone of African development. Founded by Fredrick Sadia, Jitolee ("Self-Reliance" in Swahili) brings together professionals, communities, and institutions committed to building a prosperous, people-driven Africa.</p>
                    </div>
                </div>
                <div style="background: white; border-radius: var(--border-radius-lg); border: 1px solid #e2e8f0; overflow: hidden;">
                    <div style="height: 220px; overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; padding: 2rem;">
                        <img src="assets/globalprobono.png" alt="Global Pro Bono Network Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>
                    <div style="padding: 2rem;">
                        <span class="badge" style="background: rgba(14,165,233,0.1); color: #0ea5e9; margin-bottom: 1rem; display: inline-block;">Co-Organizer</span>
                        <h3 style="margin-bottom: 0.5rem;">Global Pro Bono Network (GPBN)</h3>
                        <p style="color: var(--text-main); font-size: 0.95rem; line-height: 1.7;">The Global Pro Bono Network is an international collaborative connecting pro bono networks, organizations, and practitioners across the world. GPBN amplifies the impact of professional volunteering by sharing models, building partnerships, and advocating for institutionalized pro bono across continents.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ SECTION 12: DOWNLOAD DOCUMENTS ═══ -->
    <section class="section" style="background: linear-gradient(135deg, var(--deep-ebony) 0%, #0f2d1a 100%);" id="documents">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-eyebrow" style="color: var(--kente-gold);">Official Documents</span>
                <h2 style="color: white;">Read the Full Summit Concept</h2>
                <span class="african-divider-sm center" style="border-color: var(--kente-gold);"></span>
                <p class="subtitle mt-1" style="color: rgba(255,255,255,0.7);">All official documents are available for download. Share them with your organization or board.</p>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1.5rem; margin-top: 3rem; max-width: 750px; margin-left: auto; margin-right: auto;">

                <div class="doc-download-card">
                    <div style="display: flex; align-items: center; gap: 1.5rem;">
                        <div style="width: 56px; height: 56px; border-radius: 12px; background: rgba(193,68,14,0.2); border: 1px solid rgba(193,68,14,0.4); display: flex; align-items: center; justify-content: center; font-size: 1.75rem; color: var(--terracotta); flex-shrink: 0;">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <div>
                            <h4 style="color: white; margin: 0 0 0.25rem; font-size: 1.1rem;">Executive Summary</h4>
                            <p style="color: rgba(255,255,255,0.5); font-size: 0.85rem; margin: 0;">2-page overview · Africa Global Summit on Pro Bono Practice</p>
                        </div>
                    </div>
                    <a href="assets/Africa Global Summit on Pro Bono Practice - Executive Summary.pdf" download class="btn btn-secondary" style="flex-shrink: 0; white-space: nowrap;">
                        <i class="fa-solid fa-download" style="margin-right: 0.4rem;"></i> Download PDF
                    </a>
                </div>

                <div class="doc-download-card">
                    <div style="display: flex; align-items: center; gap: 1.5rem;">
                        <div style="width: 56px; height: 56px; border-radius: 12px; background: rgba(22,101,52,0.2); border: 1px solid rgba(22,101,52,0.4); display: flex; align-items: center; justify-content: center; font-size: 1.75rem; color: #34d399; flex-shrink: 0;">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <div>
                            <h4 style="color: white; margin: 0 0 0.25rem; font-size: 1.1rem;">Final Concept Paper</h4>
                            <p style="color: rgba(255,255,255,0.5); font-size: 0.85rem; margin: 0;">7-page full concept · Rationale, Objectives, Thematic Areas & Budget</p>
                        </div>
                    </div>
                    <a href="assets/Africa Global Summit on Pro Bono Practice - Final Concept Paper.pdf" download class="btn btn-secondary" style="flex-shrink: 0; white-space: nowrap;">
                        <i class="fa-solid fa-download" style="margin-right: 0.4rem;"></i> Download PDF
                    </a>
                </div>

                <div class="doc-download-card">
                    <div style="display: flex; align-items: center; gap: 1.5rem;">
                        <div style="width: 56px; height: 56px; border-radius: 12px; background: rgba(212,160,23,0.15); border: 1px solid rgba(212,160,23,0.4); display: flex; align-items: center; justify-content: center; font-size: 1.75rem; color: var(--kente-gold); flex-shrink: 0;">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div>
                            <h4 style="color: white; margin: 0 0 0.25rem; font-size: 1.1rem;">Official Tentative Program</h4>
                            <p style="color: rgba(255,255,255,0.5); font-size: 0.85rem; margin: 0;">4-page program · Day-by-day sessions, speakers & field visits</p>
                        </div>
                    </div>
                    <a href="assets/Africa Global Pro Bono Summit 2026 - Official Tentative Program.pdf" download class="btn btn-secondary" style="flex-shrink: 0; white-space: nowrap;">
                        <i class="fa-solid fa-download" style="margin-right: 0.4rem;"></i> Download PDF
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- ═══ CTA ═══ -->
    <section class="section bg-white text-center">
        <div class="container">
            <span class="section-eyebrow">Join the Movement</span>
            <h2 style="font-size: 2.5rem; max-width: 600px; margin: 1rem auto 1.5rem;">"The Africa We Want" Starts with One Commitment.</h2>
            <p style="color: var(--text-muted); max-width: 550px; margin: 0 auto 2.5rem; font-size: 1.05rem; line-height: 1.7;">Investing in this Summit means investing in the structural transformation of Africa, harnessing professional skills to build a Resilient, Equitable, and Prosperous Continent.</p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="register" class="btn btn-primary btn-lg">Register as Delegate</a>
                <a href="contact" class="btn btn-outline btn-lg" style="border-color: var(--primary-color); color: var(--primary-color);">Become a Partner</a>
            </div>
        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>
