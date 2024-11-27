const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.getElementById('nav-menu');
    const overlay = document.createElement('div');
    overlay.id = 'overlay';
    document.body.appendChild(overlay);

    menuToggle.addEventListener('click', function() {
        const isActive = navMenu.classList.toggle('active');
        menuToggle.classList.toggle('active');
        overlay.classList.toggle('show');
        menuToggle.setAttribute('aria-expanded', isActive);
    });

    overlay.addEventListener('click', function() {
        navMenu.classList.remove('active');
        menuToggle.classList.remove('active');
        overlay.classList.remove('show');
        menuToggle.setAttribute('aria-expanded', 'false');
    });



// JavaScript to control the carousel
const carousel = document.querySelector('.carousel');
const carouselInner = document.querySelector('.carousel-inner');
const items = document.querySelectorAll('.carousel-item');
const controls = document.querySelectorAll('.carousel-control');
const indicators = document.querySelectorAll('.carousel-indicators span');

let currentIndex = 0;

function showSlide(index) {
    carouselInner.style.transform = `translateX(-${index * 100}%)`;

    items.forEach((item, i) => {
        item.classList.remove('active');
        indicators[i].classList.remove('active');
    });

    items[index].classList.add('active');
    indicators[index].classList.add('active');
}

controls.forEach((control) => {
    control.addEventListener('click', () => {
        if (control.classList.contains('next')) {
            currentIndex = (currentIndex + 1) % items.length;
        } else {
            currentIndex = (currentIndex - 1 + items.length) % items.length;
        }
        showSlide(currentIndex);
    });
});

indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
        currentIndex = index;
        showSlide(currentIndex);
    });
});

// Automatic slide transition
setInterval(() => {
    currentIndex = (currentIndex + 1) % items.length;
    showSlide(currentIndex);
}, 5000); // Change slide every 5 seconds









