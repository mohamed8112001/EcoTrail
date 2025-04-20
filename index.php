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
    <title>EcoTrail - مغامرات الطبيعة</title>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            background-color: #f0fff4;
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
            align-items: center;
        }

        .desktop-menu li {
            display: inline-block;
            margin-left: 1.5rem;
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

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-name {
            font-size: 1rem;
            font-weight: 600;
            color: #bbf7d0;
        }

        .logout-btn {
            background-color: #dc2626;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .logout-btn:hover {
            background-color: #b91c1c;
            transform: translateY(-2px);
        }

        .hamburger {
            display: block;
            background: none;
            border: none;
            cursor: pointer;
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

        .mobile-menu a, .mobile-menu .logout-btn {
            color: white;
            text-decoration: none;
            font-size: 1.125rem;
            transition: color 0.3s ease;
        }

        .mobile-menu a:hover, .mobile-menu .logout-btn:hover {
            color: #bbf7d0;
        }

        .mobile-menu .logout-btn {
            background: none;
            padding: 0;
            font-size: 1.125rem;
            border: none;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            background: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e') no-repeat center/cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 1rem;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .hero-content {
            position: relative;
            max-width: 800px;
        }

        .hero h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
        }

        .hero a {
            display: inline-block;
            background-color: #16a34a;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 1.125rem;
            transition: background-color 0.3s ease;
        }

        .hero a:hover {
            background-color: #15803d;
        }

        /* Packages Section */
        .packages {
            padding: 4rem 1rem;
            background-color: #f0fff4;
            text-align: center;
        }

        .packages h2 {
            font-size: 2.25rem;
            font-weight: bold;
            color: #065f46;
            margin-bottom: 2rem;
        }

        .packages-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .package-card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .package-card:hover {
            transform: translateY(-5px);
        }

        .package-card img {
            width: 100%;
            height: 12rem;
            object-fit: cover;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .package-card-content {
            padding: 1.5rem;
        }

        .package-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .package-card p {
            color: #4b5563;
            margin-bottom: 1rem;
        }

        .package-card .price {
            color: #16a34a;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .package-card a {
            display: block;
            background-color: #16a34a;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .package-card a:hover {
            background-color: #15803d;
        }

        /* Footer */
        footer {
            background-color: #064e3b;
            color: white;
            padding: 2rem 1rem;
            text-align: center;
        }

        /* Responsive Design */
        @media (min-width: 640px) {
            .packages-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.25rem;
            }
        }

        @media (min-width: 768px) {
            .desktop-menu {
                display: flex;
            }

            .hamburger {
                display: none;
            }

            .packages-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .hero h1 {
                font-size: 3rem;
            }
        }

        @media (min-width: 1024px) {
            .hero h1 {
                font-size: 3.5rem;
            }

            .hero p {
                font-size: 1.5rem;
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="animate-hero">استكشف الطبيعة مع EcoTrail</h1>
            <p>انضم إلى مغامراتنا البيئية واستمتع بجمال الطبيعة</p>
            <a href="#packages">اكتشف باقاتنا</a>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="packages">
        <h2>باقات الرحلات</h2>
        <div class="packages-grid">
            <div class="package-card animate-card">
                <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e" alt="غابة">
                <div class="package-card-content">
                    <h3>رحلة الغابات الخضراء</h3>
                    <p>استمتع بالتنزه في الغابات الكثيفة واكتشف الحياة البرية.</p>
                    <p class="price">250 دولار / 3 أيام</p>
                    <a href="contact.php">احجز الآن</a>
                </div>
            </div>
            <div class="package-card animate-card">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e" alt="جبال">
                <div class="package-card-content">
                    <h3>مغامرة الجبال</h3>
                    <p>تسلق الجبال واستمتع بإطلالات خلابة.</p>
                    <p class="price">350 دولار / 5 أيام</p>
                    <a href="contact.php">احجز الآن</a>
                </div>
            </div>
            <div class="package-card animate-card">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e" alt="شاطئ">
                <div class="package-card-content">
                    <h3>رحلة الشواطئ البكر</h3>
                    <p>استرخِ على الشواطئ النقية واستمتع بالمياه الصافية.</p>
                    <p class="price">200 دولار / 2 يوم</p>
                    <a href="contact.php">احجز الآن</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>© 2025 EcoTrail. جميع الحقوق محفوظة.</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-in-out',
        });

        // GSAP Animations
        gsap.from(".animate-hero", { opacity: 0, y: 50, duration: 1, delay: 0.5 });
        gsap.from(".animate-card", { 
            opacity: 0, 
            y: 50, 
            duration: 1, 
            stagger: 0.3, 
            scrollTrigger: { trigger: "#packages" } 
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