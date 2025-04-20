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
          $stmt = $conn->prepare("SELECT id, full_name, email, password FROM users WHERE email = ?");
          $stmt->bind_param("s", $email); // "s" for string
          $stmt->execute();
          $result = $stmt->get_result();
          $user = $result->fetch_assoc();
            echo $user['password'];echo '<br>';
            echo $password;echo '<br>';
            echo $user['email'];echo '<br>';
            echo $email;echo '<br>';
            if ($email == $user['email'] && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['profile_picture'] = 'uploads/profile-user.png'; // Add profile picture if needed
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate CSRF token
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
// var_dump($user);
$page_title = "من نحن";
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> تسجيل الدخول</title>
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <link rel="stylesheet" href="src/style.css">
</head>
<body>
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
<?php 
// Include footer
include 'layout/footer.php';
?>