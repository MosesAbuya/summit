document.addEventListener('DOMContentLoaded', () => {
    // Basic Countdown functionality
    const endDate = new Date('2026-10-15T09:00:00').getTime(); // Example future date
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
    const speakerData = [
        {
            name: "Fredrick Sadia",
            role: "Founder, Jitolee Foundation",
            track: "Keynote & Panel: Strengthening Civil Society",
            bio: "Fredrick is a visionary leader in social impact and a board member of the Global Pro Bono Network. He has dedicated over a decade to building frameworks that empower communities through structured volunteerism across Africa.",
            image: "https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=800&auto=format&fit=crop"
        },
        {
            name: "Dr. Amina Mohamed",
            role: "Policy Director, Africa NGO Council",
            track: "Track 1: Legal & Corporate Pro-bono",
            bio: "Dr. Amina leads international policy formulation regarding cross-border NGO cooperation. She is instrumental in aligning corporate social investment with public sector goals and developing intergovernmental synergy.",
            image: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&auto=format&fit=crop"
        },
        {
            name: "David Okello",
            role: "Head of Corporate ESG",
            track: "Track 2: Tech for Good",
            bio: "An expert in integrating pro-bono initiatives into standard corporate practice, David has pioneered several multi-national programs across East Africa, focusing intensely on engineering solutions for social good.",
            image: "https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=800&auto=format&fit=crop"
        },
        {
            name: "Sarah Jenkins",
            role: "Global Volunteer Coordinator",
            track: "Track 3: Strengthening Civil Society",
            bio: "Sarah brings 15 years of experience in managing large-scale, international volunteer deployments and developing rigorous training modules for pro-bono consultants deployed across sub-Saharan Africa.",
            image: "https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=800&auto=format&fit=crop"
        }
    ];

    const speakerBtns = document.querySelectorAll('.speaker-btn');
    const sdImg = document.getElementById('sd-img');
    const sdName = document.getElementById('sd-name');
    const sdTrack = document.getElementById('sd-track');
    const sdBio = document.getElementById('sd-bio');
    const sdDisplay = document.querySelector('.speaker-display');

    if (speakerBtns.length > 0) {
        speakerBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                speakerBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const index = btn.getAttribute('data-index');
                const data = speakerData[index];
                
                // Fade out transition
                sdDisplay.style.opacity = '0';
                
                setTimeout(() => {
                    sdImg.src = data.image;
                    sdName.innerText = data.name;
                    sdTrack.innerText = data.track;
                    sdBio.innerText = data.bio;
                    
                    // Fade in transition
                    sdDisplay.style.opacity = '1';
                }, 300);
            });
        });
    }
});
