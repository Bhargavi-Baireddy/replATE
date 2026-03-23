// FoodShare Enhanced UI Interactions

// Smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
});

// Navbar scroll effect
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        if (window.scrollY > 100) {
            navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            navbar.style.backdropFilter = 'blur(20px)';
            navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
        } else {
            navbar.style.background = 'rgba(255, 255, 255, 0.15)';
            navbar.style.backdropFilter = 'blur(10px)';
            navbar.style.boxShadow = 'none';
        }
    }
});

// Form enhancements
document.querySelectorAll('input, textarea, select').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.02)';
        this.parentElement.style.transition = 'transform 0.2s ease';
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
    });
});

// Food card animations
document.querySelectorAll('.food-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-10px) rotateX(5deg)';
    });
    
    card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0) rotateX(0)';
    });
});

// Notification dropdown
document.querySelector('.notification-bell')?.addEventListener('click', function(e) {
    e.stopPropagation();
    const dropdown = this.nextElementSibling;
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
});

// Close dropdown when clicking outside
document.addEventListener('click', () => {
    document.querySelectorAll('.notification-dropdown').forEach(dropdown => {
        dropdown.style.display = 'none';
    });
});

// Countdown timers
function initCountdowns() {
    document.querySelectorAll('.countdown').forEach(timer => {
        const endTime = new Date(timer.dataset.end).getTime();
        const updateTimer = () => {
            const now = new Date().getTime();
            const distance = endTime - now;
            
            if (distance < 0) {
                timer.innerHTML = '<span class="text-red-500 font-bold">EXPIRED</span>';
                return;
            }
            
            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            timer.innerHTML = `${hours}h ${minutes}m ${seconds}s`;
        };
        updateTimer();
        setInterval(updateTimer, 1000);
    });
}

// Lazy load images
function initLazyLoad() {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Mobile menu toggle
document.querySelector('.mobile-menu-btn')?.addEventListener('click', () => {
    document.querySelector('.mobile-menu').classList.toggle('open');
});

// Parallax effect
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    document.querySelectorAll('.parallax').forEach(element => {
        element.style.transform = `translateY(${scrolled * 0.5}px)`;
    });
});

// Initialize when DOM loaded
document.addEventListener('DOMContentLoaded', () => {
    initCountdowns();
    initLazyLoad();
    
    // Fade in animation for elements
    document.querySelectorAll('.fade-in').forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
        el.classList.add('animate-fadeIn');
    });
});

// Service Worker for PWA (optional)
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/foodshare/assets/sw.js')
        .then(reg => console.log('SW registered'))
        .catch(err => console.log('SW registration failed'));
}

