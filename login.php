<?php
require 'config.php';

$error_message = '';

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

            header('Location: index.php');
            exit;
        } else {
            $_SESSION['alert_message'] = 'Wrong Password';
        }
    } else {
        $_SESSION['alert_message'] = 'Username or Password Wrong';
    }
    header('Location: login.php');
    exit;
}

$alert_message = '';
if (isset($_SESSION['alert_message'])) {
    $alert_message = $_SESSION['alert_message'];
    unset($_SESSION['alert_message']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scitech Camp</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
            background-color: #4CAF50; /* Blue */
            color: white;
            border: none;
        }
        .main-button:hover {
            background-color: #45a049;
        }
        .google-button {
            background-color: #db4437; /* Red */
            color: white;
            border: none;
        }
        .google-button:hover {
            background-color: #c23321;
        }
        .modal-header {
            background-color: #3498db; /* Purple */
            color: white;
        }
        .modal-footer .btn-primary {
            background-color: #3498db; /* Green */
            border-color: #27ae60;
        }
        .alert {
            display: none;
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

    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
  <symbol id="check-circle-fill" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>

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
                                    <div id="successAlert" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                                        <svg class="bi flex-shrink-0 me-2" width="30" height="30" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                        <span id="alertMessage"></span>
                                    </div>
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


    <script>
        $(document).ready(function() {
            var alertMessage = '<?php echo $alert_message; ?>';
            if (alertMessage) {
                document.getElementById('alertMessage').innerText = alertMessage;
                document.getElementById('successAlert').style.display = 'block';
            }
        });
    </script>

    <?php if ($error_message) : ?>
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel">Can't Login</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="redirectToLogin()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $error_message; ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="redirectToLogin()">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
        <script>
            $(document).ready(function() {
                $('#errorModal').modal('show');
            });

            function redirectToLogin() {
                window.location.href = 'login.php';
            }
        </script>
    <?php endif; ?>
</body>
</html>