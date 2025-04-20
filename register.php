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
  elseif (!preg_match("/[a-zA-Z]/", $password) || !preg_match("/[\W_]/", $password) || strlen($password) < 8) {
    $error = "كلمة المرور يجب أن تكون 8 أحرف على الأقل، وتحتوي على حرف وحرف خاص.";
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
  header("Location: login.php");
}
$page_title = "تسجيل جديد";
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
                        <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
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
            href="login.php">تسجيل الدخول</a></p>
      </form>
    </div>
  </section>
<?php
// Include the footer
include 'layout/footer.php';
?>