<?php
require('config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = htmlspecialchars($_POST['name']);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $password = htmlspecialchars($_POST['password']);

  if (empty($name) || empty($email) || empty($password)) {
    $error = "يرجى ملء جميع الحقول.";
  } elseif (!preg_match("/^[\p{L} ]{3,50}$/u", $name)) {
    $error = "الاسم يجب أن يحتوي على حروف فقط ويكون بين 3 و50 حرفًا.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "البريد الإلكتروني غير صالح.";
  }
  elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password)) {
    $error = "كلمة المرور يجب أن تكون 8 أحرف على الأقل، وتحتوي على حرف كبير وصغير ورقم ورمز.";
     }   else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
      $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
      $stmt->execute([$email]);
      if ($stmt->fetch()) {
        $error = "البريد الإلكتروني مستخدم بالفعل.";
      } else {
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password]);
        $success = "تم التسجيل بنجاح! <a href='login.php' class='text-green-600 hover:underline'>تسجيل الدخول</a>";
      }
    } catch (PDOException $e) {
      $error = "خطأ أثناء التسجيل: " . $e->getMessage();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل جديد - EcoTrail</title>
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

    /* Register Section */
    .register-section {
      padding: 4rem 1rem;
      margin-top: 5rem;
    }

    .register-section h2 {
      font-size: 1.875rem;
      font-weight: bold;
      color: #065f46;
      text-align: center;
      margin-bottom: 3rem;
    }

    .register-form {
      max-width: 28rem;
      margin: 0 auto;
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

    .input-field {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid #d1d5db;
      border-radius: 0.25rem;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .input-field:focus {
      border-color: #10b981;
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
      outline: none;
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

    .login-link {
      text-align: center;
      margin-top: 1rem;
    }

    .login-link a {
      color: #16a34a;
      text-decoration: none;
      transition: text-decoration 0.3s ease;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    .error-message {
      color: #dc2626;
      text-align: center;
      margin-bottom: 1rem;
    }

    .success-message {
      color: #16a34a;
      text-align: center;
      margin-bottom: 1rem;
    }

    .success-message a {
      color: #16a34a;
      text-decoration: none;
    }

    .success-message a:hover {
      text-decoration: underline;
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
      .register-section h2 {
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

      .mobile-menu {
        display: none;
      }
    }

    @media (min-width: 1024px) {
      .register-section {
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

  <section class="register-section">
    <h2 data-aos="fade-up">تسجيل جديد</h2>
    <div class="register-form" data-aos="fade-up" data-aos-delay="100">
      <?php if (isset($error)): ?>
        <p class="error-message"><?php echo $error; ?></p>
      <?php elseif (isset($success)): ?>
        <p class="success-message"><?php echo $success; ?></p>
      <?php endif; ?>
      <form method="POST" action="">
        <div class="form-group" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
          <label for="name">الاسم</label>
          <input type="text" id="name" name="name" required class="input-field">
        </div>
        <div class="form-group" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
          <label for="email">البريد الإلكتروني</label>
          <input type="email" id="email" name="email" required class="input-field">
        </div>
        <div class="form-group" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
          <label for="password">كلمة المرور</label>
          <input type="password" id="password" name="password" required class="input-field">
        </div>
        <button type="submit" class="submit-btn" data-aos="fade-up" data-aos-duration="800"
          data-aos-delay="500">تسجيل</button>
        <p class="login-link" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">لديك حساب؟ <a
            href="login.html">تسجيل الدخول</a></p>
      </form>
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