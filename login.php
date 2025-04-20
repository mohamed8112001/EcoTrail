<?php
session_start();
require 'config.php';
$user = null; // Initialize $user to avoid undefined variable error
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    if (empty($email) || empty($password)) {
        $error = "يرجى ملء جميع الحقول.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "البريد الإلكتروني غير صالح.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                
                header("Location: index.php");
                exit;
            } else {
                $error = "البريد الإلكتروني أو كلمة المرور غير صحيحة.";
            }
        } catch (PDOException $e) {
            $error = "خطأ أثناء تسجيل الدخول: " . $e->getMessage();
        }
    }
}
var_dump($user);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل الدخول - EcoTrail</title>
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

    /* Login Section */
    .login-section {
      padding: 4rem 1rem;
      margin-top: 5rem;
    }

    .login-section h2 {
      font-size: 1.875rem;
      font-weight: bold;
      color: #065f46;
      text-align: center;
      margin-bottom: 3rem;
    }

    .login-form {
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

    .password-container {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      left: 0.625rem;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
    }

    .toggle-password svg {
      width: 20px;
      height: 20px;
      color: #6b7280;
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

    .error-message, .success-message {
      text-align: center;
      margin-bottom: 1rem;
      transition: opacity 0.3s ease;
      opacity: 1;
    }

    .error-message {
      color: #dc2626;
    }

    .success-message {
      color: #16a34a;
    }

    .register-link {
      text-align: center;
      margin-top: 1rem;
    }

    .register-link a {
      color: #16a34a;
      text-decoration: none;
      transition: text-decoration 0.3s ease;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

    /* Responsive Design */
    @media (min-width: 640px) {
      .login-section h2 {
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
    }

    @media (min-width: 1024px) {
      .login-section {
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


  <!-- Login Section -->
  <section class="login-section">
    <h2 data-aos="zoom-in" data-aos-duration="800">تسجيل الدخول</h2>
    <div class="login-form" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
      <?php if (isset($error)): ?>
        <p class="error-message" data-aos="fade-in" data-aos-duration="500"><?php echo htmlspecialchars($error); ?></p>
      <?php endif; ?>
      <form method="POST" action="">
        <div class="form-group" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
          <label for="email">البريد الإلكتروني</label>
          <input type="email" id="email" name="email" required class="input-field" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
        </div>
        <div class="form-group password-container" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
          <label for="password">كلمة المرور</label>
          <input type="password" id="password" name="password" required class="input-field">
          <span class="toggle-password" onclick="togglePassword()">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
          </span>
        </div>
        <button type="submit" class="submit-btn" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">تسجيل الدخول</button>
        <p class="register-link" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">ليس لديك حساب؟ <a href="register.php">سجل الآن</a></p>
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

    // Password Visibility Toggle
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.querySelector('.toggle-password svg');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
        `;
      } else {
        passwordInput.type = 'password';
        toggleIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        `;
      }
    }
  </script>
</body>
</html>