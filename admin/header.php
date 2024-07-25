<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/templatemo-seo-dream.css">
    <title>Profile Page</title>
</head>

<body>
    <header class="header-area header-sticky">
        <div class="container">
            <nav class="main-nav">
                <a href="index.php" class="logo">
                    <h4>SciTech Camp<img src="../assets/images/logo-icon.png" alt=""></h4>
                </a>
                <ul class="nav">
                    <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                    <li class="scroll-to-section"><a href="#features">E-Learning</a></li>
                    <li class="scroll-to-section"><a href="#about">Bootcamp & Program</a></li>
                    <li class="scroll-to-section"><a href="../course.php">Course</a></li>
                    <li class="scroll-to-section"><a href="#portfolio">Career Kit</a></li>
                    <li class="scroll-to-section"><a href="#contact">About</a></li>
                    <li class="scroll-to-section profile">
                        <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="main-blue-button">
                            <a href="../logout.php">Logout</a>
                        </div>
                        <?php else: ?>
                        <div class="main-blue-button">
                            <a href="../login.php">Join Now</a>
                        </div>
                        <?php endif; ?>
                    </li>
                </ul>
                <a class="menu-trigger">
                    <span>Menu</span>
                </a>
            </nav>
        </div>
    </header>
</body>
</html>