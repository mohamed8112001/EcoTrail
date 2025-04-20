<?php
session_start();
require 'config.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($page_title) ? $page_title : 'EcoTrail'; ?></title>
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <link rel="stylesheet" href="src/style.css">
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
                    <li><span class="user-name">زائر</span>
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
                        <span class="user-name">
                          <?php 
                          if(isset($_SESSION['user_name'])) {
                            echo htmlspecialchars($_SESSION['user_name']); 
                          } else {
                            echo "زائر";
                          }
                          ?></span>
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
                    <p class="price">250 ريال / 3 أيام</p>
                    <a href="contact.php">احجز الآن</a>
                </div>
            </div>
            <div class="package-card animate-card">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e" alt="جبال">
                <div class="package-card-content">
                    <h3>مغامرة الجبال</h3>
                    <p>تسلق الجبال واستمتع بإطلالات خلابة.</p>
                    <p class="price">350 ريال / 5 أيام</p>
                    <a href="contact.php">احجز الآن</a>
                </div>
            </div>
            <div class="package-card animate-card">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e" alt="شاطئ">
                <div class="package-card-content">
                    <h3>رحلة الشواطئ البكر</h3>
                    <p>استرخِ على الشواطئ النقية واستمتع بالمياه الصافية.</p>
                    <p class="price">200 ريال / 2 يوم</p>
                    <a href="contact.php">احجز الآن</a>
                </div>
            </div>
            <div class="package-card animate-card">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e" alt="شاطئ">
                <div class="package-card-content">
                    <h3>رحلة الشواطئ البكر</h3>
                    <p>استرخِ على الشواطئ النقية واستمتع بالمياه الصافية.</p>
                    <p class="price">200 ريال / 2 يوم</p>
                    <a href="contact.php">احجز الآن</a>
                </div>
            </div>
            <div class="package-card animate-card">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e" alt="شاطئ">
                <div class="package-card-content">
                    <h3>رحلة الشواطئ البكر</h3>
                    <p>استرخِ على الشواطئ النقية واستمتع بالمياه الصافية.</p>
                    <p class="price">200 ريال / 2 يوم</p>
                    <a href="contact.php">احجز الآن</a>
                </div>
            </div>
            <div class="package-card animate-card">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e" alt="شاطئ">
                <div class="package-card-content">
                    <h3>رحلة الشواطئ البكر</h3>
                    <p>استرخِ على الشواطئ النقية واستمتع بالمياه الصافية.</p>
                    <p class="price">200 ريال / 2 يوم</p>
                    <a href="contact.php">احجز الآن</a>
                </div>
            </div>
        </div>
    </section>
<?php
// Include the footer
include 'layout/footer.php';
?>