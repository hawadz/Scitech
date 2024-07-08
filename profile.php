<?php
require 'config.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM user WHERE id = '$user_id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-seo-dream.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Profile Page</title>
</head>
<body>
<header class="header-area header-sticky">
    <div class="container">
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
                <li class="scroll-to-section profile">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="main-blue-button">
                        <a href="logout.php">Logout</a>
                    </div>
                <?php else: ?>
                    <div class="main-blue-button">
                        <a href="login.php">Join Now</a>
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

<div class="main-banner container super-profile">
    <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                    <img src="./uploads/<?= $user["avatar"] ?>" alt="Admin" class="rounded-circle" width="20" height="350">
                        <div class="mt-3">
                            <h4><?= $user['nama'] ?></h4>
                            <p class="text-secondary mb-1"><?= $user['prodi'] ?></p>
                            <p class="text-muted font-size-sm"><?= $user['nim'] ?></p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPhotoModal">Edit Photo</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">Website</h6>
                        <span class="text-secondary">https://bootdey.com</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">Github</h6>
                        <span class="text-secondary">bootdey</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">Twitter</h6>
                        <span class="text-secondary">@bootdey</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">Instagram</h6>
                        <span class="text-secondary">bootdey</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">Facebook</h6>
                        <span class="text-secondary">bootdey</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Username</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $user['username'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $user['nama'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                        <?= $user['email'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Program Studi</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                        <?= $user['prodi'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">NIM</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                        <?= $user['nim'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-info" href="edit_profile.php">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutters-sm">
                <div class="mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="d-flex align-items-center mb-3">Pelatihan</h6>
                            <small>Web Design</small>
                            <div class="progress mb-3" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small>Website Markup</small>
                            <div class="progress mb-3" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 72%;" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small>One Page</small>
                            <div class="progress mb-3" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 89%;" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small>Mobile Template</small>
                            <div class="progress mb-3" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small>Backend API</small>
                            <div class="progress mb-3" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 66%;" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gutters-sm">
                <div class="mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="d-flex align-items-center mb-3">Sertifikat</h6>
                            <div class="row">
                                <div class="col-6">
                                    <small>Web Design</small>
                                </div>
                                <div class="col">
                                <a href="signatur.php">
                                    <svg width="100px" height="100px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.5 9.5V8.7C18.5 7.57989 18.5 7.01984 18.282 6.59202C18.0903 6.21569 17.7843 5.90973 17.408 5.71799C16.9802 5.5 16.4201 5.5 15.3 5.5H7.7C6.57989 5.5 6.01984 5.5 5.59202 5.71799C5.21569 5.90973 4.90973 6.21569 4.71799 6.59202C4.5 7.01984 4.5 7.57989 4.5 8.7V12.3C4.5 13.4201 4.5 13.9802 4.71799 14.408C4.90973 14.7843 5.21569 15.0903 5.59202 15.282C6.01984 15.5 6.57989 15.5 7.7 15.5H13.5" stroke="#222222" stroke-linecap="round"/>
                                    <path d="M7.5 12.5H11.5" stroke="#33363F" stroke-linecap="round"/>
                                    <path d="M7.5 8.5H14.5" stroke="#33363F" stroke-linecap="round"/>
                                    <circle cx="17.5" cy="13.5" r="2" stroke="#222222"/>
                                    <path d="M19.5 18.5C19.5 18.5 19 17.5 17.5 17.5C16 17.5 15.5 18.5 15.5 18.5" stroke="#222222" stroke-linecap="round"/>
                                    </svg>
                                </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<!-- Edit Photo Modal -->
<div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="editPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPhotoModalLabel">Edit Profile Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Choose a new profile photo</label>
                        <input class="form-control" type="file" id="avatar" name="avatar">
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuTrigger = document.querySelector('.menu-trigger');
        const nav = document.querySelector('.header-area .nav');

        menuTrigger.addEventListener('click', () => {
            nav.classList.toggle('active');
        });

        // Initialize modal manually
        var editPhotoModal = new bootstrap.Modal(document.getElementById('editPhotoModal'));
    });
</script>
</body>
</html>
