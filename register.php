<?php
require 'config.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $prodi = $conn->real_escape_string($_POST['prodi']);
    $nim = $conn->real_escape_string($_POST['nim']);
    $role = 'user';

    $passwordPattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

    // Check if the password meets the criteria
    if (!preg_match($passwordPattern, $password)) {
        $error_message = "Password must contain at least 8 characters, including letters and numbers.";
    } else {
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

        // Check if username or email already exists
        $checkQuery = "SELECT * FROM user WHERE username='$username' OR email='$email'";
        $result = $conn->query($checkQuery);

        if ($result->num_rows > 0) {
            $error_message = "Username or Email already registered";
        } else {
            $sql = "INSERT INTO user (username, password, nama, email, prodi, nim, role) VALUES ('$username', '$passwordHashed', '$nama', '$email', '$prodi', '$nim', '$role')";

            if ($conn->query($sql) === TRUE) {
                $success_message = "Registration successful. Redirecting to login...";
            } else {
                $error_message = "Error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scitech Camp</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-seo-dream.css">
    <link rel="stylesheet" href="assets/css/animated.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <style>
        .main-button, .google-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 5px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .main-button {
            background-color: #3498db;
            color: white;
            border: none;
        }
        .main-button:hover {
            background-color: #2980b9;
        }
        .google-button {
            background-color: #e74c3c;
            color: white;
            border: none;
        }
        .google-button:hover {
            background-color: #c0392b;
        }
        .modal-header {
            background-color: #8e44ad;
            color: white;
        }
        .modal-footer .btn-primary {
            background-color: #2ecc71;
            border-color: #27ae60;
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav class="main-nav">
                <a href="index.php" class="logo">
                  <h4>SciTech Camp<img src="assets/images/logo-icon.png" alt=""></h4>
                </a>
                <ul class="nav">
                  <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                  <li class="scroll-to-section"><a href="#features">E-Learning</a></li>
                  <li class="scroll-to-section"><a href="#about">Bootcamp & Program</a></li>
                  <li class="scroll-to-section"><a href="#services">Course</a></li>
                  <li class="scroll-to-section"><a href="#portfolio">Career Kit</a></li>
                  <li class="scroll-to-section"><a href="#contact">About</a></li> 
                  <li class="scroll-to-section"><div class="main-blue-button"><a href="login.php">Log In</a></div></li> 
                </ul>        
                <a class='menu-trigger'>
                    <span>Menu</span>
                </a>
              </nav>
            </div>
          </div>
        </div>
      </header>

      <div id="contact" class="contact-us section">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
              <form id="contact" action="register.php" method="post">
                <div class="row">
                  <div class="col-lg-6 offset-lg-3">
                    <div class="section-heading">
                      <h6>Get Your Experience Camp</h6>
                      <h2>Register</h2>
                    </div>
                  </div>

                  <div class="col-lg-9">
                    <div class="row">
                      <div class="col-lg-6">
                        <fieldset>
                          <input type="text" name="username" id="username" placeholder="Username" required>
                        </fieldset>
                      </div>
                      <div class="col-lg-6">
                        <fieldset>
                          <input type="text" name="nama" id="nama" placeholder="Name" required>
                        </fieldset>
                      </div>
                      <div class="col-lg-6">
                        <fieldset>
                          <input type="text" name="nim" id="nim" placeholder="NIM" required>
                        </fieldset>
                      </div>
                      <div class="col-lg-6">
                        <fieldset>
                          <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Email">
                        </fieldset>
                      </div>
                      <div class="col-lg-6">
                        <fieldset>
                          <input type="text" name="prodi" id="prodi" placeholder="Program Studi">
                        </fieldset>
                      </div>
                      <div class="col-lg-6">
                        <fieldset>
                          <input type="password" name="password" id="password" placeholder="Password" required>
                          <?php if (!empty($error_message)): ?>
                              <p class="error-message"><?php echo $error_message; ?></p>
                          <?php endif; ?>
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          <button type="submit" name="register" id="form-submit" class="main-button">Register</button>
                        </fieldset>
                      </div>
                      <?php if (!empty($success_message)): ?>
                        <script>
                          $(document).ready(function() {
                              alert('<?php echo $success_message; ?>');
                              window.location.href = 'login.php';
                          });
                        </script>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="contact-info">
                      <ul>
                        <li>
                          <div class="icon">
                            <img src="assets/images/contact-icon-01.png" alt="email icon">
                          </div>
                          <a href="#">SchiTech@gmail.com</a>
                        </li>
                        <li>
                          <div class="icon">
                            <img src="assets/images/contact-icon-02.png" alt="phone">
                          </div>
                          <a href="#">+001-002-0034</a>
                        </li>
                        <li>
                          <div class="icon">
                            <img src="assets/images/contact-icon-03.png" alt="location">
                          </div>
                          <a href="#">Universitas Muhammadiyah Sukabumi</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/animation.js"></script>
    <script src="assets/js/imagesloaded.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
