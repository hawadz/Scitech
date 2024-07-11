<?php
// require_once 'vendor/autoload.php';
// session_start();
// require 'functions.php';

// // Konfigurasi Google Client
// $client = new Google_Client();
// $client->setClientId('159984912932-katp4f5lgtep46jkkid9jed9vs4n9onq.apps.googleusercontent.com');
// $client->setClientSecret('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');
// $client->setRedirectUri('http://localhost/hawa/callback.php');
// $client->addScope("email");
// $client->addScope("profile");

// $authUrl = $client->createAuthUrl();

// Redirect jika sudah login
require 'config.php';

if (isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
              header('Location: index.php');
            } else {
              header('Location: index.php');
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scitech Camp</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
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
            background-color: #4CAF50; /* Green */
            color: white;
            border: none;
        }
        .main-button:hover {
            background-color: #45a049;
        }
        .google-button {
            background-color: #db4437; /* Google Red */
            color: white;
            border: none;
        }
        .google-button:hover {
            background-color: #c23321;
        }
    </style>
</head>
<body>
    <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav class="main-nav">
                <!-- ***** Logo Start ***** -->
                <a href="index.php" class="logo">
                  <h4>SciTech Camp<img src="assets/images/logo-icon.png" alt=""></h4>
                </a>
                <!-- ***** Logo End ***** -->
                <!-- ***** Menu Start ***** -->
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
                <!-- ***** Menu End ***** -->
              </nav>
            </div>
          </div>
        </div>
      </header>

      <div id="contact" class="contact-us section">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
              <form id="contact" action="" method="post">
                <div class="row">
                  <div class="col-lg-6 offset-lg-3">
                    <div class="section-heading">
                      <h6>Get Your Experience Camp</h6>
                      <h2>Login Now</h2>
                    </div>
                  </div>

                  <?php if (isset($error)) : ?>
                    <p style="color: red; font-style: italic;">username / password salah</p>
                  <?php endif; ?>
                   
                  <div class="col-lg-9">
                    <div class="row">
                      <div class="col-lg-6">
                        <fieldset>
                          <input type="text" name="username" id="username" placeholder="Username" required>
                        </fieldset>
                      </div>
                      <div class="col-lg-6">
                        <fieldset>
                          <input type="password" name="password" id="password" placeholder="Password" required>
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          <button type="submit" name="login" id="form-submit" class="main-button">Login</button>
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          <button class="google-button"><a href="<?php echo htmlspecialchars($authUrl); ?>" style="color: white; text-decoration: none;">Login with Google</a></button>
                          <a href="register.php">Don't have an account yet? Register here!</a>
                        </fieldset>
                      </div>
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
