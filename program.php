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
                            <div class="accordion-day">Day 1 • November 24, 2026</div>
                            <h3 class="accordion-title">Vision Setting & Thematic Alignments</h3>
                            <div class="accordion-venue"><i class="fa-solid fa-location-dot"></i> UON Main Hall</div>
                        </div>
                        <svg class="accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="accordion-content">
                        <p style="margin-bottom: 2.5rem; color: var(--text-main); font-size: 1.05rem; line-height: 1.6;">The Summit kicks off at the historic University of Nairobi. This day focuses on bridging student innovation with established corporate pro-bono architectures, building the pipeline of future impact leaders.</p>
                        <ul class="timeline-list">
                            <li class="timeline-item">
                                <span class="time-badge">01:00 PM - 02:00 PM</span>
                                <h4 style="font-size: 1.25rem;">Delegate Registration & Welcoming of Guests</h4>
                                <div class="timeline-speaker">Arrival and Accreditation</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">02:00 PM - 02:40 PM</span>
                                <h4 style="font-size: 1.25rem;">Official Opening Ceremony & Leadership Speeches</h4>
                                <div class="timeline-speaker">Welcome by organizers & Opening Address by High-level Kenya Government representative</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">02:40 PM - 03:00 PM</span>
                                <h4 style="font-size: 1.25rem;">Keynote Session Phase I</h4>
                                <div class="timeline-speaker">Thematic Areas 1 & 2: SDGs 1 & 4</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">03:00 PM - 03:45 PM</span>
                                <h4 style="font-size: 1.25rem;">High-Level Panel Discussion</h4>
                                <div class="timeline-speaker">Operationalizing professional service to address poverty and education gaps</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">03:45 PM - 04:10 PM</span>
                                <h4 style="font-size: 1.25rem;">Networking Coffee & Tea Break</h4>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">04:10 PM - 04:30 PM</span>
                                <h4 style="font-size: 1.25rem;">Keynote Session Phase II</h4>
                                <div class="timeline-speaker">Thematic Areas 3 & 4: SDGs 8 & 13</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">04:30 PM - 05:15 PM</span>
                                <h4 style="font-size: 1.25rem;">High-Level Panel Discussion</h4>
                                <div class="timeline-speaker">Connecting technical expertise with local innovations</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">06:30 PM - 09:30 PM</span>
                                <h4 style="font-size: 1.25rem;">Official Welcoming & Opening Dinner</h4>
                                <div class="timeline-speaker">East African cultural entertainment showcase</div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Day 2 -->
                <div class="accordion-item" id="day2">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <div>
                            <div class="accordion-day">Day 2 • November 25, 2026</div>
                            <h3 class="accordion-title">Deep Dives & Institutional Practice (SDGs 1 & 4)</h3>
                            <div class="accordion-venue"><i class="fa-solid fa-location-dot"></i> KRA Hall & Experiential Sites</div>
                        </div>
                        <svg class="accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="accordion-content">
                        <p style="margin-bottom: 2.5rem; color: var(--text-main); font-size: 1.05rem; line-height: 1.6;">A deep dive into regulatory frameworks and direct engagement on poverty reduction and quality education.</p>
                        <ul class="timeline-list">
                            <li class="timeline-item">
                                <span class="time-badge">08:00 AM - 09:30 AM</span>
                                <h4 style="font-size: 1.25rem;">Deep Dive Session 1: Eradicating Extreme Poverty</h4>
                                <div class="timeline-speaker">Microfinance, property rights, women/youth enterprise funding</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">09:30 AM - 10:00 AM</span>
                                <h4 style="font-size: 1.25rem;">Mid-Morning Tea & Refreshments Break</h4>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">10:00 AM - 11:30 AM</span>
                                <h4 style="font-size: 1.25rem;">Deep Dive Session 2: Transforming Quality Education</h4>
                                <div class="timeline-speaker">Digital learning platforms, university tutoring</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">11:30 AM - 01:00 PM</span>
                                <h4 style="font-size: 1.25rem;">Parallel Break-Out Sessions: Co-Creating Blueprints</h4>
                                <div class="timeline-speaker">Track A: Food Security | Track B: Youth Tech Mentorship | Track C: Governance & Accountability</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">01:00 PM - 02:00 PM</span>
                                <h4 style="font-size: 1.25rem;">Luncheon</h4>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">02:00 PM - 05:30 PM</span>
                                <h4 style="font-size: 1.25rem;">Experiential Field Visits: Pro Bono in True Practice</h4>
                                <div class="timeline-speaker">VIP Shuttles to Option 1: Safaricom HQ/Digital Hub OR Option 2: Strathmore Univ. Community Clinics</div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Day 3 -->
                <div class="accordion-item" id="day3">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <div>
                            <div class="accordion-day">Day 3 • November 26, 2026</div>
                            <h3 class="accordion-title">Deep Dives & Institutional Practice (SDGs 8 & 13)</h3>
                            <div class="accordion-venue"><i class="fa-solid fa-location-dot"></i> KICC Plenary & Experiential Sites</div>
                        </div>
                        <svg class="accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="accordion-content">
                        <p style="margin-bottom: 2.5rem; color: var(--text-main); font-size: 1.05rem; line-height: 1.6;">Focusing on decent work, economic growth, and climate action. Featuring high-level global networking.</p>
                        <ul class="timeline-list">
                            <li class="timeline-item">
                                <span class="time-badge">08:00 AM - 09:30 AM</span>
                                <h4 style="font-size: 1.25rem;">Deep Dive Session 3: Decent Work & Economic Growth</h4>
                                <div class="timeline-speaker">Corporate volunteering with SMEs, tech/finance mentoring</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">09:30 AM - 10:00 AM</span>
                                <h4 style="font-size: 1.25rem;">Mid-Morning Tea & Refreshments Break</h4>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">10:00 AM - 11:30 AM</span>
                                <h4 style="font-size: 1.25rem;">Deep Dive Session 4: Climate Action & Adaptation</h4>
                                <div class="timeline-speaker">Engineers & agronomists for drought resistance; UNEA-7 alignment</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">11:30 AM - 01:00 PM</span>
                                <h4 style="font-size: 1.25rem;">Parallel Break-Out Sessions: Co-Creating Blueprints</h4>
                                <div class="timeline-speaker">Track A: Capacity Frameworks for Job Creation | Track B: Community Adaptation | Track C: Gender Inclusion</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">01:00 PM - 02:00 PM</span>
                                <h4 style="font-size: 1.25rem;">Luncheon</h4>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">02:00 PM - 05:30 PM</span>
                                <h4 style="font-size: 1.25rem;">Experiential Field Visits: Pro Bono in True Practice</h4>
                                <div class="timeline-speaker">VIP Shuttles to Option 1: UNEP Regional Offices / NEMA OR Option 2: Kenya Red Cross Innovation Hub</div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Day 4 -->
                <div class="accordion-item" id="day4">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <div>
                            <div class="accordion-day">Day 4 • November 27, 2026</div>
                            <h3 class="accordion-title">Ecological Stewardship & Accord Ratification</h3>
                            <div class="accordion-venue"><i class="fa-solid fa-location-dot"></i> Nairobi Safari Club / National Park</div>
                        </div>
                        <svg class="accordion-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="accordion-content">
                        <p style="margin-bottom: 2.5rem; color: var(--text-main); font-size: 1.05rem; line-height: 1.6;">The Summit concludes with an elegant evening of celebration and reflection. We honor the outstanding corporations, foundations, and individuals driving impactful pro-bono projects across the continent.</p>
                        <ul class="timeline-list">
                            <li class="timeline-item">
                                <span class="time-badge">06:00 AM - 12:00 PM</span>
                                <h4 style="font-size: 1.25rem;">Ecological Immersive Experience: Nairobi National Park</h4>
                                <div class="timeline-speaker">Early morning Game Ride & Corporate-sponsored Tree Planting Ceremony</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">12:00 PM - 03:00 PM</span>
                                <h4 style="font-size: 1.25rem;">Mid-Day Intermission & Free Time</h4>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">03:00 PM - 04:30 PM</span>
                                <h4 style="font-size: 1.25rem;">Closing Plenary & Accord Ratification Ceremony</h4>
                                <div class="timeline-speaker">Signing of the "Nairobi Pro Bono Accord/Declaration"</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">04:30 PM - 06:00 PM</span>
                                <h4 style="font-size: 1.25rem;">The Africa Pro Bono Awards Ceremony</h4>
                                <div class="timeline-speaker">Celebrating cross-sector partnerships, corporate ESG, and grassroots CSOs</div>
                            </li>
                            <li class="timeline-item">
                                <span class="time-badge">06:00 PM - Late</span>
                                <h4 style="font-size: 1.25rem;">Grand Gala Closing Dinner & Celebration</h4>
                                <div class="timeline-speaker">Live performance by a premier African band</div>
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
