<?php include 'includes/header.php'; ?>

<style>
    .faq-container { max-width: 800px; margin: 0 auto; }
    .faq-item { background: white; border: 1px solid #e2e8f0; border-radius: var(--border-radius-md); margin-bottom: 1rem; overflow: hidden; }
    .faq-question { padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; cursor: pointer; background: #f8fafc; font-weight: 600; color: var(--text-main); font-family: var(--font-heading); font-size: 1.1rem; }
    .faq-question:hover { background: #f1f5f9; }
    .faq-question.active { border-bottom: 1px solid #e2e8f0; color: var(--primary-color); }
    .faq-answer { padding: 1.5rem; display: none; color: var(--text-muted); line-height: 1.7; }
    .faq-icon { transition: transform 0.3s; color: var(--terracotta); }
    .active .faq-icon { transform: rotate(180deg); }
</style>

<div class="page-header" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('assets/past-summit/231201-153912.jpg') center/cover; padding: 6rem 0; text-align: center; color: white;">
    <div class="container">
        <h1 style="color: white; font-size: 3rem; margin-bottom: 0.5rem;">Frequently Asked Questions</h1>
        <p class="lead-text" style="color: rgba(255,255,255,0.8);">Everything you need to know about the Global Summit on Pro Bono Practice.</p>
    </div>
</div>

<main>
    <section class="section bg-white">
        <div class="container faq-container">
            
            <div class="faq-item">
                <div class="faq-question">
                    1. What is the Global Pro Bono Summit Africa?
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-answer">
                    The Global Summit on Pro Bono Practice is a high-level convening designed to regenerate and transform the landscape of professional pro bono service and volunteerism. By embedding healthcare, technology, education, climate, and finance into the ecosystem, it aims to deliver tangible ROI through enhanced corporate ESG profiles, skilled talent development, and community resilience gains.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    2. When and where is the Summit taking place?
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-answer">
                    The Summit is scheduled for <strong>November 24th to 27th, 2026</strong> and will be held in <strong>Nairobi, Kenya</strong>. It features four days of immersive experiences, workshops, and high-level panels across iconic venues.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    3. Who should attend the Summit?
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-answer">
                    The Summit is designed for corporate executives, ESG directors, academic leaders, NGOs, civil society organizations, government representatives, and professional volunteers dedicated to leveraging their expertise for social impact across Africa.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    4. What are the core themes of the 2026 Summit?
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-answer">
                    Our 2026 theme is "Leveraging Multidisciplinary Pro Bono for SDGs and Agenda 2063." The programming focuses on four primary tracks: SDG 1 (No Poverty), SDG 4 (Quality Education), SDG 8 (Decent Work), and SDG 13 (Climate Action).
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    5. How can my organization sponsor or partner with the Summit?
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-answer">
                    We offer multiple partnership tiers including Platinum (Naming Rights), Gold/Silver (Lead Workshops), and Bronze (Registration Desks). Partnering with us offers strategic ESG positioning, brand visibility, and an opportunity to shape Africa's development agenda. You can request the sponsorship deck via our <a href="contact" style="color: var(--primary-color);">Contact Page</a>.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    6. Will there be opportunities for post-Summit tourism or safaris?
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-answer">
                    Yes! Day 4 includes an ecological immersive experience with an early morning game ride at the Nairobi National Park. Additionally, we coordinate bespoke safari extensions to destinations like the Maasai Mara for delegates who wish to extend their stay. Visit our <a href="logistics" style="color: var(--primary-color);">Logistics Page</a> for more details.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    7. What is the Nairobi Pro Bono Accord/Declaration?
                    <span class="faq-icon"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="faq-answer">
                    The Nairobi Pro Bono Accord is a landmark declaration that will be ratified at the close of the Summit. It serves as a blueprint for institutionalizing professional service to bridge the development gap in Africa, committing signatories to pledge significant pro bono hours post-summit.
                </div>
            </div>

        </div>
        
        <div class="text-center" style="margin-top: 3rem;">
            <p style="color: var(--text-muted);">Still have questions?</p>
            <a href="contact" class="btn btn-outline" style="border-color: var(--primary-color); color: var(--primary-color); margin-top: 0.5rem;">Contact Support Team</a>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const questions = document.querySelectorAll('.faq-question');
        questions.forEach(q => {
            q.addEventListener('click', () => {
                const isActive = q.classList.contains('active');
                
                // Close all
                document.querySelectorAll('.faq-question').forEach(el => el.classList.remove('active'));
                document.querySelectorAll('.faq-answer').forEach(el => el.style.display = 'none');
                
                if (!isActive) {
                    q.classList.add('active');
                    q.nextElementSibling.style.display = 'block';
                }
            });
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
