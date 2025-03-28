function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

//feedback
let currentSlide = 0;

function changeSlide(direction) {
    const slides = document.querySelectorAll('.testimonial');
    const totalSlides = slides.length;

    // Update the current slide index
    currentSlide = (currentSlide + direction + totalSlides) % totalSlides;

    // Move the slides
    slides.forEach((slide, index) => {
        slide.style.transform = `translateX(-${currentSlide * 100}%)`;
    });
}

setInterval(() => {
    changeSlide(1);
}, 5000);

function scrollToTimetable() {
    const timetableSection = document.getElementById('timetable');
    timetableSection.scrollIntoView({ behavior: 'smooth' });
}

//slider
let currentCustomSlide = 0;

function showCustomSlides() {
    const slides = document.querySelectorAll('.custom-slide');
    const totalSlides = slides.length;

    // Hide all slides
    slides.forEach((slide) => {
        slide.classList.remove('active');
    });

    // Show the current slide
    slides[currentCustomSlide].classList.add('active');

    // Update the current slide index
    currentCustomSlide = (currentCustomSlide + 1) % totalSlides;

    // Change slide every 3 seconds
    setTimeout(showCustomSlides, 3000); // Change to 3000 milliseconds (3 seconds)
}

showCustomSlides();