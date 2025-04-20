<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header("Location: login.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تواصل معنا - EcoTrail</title>
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: sans-serif;
    }

    body {
      background-color: #f3f4f6;
    }

    /* Navigation */
    nav {
      background-color: #047857;
      color: white;
      padding: 1rem;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 50;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: bold;
      text-decoration: none;
      color: white;
    }

    .desktop-menu {
      display: none;
      list-style: none;
    }

    .desktop-menu li {
      display: inline-block;
      margin-left: 2rem;
    }

    .desktop-menu a {
      color: white;
      text-decoration: none;
      padding: 0.5rem;
      position: relative;
      transition: color 0.3s ease;
    }

    .desktop-menu a:hover {
      color: #bbf7d0;
    }

    .desktop-menu a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 2px;
      background-color: #bbf7d0;
      transition: width 0.3s ease;
    }

    .desktop-menu a:hover::after {
      width: 100%;
    }

    .hamburger {
      display: block;
      background: none;
      border: none;
      cursor: pointer;
      border-radius: 0.25rem;
    }

    .hamburger:focus {
      outline: none;
      box-shadow: 0 0 0 2px #6ee7b7;
    }

    .hamburger svg {
      width: 24px;
      height: 24px;
      transition: transform 0.3s ease;
    }

    .mobile-menu {
      position: fixed;
      top: 0;
      right: 0;
      height: 100%;
      width: 16rem;
      background-color: #047857;
      color: white;
      padding: 1.5rem;
      z-index: 50;
      box-shadow: -2px 0 4px rgba(0, 0, 0, 0.2);
      transform: translateX(100%);
      transition: transform 0.3s ease-in-out;
    }

    .mobile-menu.active {
      transform: translateX(0);
    }

    .mobile-menu.hidden {
      transform: translateX(100%);
    }

    .close-menu {
      background: none;
      border: none;
      cursor: pointer;
      margin-bottom: 1.5rem;
      border-radius: 0.25rem;
    }

    .close-menu:focus {
      outline: none;
      box-shadow: 0 0 0 2px #6ee7b7;
    }

    .close-menu svg {
      width: 24px;
      height: 24px;
    }

    .mobile-menu ul {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .mobile-menu a {
      color: white;
      text-decoration: none;
      font-size: 1.125rem;
      transition: color 0.3s ease;
    }

    .mobile-menu a:hover {
      color: #bbf7d0;
    }

    /* Contact Section */
    .contact-section {
      padding: 4rem 1rem;
      margin-top: 5rem;
    }

    .contact-section h2 {
      font-size: 1.875rem;
      font-weight: bold;
      color: #065f46;
      text-align: center;
      margin-bottom: 3rem;
    }

    .contact-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 2rem;
    }

    .contact-form {
      background-color: white;
      padding: 2rem;
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-group label {
      display: block;
      color: #374151;
      font-weight: 600;
      margin-bottom: 0.25rem;
    }

    .input-field, .textarea-field {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid #d1d5db;
      border-radius: 0.25rem;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .input-field:focus, .textarea-field:focus {
      border-color: #10b981;
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
      outline: none;
    }

    .textarea-field {
      height: 8rem;
      resize: vertical;
    }

    .submit-btn {
      display: block;
      width: 100%;
      background-color: #16a34a;
      color: white;
      padding: 0.5rem;
      border: none;
      border-radius: 0.25rem;
      font-size: 1rem;
      cursor: pointer;
      transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .submit-btn:hover {
      background-color: #15803d;
      transform: translateY(-2px);
    }

    .success-message {
      color: #16a34a;
      text-align: center;
      margin-bottom: 1rem;
    }

    .contact-info {
      background-color: #f0fff4;
      padding: 2rem;
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .contact-info h3 {
      font-size: 1.5rem;
      font-weight: bold;
      color: #047857;
      margin-bottom: 1.5rem;
    }

    .contact-info .info-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .contact-info p {
      display: flex;
      align-items: center;
      color: #4b5563;
    }

    .contact-info svg {
      width: 24px;
      height: 24px;
      margin-right: 0.5rem;
      color: #16a34a;
    }

    .contact-info a {
      color: #4b5563;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .contact-info a:hover {
      color: #16a34a;
    }

    .map {
      margin-top: 1.5rem;
    }

    .map iframe {
      width: 100%;
      height: 250px;
      border: 0;
    }

    /* Footer */
    footer {
      background-color: #047857;
      color: white;
      padding: 2rem 1rem;
      text-align: center;
    }

    /* Responsive Design */
    @media (min-width: 640px) {
      .contact-section h2 {
        font-size: 2.25rem;
      }
    }

    @media (min-width: 768px) {
      .desktop-menu {
        display: flex;
      }

      .hamburger {
        display: none;
      }

      .contact-container {
        flex-direction: row;
      }

      .contact-form, .contact-info {
        width: 50%;
      }
    }

    @media (min-width: 1024px) {
      .contact-section {
        padding: 4rem 2rem;
      }
    }
  </style>
</head>
<body>
  <!-- Navigation -->
  <nav>
        <div class="container">
            <a href="index.php" class="logo" data-aos="fade-right" data-aos-duration="600">EcoTrail</a>
            <button id="menu-toggle" class="hamburger" aria-label="Toggle menu">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <ul class="desktop-menu" data-aos="fade-left" data-aos-duration="600">
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="about.php">من نحن</a></li>
                <li><a href="contact.php">تواصل معنا</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="user-info">
                        <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <button class="logout-btn" onclick="window.location.href='logout.php'">تسجيل الخروج</button>
                    </li>
                <?php else: ?>
                    <li><a href="login.php">تسجيل الدخول</a></li>
                    <li><a href="register.php">تسجيل جديد</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div id="mobile-menu" class="mobile-menu hidden">
            <button id="close-menu" class="close-menu" aria-label="Close menu">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <ul>
                <li data-aos="fade-left" data-aos-duration="500" data-aos-delay="100"><a href="index.php">الرئيسية</a></li>
                <li data-aos="fade-left" data-aos-duration="500" data-aos-delay="200"><a href="about.php">من نحن</a></li>
                <li data-aos="fade-left" data-aos-duration="500" data-aos-delay="300"><a href="contact.php">تواصل معنا</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li data-aos="fade-left" data-aos-duration="500" data-aos-delay="400">
                        <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    </li>
                    <li data-aos="fade-left" data-aos-duration="500" data-aos-delay="500">
                        <button class="logout-btn" onclick="window.location.href='logout.php'">تسجيل الخروج</button>
                    </li>
                <?php else: ?>
                    <li data-aos="fade-left" data-aos-duration="500" data-aos-delay="400"><a href="login.php">تسجيل الدخول</a></li>
                    <li data-aos="fade-left" data-aos-duration="500" data-aos-delay="500"><a href="register.php">تسجيل جديد</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>


  <!-- Contact Section -->
  <section class="contact-section">
    <h2 data-aos="zoom-in" data-aos-duration="800">تواصل معنا</h2>
    <div class="contact-container">
      <!-- Contact Form -->
      <div class="contact-form" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $name = htmlspecialchars($_POST['name']);
          $email = htmlspecialchars($_POST['email']);
          $message = htmlspecialchars($_POST['message']);
          
          // Placeholder for email sending or data storage logic
          echo "<p class='success-message'>تم إرسال رسالتك بنجاح، شكرًا $name!</p>";
        }
        ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-group" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <label for="name">الاسم</label>
            <input type="text" id="name" name="name" required class="input-field">
          </div>
          <div class="form-group" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" required class="input-field">
          </div>
          <div class="form-group" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
            <label for="message">الرسالة</label>
            <textarea id="message" name="message" required class="textarea-field"></textarea>
          </div>
          <button type="submit" class="submit-btn" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">إرسال</button>
        </form>
      </div>
      <!-- Contact Information -->
      <div class="contact-info" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
        <h3 data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">معلومات التواصل</h3>
        <div class="info-list">
          <p data-aos="fade-left" data-aos-duration="1000" data-aos-delay="400">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <a href="mailto:info@ecotrail.com">info@ecotrail.com</a>
          </p>
          <p data-aos="fade-left" data-aos-duration="1000" data-aos-delay="500">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
            <a href="tel:+1234567890">+123 456 7890</a>
          </p>
          <p data-aos="fade-left" data-aos-duration="1000" data-aos-delay="600">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span>123 شارع البيئة، المدينة الخضراء</span>
          </p>
        </div>
        <div class="map" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="700">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.9537353153167!3d-37.81627927975195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf0727e4b3b3b3b3!2s123%20Green%20St%2C%20Melbourne%20VIC%203000%2C%20Australia!5e0!3m2!1sen!2sus!4v1634567890123" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer data-aos="fade-up" data-aos-duration="800">
    <p>© 2025 EcoTrail. جميع الحقوق محفوظة.</p>
  </footer>

  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    // Initialize AOS
    AOS.init({
      duration: 800,
      once: true,
      easing: 'ease-in-out',
    });

    // Hamburger Menu Toggle
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeMenu = document.getElementById('close-menu');

    menuToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
      mobileMenu.classList.toggle('active');
    });

    closeMenu.addEventListener('click', () => {
      mobileMenu.classList.add('hidden');
      mobileMenu.classList.remove('active');
    });

    // Close menu when clicking a link
    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
        mobileMenu.classList.remove('active');
      });
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (event) => {
      if (!mobileMenu.contains(event.target) && !menuToggle.contains(event.target) && !mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('hidden');
        mobileMenu.classList.remove('active');
      }
    });
  </script>
</body>
</html>