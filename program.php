<?php include 'includes/header.php'; ?>

<style>
    .program-accordion { border: 1px solid #e2e8f0; border-radius: var(--border-radius-lg); overflow: hidden; box-shadow: var(--box-shadow); background: white; margin-top: 3rem; }
    .accordion-item { border-bottom: 1px solid #e2e8f0; }
    .accordion-item:last-child { border-bottom: none; }
    .accordion-header { background: #f8fafc; padding: 1.5rem 2.5rem; display: flex; justify-content: space-between; align-items: center; cursor: pointer; transition: background 0.3s; }
    .accordion-header:hover { background: #f1f5f9; }
    .accordion-day { font-weight: 700; color: var(--secondary-color); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }
    .accordion-title { font-size: 1.6rem; color: #0f172a; font-weight: 700; margin: 0.35rem 0 0; }
    .accordion-venue { display: inline-flex; align-items: center; gap: 0.5rem; background: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.85rem; border: 1px solid #e2e8f0; margin-top: 0.8rem; color: var(--text-muted); font-weight: 600; }
    .accordion-icon { transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); width: 28px; height: 28px; color: var(--primary-color); }
    
    .accordion-content { padding: 0 2.5rem; max-height: 0; overflow: hidden; transition: max-height 0.5s ease-out, padding 0.5s ease-out; background: white; }
    .accordion-item.active .accordion-content { padding: 2.5rem; max-height: 1200px; }
    .accordion-item.active .accordion-icon { transform: rotate(180deg); }
    .accordion-item.active .accordion-header { border-bottom: 1px solid #e2e8f0; }
    
    .timeline-list { list-style: none; padding: 0; margin: 0; position: relative; border-left: 2px solid #e2e8f0; margin-left: 1rem; }
    .timeline-item { position: relative; padding-left: 2.5rem; margin-bottom: 2.5rem; }
    .timeline-item:hover::before { transform: scale(1.2); box-shadow: 0 0 0 4px rgba(22, 101, 52, 0.2); }
    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-item::before { content: ''; position: absolute; left: -8px; top: 4px; width: 14px; height: 14px; border-radius: 50%; background: var(--primary-color); border: 2px solid white; box-shadow: 0 0 0 2px var(--primary-color); transition: all 0.3s; }
    .time-badge { font-weight: 700; color: #fff; background: var(--primary-color); font-size: 0.85rem; padding: 0.3rem 0.8rem; border-radius: 6px; display: inline-block; margin-bottom: 0.8rem; letter-spacing: 0.5px; }
    
    .timeline-speaker { font-size: 0.95rem; color: var(--text-muted); margin-top: 0.5rem; }

    @media (max-width: 600px) {
        .accordion-header { flex-direction: column; align-items: flex-start; padding: 1.5rem; gap: 0.75rem; }
        .accordion-icon { align-self: flex-end; }
        .accordion-content { padding: 0 1.5rem; }
        .accordion-item.active .accordion-content { padding: 1.5rem; }
        .timeline-item { padding-left: 1.5rem; }
    }
</style>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('assets/hero-bg.png') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">Summit Program & Itinerary</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">Four Days. Four Landmarks. One Pan-African Vision.</p>
    </div>
</div>

<main>
    <section class="section bg-white">
        <div class="container" style="max-width: 950px; margin: 0 auto;">
            
            <p style="text-align: center; font-size: 1.1rem; color: var(--text-main); margin-bottom: 2rem;">Explore the completely interactive schedule. Click on any day to expand its full itinerary, sessions, and keynote speaker details.</p>

                        <div class="program-accordion">
                <!-- Day 1 -->
                <div class="accordion-item active" id="day1">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <div>
                            <div class="accordion-day">DAY ONE: 24th Nov 2026</div>
                            <h3 class="accordion-title">Vision Setting & Thematic Alignments</h3>
                            <div class="accordion-venue">Africa's Strategic Framework for the International Year of Volunteers (IVY 2026)</div>
                        </div>
                        <svg class="accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="accordion-content">
                        <ul class="timeline-list" style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
                            <li class="timeline-item">
                                <span class="time-badge">1:00 PM - 2:00 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Delegate Registration & Welcoming</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Arrival, security clearing, badge distribution, and IVY 2026 introductory toolkits.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">2:00 PM - 2:40 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Official Opening & Speeches</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Welcome: Global Pro Bono Network & Jitolee Good Friends. Opening Address by Dignitaries.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">2:40 PM - 3:00 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Keynotes: SDGs 1 & 4</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">[SDG 1] Poverty Eradication via Financial & Legal Advisory. [SDG 4] Tech Mentorship for Out-of-School Youth.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">3:00 PM - 3:45 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">High-Level Panel: SDGs 1 & 4</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Cross-sector alignment of corporate and academic volunteer structures (4 Leaders + Q&A).</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">3:45 PM - 4:10 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Networking Tea Break</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Informal networking across delegates and international partners.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">4:10 PM - 4:30 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Keynotes: SDGs 8 & 13</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">[SDG 8] Pro Bono for SME Growth & Employability. [SDG 13] Climate Volunteering & Nature-Based Solutions.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">4:30 PM - 5:15 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">High-Level Panel: SDGs 8 & 13</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Connecting technical expertise with local innovations for youth job growth and climate resilience (+ Q&A).</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">6:30 PM - 9:30 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Welcoming & Opening Dinner</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Hosted by Organizers & Partners. Cultural East African showcase and North-South partnership networking.</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Day 2 -->
                <div class="accordion-item" id="day2">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <div>
                            <div class="accordion-day">DAY TWO: 25th Nov 2026</div>
                            <h3 class="accordion-title">Deep Dives, Breakouts & Institutional Practice (SDGs 1 & 4)</h3>
                            <div class="accordion-venue">Translating Global Volunteer Momentum into Practical African Action</div>
                        </div>
                        <svg class="accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="accordion-content">
                        <ul class="timeline-list" style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
                            <li class="timeline-item">
                                <span class="time-badge">8:00 AM - 9:30 AM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Deep Dive 1: SDG 1 (Extreme Poverty)</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Deploying microfinance, legal property clinics, and funding pipelines for women/youth enterprises.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">9:30 AM - 10:00 AM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Mid-Morning Tea Break</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Workgroup networking in the exhibition hall.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">10:00 AM - 11:30 AM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Deep Dive 2: SDG 4 (Quality Education)</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Scaling digital learning platforms and university tutoring to boost enrollment in pilot zones.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">11:30 AM - 1:00 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Parallel Break-Out Blueprints</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Track A: Food Security Advisory | Track B: Youth Tech Mentorship | Track C: Governance & Policy Frameworks.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">1:00 PM - 2:00 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Luncheon</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Networking lunch prior to site visits.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">2:00 PM - 5:30 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Experiential Field Visits</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Option 1 (Corporate): Employee Volunteering.<br>Option 2 (Academia): Community Clinics & Service Learning.</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Day 3 -->
                <div class="accordion-item" id="day3">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <div>
                            <div class="accordion-day">DAY THREE: 26th Nov 2026</div>
                            <h3 class="accordion-title">Deep Dives, Breakouts & Institutional Practice (SDGs 8 & 13)</h3>
                            <div class="accordion-venue">Building Institutional Resilience and Strategic Cross-Sector Synergy</div>
                        </div>
                        <svg class="accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="accordion-content">
                        <ul class="timeline-list" style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
                            <li class="timeline-item">
                                <span class="time-badge">8:00 AM - 9:30 AM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Deep Dive 3: SDG 8 (Decent Work)</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Corporate SME mentorship, finance/tech training, and employer-recognized certifications.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">9:30 AM - 10:00 AM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Mid-Morning Tea Break</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Reviewing blueprint progress on digital tracking dashboard.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">10:00 AM - 11:30 AM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Deep Dive 4: SDG 13 (Climate Action)</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Deploying expert agronomists/engineers for drought resilience and UNEA-7 nature-based solutions.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">11:30 AM - 1:00 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Parallel Break-Out Blueprints</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Track A: Tech & Agri Capacity | Track B: Community Adaptation | Track C: Gender & Social Inclusion.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">1:00 PM - 2:00 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Luncheon</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Networking lunch prior to site visits.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">2:00 PM - 5:30 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Experiential Field Visits</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Option 1 (Government/UN Agency): Policy Alignments.<br>Option 2 (Development Partner): Community/Humanitarian Volunteering.</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Day 4 -->
                <div class="accordion-item" id="day4">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <div>
                            <div class="accordion-day">DAY FOUR: 27th Nov 2026</div>
                            <h3 class="accordion-title">Ecological Stewardship, Accord Ratification & Gala Celebration</h3>
                            <div class="accordion-venue">Locking Continental Commitments and Carrying IVY 2026 Legacy Forward</div>
                        </div>
                        <svg class="accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="accordion-content">
                        <ul class="timeline-list" style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
                            <li class="timeline-item">
                                <span class="time-badge">6:00 AM - 12:00 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Ecological Immersive Experience</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Game drive at Nairobi National Park followed by Corporate Tree Planting Ceremony (SDG 13).</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">12:00 PM - 3:00 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Mid-Day Intermission</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Free time to prepare for formal evening closing plenary.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">3:00 PM - 4:30 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Closing Plenary & Ratification</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Signing of the 'Nairobi Pro Bono Accord/Declaration' by Government, Corporate, Academic, and Development Partner leaders.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">4:30 PM - 6:00 PM</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Africa Pro Bono Awards Ceremony</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Recognizing outstanding ESG leadership, academic service-learning, and grassroots CSOs.</p>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">6:00 PM - Late</span>
                                <h4 style="font-size: 1.15rem; color: #0f172a; margin-bottom: 0.25rem;">Grand Gala Closing Dinner</h4>
                                <p style="color: var(--text-main); line-height: 1.5; margin: 0;">Formal dinner, live African band performance, cultural dance troupes, and toolkit distribution.</p>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </section>
</main>

<script>
    // Accordion Logic
    function toggleAccordion(header) {
        // Toggle the clicked item
        const item = header.parentElement;
        item.classList.toggle('active');
        
        // Optional: Close others (Disabled for better user itinerary browsing)
        // const allItems = document.querySelectorAll('.accordion-item');
        // allItems.forEach(i => {
        //     if(i !== item) i.classList.remove('active');
        // });
    }

    // Auto-open accordion based on URL hash
    window.addEventListener('DOMContentLoaded', () => {
        if(window.location.hash) {
            const targetId = window.location.hash.substring(1);
            const targetItem = document.getElementById(targetId);
            if(targetItem) {
                // close all first
                document.querySelectorAll('.accordion-item').forEach(i => i.classList.remove('active'));
                // open target
                targetItem.classList.add('active');
                
                // smooth scroll to it
                setTimeout(() => {
                    targetItem.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 300);
            }
        }
    });
</script>

<?php include 'includes/footer.php'; ?>
