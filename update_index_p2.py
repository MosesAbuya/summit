import re

with open('index.php', 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Update hero slide
content = content.replace('src="assets/hero_slide_1.png"', 'src="assets/hero_slide_1_new.jpg"')

# 2. Add CTA about the first time in Africa
cta_html = """</section>

<!-- First Time in Africa CTA -->
<section class="section" style="background: var(--bg-alt); padding: 4rem 0;">
    <div class="container" style="text-align: center; max-width: 800px;">
        <span class="badge" style="background: rgba(193, 68, 14, 0.1); color: var(--terracotta); margin-bottom: 1rem; display: inline-block;">A Historic Milestone</span>
        <h2 style="font-size: 2.5rem; color: #0f172a; margin-bottom: 1.5rem; font-family: var(--font-heading);">Coming to Africa for the First Time</h2>
        <p style="font-size: 1.15rem; line-height: 1.8; color: var(--text-main); margin-bottom: 2rem;">
            The Global Pro Bono Summit has been a catalyst for change worldwide convening leaders in New York, San Francisco, Berlin, Singapore, Lisbon, and Mumbai. Now, this global movement arrives in Nairobi, marking a historic first for the African continent.
        </p>
        <a href="resources#historical-reports" class="btn btn-outline">Explore Past Global Summits</a>
    </div>
</section>

<!-- 3. The Theme Section -->"""

content = content.replace("</section>\n\n<!-- 3. The Theme Section -->", cta_html)

# 3. Update GPBN CTA background
content = content.replace(
    "url('https://globalprobono.org/wp-content/uploads/2018/02/Lisbon-2017-recap-cover.jpg')",
    "url('assets/gpbn_cta_bg.jpg')"
)

with open('index.php', 'w', encoding='utf-8') as f:
    f.write(content)
print("Updated index.php")
