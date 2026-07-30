document.addEventListener('DOMContentLoaded', () => {
    // Correct countdown target: November 24, 2026 at 09:00 EAT
    const endDate = new Date('2026-11-24T09:00:00+03:00').getTime();
    const daysEl = document.getElementById('days');
    const hoursEl = document.getElementById('hours');
    const minutesEl = document.getElementById('minutes');
    const secondsEl = document.getElementById('seconds');

    if (daysEl && hoursEl && minutesEl && secondsEl) {
        const updateCountdown = () => {
            const now = new Date().getTime();
            const distance = endDate - now;

            if (distance < 0) {
                daysEl.innerText = '00';
                hoursEl.innerText = '00';
                minutesEl.innerText = '00';
                secondsEl.innerText = '00';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const formatTime = (time) => time < 10 ? '0' + time : time;
            
            if (daysEl.innerText !== formatTime(days)) daysEl.innerText = formatTime(days);
            if (hoursEl.innerText !== formatTime(hours)) hoursEl.innerText = formatTime(hours);
            if (minutesEl.innerText !== formatTime(minutes)) minutesEl.innerText = formatTime(minutes);
            if (secondsEl.innerText !== formatTime(seconds)) secondsEl.innerText = formatTime(seconds);
        };

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if(targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if(targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Speaker Gallery Interaction (Split Screen Tab Spotlight)
    function makeAvatar(initials, bgColor) {
        const size = 400;
        const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="${size}" height="${size}" viewBox="0 0 ${size} ${size}">
            <rect width="${size}" height="${size}" fill="${bgColor}"/>
            <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle"
                font-family="Outfit, Georgia, sans-serif" font-size="140" font-weight="700"
                fill="rgba(255,255,255,0.92)">${initials}</text>
        </svg>`;
        return 'data:image/svg+xml;base64,' + btoa(svg);
    }

    const speakerBtns = document.querySelectorAll('.speaker-btn');
    const sdImg = document.getElementById('sd-img');
    const sdName = document.getElementById('sd-name');
    const sdTrack = document.getElementById('sd-track');
    const sdBio = document.getElementById('sd-bio');
    const sdVideoBtn = document.getElementById('sd-video-btn');
    const sdDisplay = document.querySelector('.speaker-display');

    if (speakerBtns.length > 0) {
        speakerBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                speakerBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const name = btn.getAttribute('data-name');
                const track = btn.getAttribute('data-track');
                const bio = btn.getAttribute('data-bio');
                let image = btn.getAttribute('data-image');
                const video = btn.getAttribute('data-video');
                
                if (!image) {
                    if (name === 'Fredrick Sadia') {
                        image = 'assets/fredsadia.png';
                    } else {
                        const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                        const colors = ['#c1440e', '#166534', '#1e3a5f', '#d97706', '#4f46e5'];
                        const bgColor = colors[name.length % colors.length];
                        image = makeAvatar(initials, bgColor);
                    }
                }
                
                // Fade out transition
                sdDisplay.style.opacity = '0';
                
                setTimeout(() => {
                    sdImg.src = image;
                    sdImg.alt = name;
                    sdName.innerText = name;
                    sdTrack.innerText = track;
                    sdBio.innerText = bio;
                    if (sdVideoBtn) {
                        sdVideoBtn.style.display = video ? 'flex' : 'none';
                    }
                    
                    // Fade in transition
                    sdDisplay.style.opacity = '1';
                }, 300);
            });
        });
    }
    /* ─────────────────────────────────────────────
       Scroll-reveal: fade-in elements as they enter
       viewport. Add class 'reveal-on-scroll' to any
       element you want animated on scroll.
    ───────────────────────────────────────────── */
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                // Unobserve after reveal so it stays visible
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.reveal-on-scroll').forEach(el => {
        revealObserver.observe(el);
    });

    /* Auto-apply reveal to value cards, obj cards, track cards */
    document.querySelectorAll('.value-card, .obj-card, .track-card, .resource-card-mini').forEach((el, i) => {
        el.classList.add('reveal-on-scroll');
        el.style.transitionDelay = `${i * 0.08}s`;
        revealObserver.observe(el);
    });
});
