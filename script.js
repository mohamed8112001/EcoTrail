AOS.init({
  duration: 1000,
  once: true,
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    document.querySelector(this.getAttribute('href')).scrollIntoView({
      behavior: 'smooth'
    });
  });
});
// Hamburger Menu Toggle with Animation
const menuToggle = document.getElementById('menu-toggle');
const mobileMenu = document.getElementById('mobile-menu');
const closeMenu = document.getElementById('closeMenu');
const menuIcon = document.getElementById('menu-icon');

menuToggle.addEventListener('click', () => {
  mobileMenu.classList.toggle('hidden');
  mobileMenu.classList.toggle('active');
  // Rotate hamburger icon to X
  menuIcon.classList.toggle('rotate-90');
});

closeMenu.addEventListener('click', () => {
  mobileMenu.classList.add('hidden');
  mobileMenu.classList.remove('active');
  menuIcon.classList.remove('rotate-90');
});

// Close menu when clicking a link
mobileMenu.querySelectorAll('a').forEach(link => {
  link.addEventListener('click', () => {
    mobileMenu.classList.add('hidden');
    mobileMenu.classList.remove('active');
    menuIcon.classList.remove('rotate-90');
  });
});

// Close mobile menu when clicking outside
document.addEventListener('click', (event) => {
  if (!mobileMenu.contains(event.target) && !menuToggle.contains(event.target) && !mobileMenu.classList.contains('hidden')) {
    mobileMenu.classList.add('hidden');
    mobileMenu.classList.remove('active');
    menuIcon.classList.remove('rotate-90');
  }
});