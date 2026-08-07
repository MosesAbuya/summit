import re

with open('program.php', 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Update venues
content = re.sub(
    r'<div class="accordion-venue"><i class="fa-solid fa-location-dot"></i>[^<]+</div>',
    '<div class="accordion-venue"><i class="fa-solid fa-location-dot"></i> Venue to be confirmed</div>',
    content
)

# 2. Replace timeline-list contents with "To be determined"
def replace_timeline(match):
    # match.group(0) is the entire <ul class="timeline-list">...</ul>
    return """<div style="padding: 2rem; background: var(--bg-alt); border-radius: var(--border-radius-md); text-align: center; border: 1px dashed #cbd5e1; margin-top: 1rem;">
                            <i class="fa-solid fa-calendar-days" style="font-size: 2rem; color: var(--text-muted); margin-bottom: 1rem; display: block;"></i>
                            <p style="color: var(--text-main); font-size: 1.1rem; font-weight: 500;">Program details, time slots, and speakers are to be determined.</p>
                            <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.5rem;">Check back soon for the full itinerary updates.</p>
                        </div>"""

content = re.sub(r'<ul class="timeline-list">.*?</ul>', replace_timeline, content, flags=re.DOTALL)

with open('program.php', 'w', encoding='utf-8') as f:
    f.write(content)
print("Updated program.php")
