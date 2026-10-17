import './bootstrap';

// Mobile nav toggle
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('mobile-menu-toggle');
    const menu = document.getElementById('mobile-menu');
    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }

    // Hero banner slider
    const slider = document.getElementById('hero-slider');
    if (slider) {
        const slides = slider.querySelectorAll('[data-slide]');
        const dots = document.querySelectorAll('[data-dot]');
        let index = 0;
        const total = slides.length;

        const show = (i) => {
            slides.forEach((s, si) => s.classList.toggle('opacity-0', si !== i));
            dots.forEach((d, di) => d.classList.toggle('bg-white', di === i));
            dots.forEach((d, di) => d.classList.toggle('bg-white/40', di !== i));
            index = i;
        };

        dots.forEach((dot, i) => dot.addEventListener('click', () => show(i)));

        if (total > 1) {
            setInterval(() => show((index + 1) % total), 5000);
        }
    }

    // Category rail scroll buttons
    document.querySelectorAll('[data-scroll-target]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const target = document.querySelector(btn.dataset.scrollTarget);
            if (!target) return;
            const amount = btn.dataset.scrollDir === 'left' ? -320 : 320;
            target.scrollBy({ left: amount, behavior: 'smooth' });
        });
    });

    // Back to top
    const toTop = document.getElementById('back-to-top');
    if (toTop) {
        window.addEventListener('scroll', () => {
            toTop.classList.toggle('hidden', window.scrollY < 500);
        });
        toTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }
});
