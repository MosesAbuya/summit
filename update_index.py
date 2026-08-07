import re

with open('index.php', 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Update Carousel subtitle for Day 4
content = content.replace(
    "Join us at the Nairobi Safari Club for a night of elegance, celebrating the pioneers of Pan-African volunteerism.",
    "Join us for a night of elegance, celebrating the pioneers of Pan-African volunteerism."
)

# 2. Update venue names to "Venue to be confirmed"
content = content.replace("<h3>UON Main Hall</h3>", "<h3>Venue to be confirmed</h3>")
content = content.replace("<h3>KRA Hall</h3>", "<h3>Venue to be confirmed</h3>")
content = content.replace("<h3>KICC Plenary</h3>", "<h3>Venue to be confirmed</h3>")
content = content.replace("<h3>Nairobi Safari Club</h3>", "<h3>Venue to be confirmed</h3>")

# 3. Update venue descriptions
content = content.replace(
    "Kicking off the summit at the University of Nairobi, bridging the gap between student innovation and corporate pro-bono architectures.",
    "Kicking off the summit, bridging the gap between student innovation and corporate pro-bono architectures."
)
content = content.replace(
    "A deep dive into regulatory frameworks and corporate governance, hosted at the prestigious Kenya Revenue Authority complex.",
    "A deep dive into regulatory frameworks and corporate governance and policy."
)
content = content.replace(
    "The primary institutional gathering at the Kenyatta International Convention Centre, featuring global keynotes and strategy sessions.",
    "The primary institutional gathering featuring global keynotes and strategy sessions."
)

# 4. Replace marquee with GPBN CTA
marquee_pattern = r'<div class="network-marquee".*?</div>\s*</div>'
cta_html = """<div class="gpbn-cta" style="margin-top: 4rem; padding: 4rem 2rem; background: linear-gradient(rgba(15,23,42,0.85), rgba(15,23,42,0.95)), url('https://globalprobono.org/wp-content/uploads/2018/02/Lisbon-2017-recap-cover.jpg') center/cover; border-radius: var(--border-radius-lg); text-align: center; color: white; box-shadow: var(--shadow-lg);">
            <img src="assets/globalprobono.png" alt="Global Pro Bono Network" style="max-height: 90px; margin: 0 auto 1.5rem; filter: brightness(0) invert(1);">
            <h3 style="font-size: 2rem; margin-bottom: 1rem; color: white; font-family: var(--font-heading);">A Proud Member of the Global Pro Bono Network</h3>
            <p style="font-size: 1.15rem; color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto 2.5rem; line-height: 1.6;">Connecting with visionary leaders worldwide to drive sustainable impact and empower communities across continents through professional volunteerism.</p>
            <a href="https://globalprobono.org" target="_blank" class="btn btn-primary btn-lg" style="background: var(--terracotta); border-color: var(--terracotta); color: white;">Explore The Network &rarr;</a>
        </div>"""

content = re.sub(marquee_pattern, cta_html, content, flags=re.DOTALL)

with open('index.php', 'w', encoding='utf-8') as f:
    f.write(content)
print("Updated index.php")
