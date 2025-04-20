<?php include 'layout/header.php' ?>
<!-- Contact Section -->
  <section class="contact-section">
    <h2 data-aos="zoom-in" data-aos-duration="800">تواصل معنا</h2>
    <div class="contact-container">
      <!-- Contact Form -->
      <div class="contact-form" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
        <?php
        require 'config.php'; // Ensure database connection is included

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $name = htmlspecialchars($_POST['name']);
          $email = htmlspecialchars($_POST['email']);
          $message = htmlspecialchars($_POST['message']);
          $created_at = date('Y-m-d H:i:s'); // Use a proper date format

          // Ensure $conn is a valid mysqli object
          if ($conn instanceof mysqli) {
            // Insert the message into the database
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message, created_at) VALUES (?, ?, ?, ?)");
            if ($stmt) {
              $stmt->bind_param("ssss", $name, $email, $message, $created_at);

              if ($stmt->execute()) {
                echo "<p class='success-message'>تم إرسال رسالتك بنجاح، شكرًا $name!</p>";
              } else {
                echo "<p class='error-message'>حدث خطأ أثناء إرسال الرسالة. حاول مرة أخرى لاحقًا.</p>";
              }

              $stmt->close();
            } else {
              echo "<p class='error-message'>حدث خطأ في إعداد الاستعلام.</p>";
            }
          } else {
            echo "<p class='error-message'>خطأ في الاتصال بقاعدة البيانات.</p>";
          }
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
            <a href="tel:+1234567890">+966 51 443 1197</a>
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
<?php
// Include the footer
include 'layout/footer.php';
?>