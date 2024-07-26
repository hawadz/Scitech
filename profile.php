<?php
require 'config.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM user WHERE id = '$user_id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    $sql2 = "SELECT kelas.nama_kelas, kelas.id_kelas 
        FROM kelas 
        JOIN enrolled_class ON kelas.id_kelas = enrolled_class.id_kelas 
        WHERE id = '$user_id'";
    $result_courses = $conn->query($sql2);
    $kelas = [];
    if ($result_courses) {
        while ($row = $result_courses->fetch_assoc()) {
            $kelas[] = $row;
        }
    } else {
        die("Error: " . $conn->error);
    }
}

$alertMessage = isset($_GET['alert']) ? $_GET['alert'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/templatemo-seo-dream.css">
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
                    <li class="scroll-to-section"><a href="course.php">Course</a></li>
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
        <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
            <span id="alertMessage"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <div style="width: 350px; height: 350px; overflow: hidden; border-radius: 50%;">
                                <img src="./uploads/<?= $user["avatar"] ?>" alt="User" style="width:100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="mt-3">
                                <h4><?= $user['nama'] ?></h4>
                                <p class="text-secondary mb-1"><?= $user['prodi'] ?></p>
                                <p class="text-muted font-size-sm"><?= $user['nim'] ?></p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPhotoModal">Upload Photo</button>
                                <form action="delete_photo.php" method="post" style="display: inline;">
                                    <button type="submit" class="btn btn-danger">Delete Photo</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Username</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"><?= $user['username'] ?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"><?= $user['nama'] ?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"><?= $user['email'] ?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Program Studi</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"><?= $user['prodi'] ?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">NIM</h6>
                            </div>
                            <div class="col-sm-9 text-secondary"><?= $user['nim'] ?></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <a class="btn btn-info" href="#" id="editButton">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row gutters-sm">
                <div class="mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="d-flex align-items-center mb-3">Pelatihan</h6>
                            <?php foreach($kelas as $k) : ?>
                            <small><?= $k['nama_kelas'] ?></small>
                            <div class="progresss mb-3" style="height: 20px; background-color: blue;">
                                <div class="progresss-bar" role="progressbar" style="width: 80%; background-color: #fd6a54; position: relative;">
                                    <span style="position: absolute; right: 10px; color: white; font-weight: bold;">100%</span>
                                </div>
                            </div>
                            <?php  endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row gutters-sm">
                <div class="mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="d-flex align-items-center mb-3">Sertifikat</h6>
                            <?php foreach ($kelas as $k) :?>
                            <div class="row">
                                <div class="col-6">
                                    <small><?= $k["nama_kelas"] ?></small>
                                </div>
                                <div class="col">
                                    <a href="signatur.php?id=<?= $k['id_kelas']; ?>">
                                    <svg height="50px" width="50px" version="1.1" id="Layer_1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 392.53 392.53"
                                            xml:space="preserve">
                                            <path style="fill:#FFFFFF;" d="M361.016,257.552c5.301,0,9.632-4.331,9.632-9.632V69.257
                                                c0-16.065-13.063-29.128-29.129-29.128H51.012c-16.065,0-29.129,13.063-29.129,29.128v178.663
                                                c0,5.301,4.331,9.632,9.632,9.632c5.301,0,9.632-4.331,9.632-9.632V69.257c0-5.741,4.673-10.414,10.414-10.414h290.507
                                                c5.741,0,10.414,4.673,10.414,10.414v178.663C351.384,253.221,355.715,257.552,361.016,257.552z" />
                                            <path style="fill:#FFFFFF;" d="M383.315,299.43c-1.146-2.849-3.774-4.808-6.838-4.808h-73.366c-2.442,0-4.73,1.168-6.153,3.139
                                                l-21.469,28.617H116.545l-21.469-28.617c-1.423-1.971-3.711-3.139-6.153-3.139H15.404c-3.064,0-5.692,1.959-6.838,4.808
                                                c-1.146,2.849-0.429,6.114,1.822,8.254l69.426,64.084c1.791,1.653,4.113,2.564,6.518,2.564h219.117
                                                c2.405,0,4.727-0.911,6.518-2.564l69.426-64.084C383.745,305.544,384.461,302.279,383.315,299.43z" />
                                            <g>
                                                <path style="fill:#010002;" d="M126.957,208.615c12.899,0,23.412-10.514,23.412-23.412c0-12.898-10.514-23.412-23.412-23.412
                                                    c-12.898,0-23.412,10.514-23.412,23.412C103.545,198.101,114.059,208.615,126.957,208.615z M126.957,172.417
                                                    c7.281,0,13.188,5.918,13.188,13.188c0,7.271-5.908,13.188-13.188,13.188c-7.271,0-13.188-5.918-13.188-13.188
                                                    C113.77,178.335,119.688,172.417,126.957,172.417z" />
                                                <path style="fill:#010002;" d="M265.573,208.615c12.898,0,23.412-10.514,23.412-23.412c0-12.898-10.514-23.412-23.412-23.412
                                                    c-12.898,0-23.412,10.514-23.412,23.412C242.161,198.101,252.675,208.615,265.573,208.615z M265.573,172.417
                                                    c7.271,0,13.188,5.918,13.188,13.188c0,7.271-5.918,13.188-13.188,13.188c-7.281,0-13.188-5.918-13.188-13.188
                                                    C252.384,178.335,258.293,172.417,265.573,172.417z" />
                                                <path style="fill:#010002;" d="M284.107,238.047c-1.8-1.792-4.292-2.797-6.868-2.797H115.293c-2.576,0-5.068,1.005-6.868,2.797
                                                    c-1.8,1.8-2.805,4.282-2.805,6.868s1.005,5.068,2.805,6.868c1.8,1.8,4.292,2.797,6.868,2.797h161.945
                                                    c2.576,0,5.068-1.005,6.868-2.797c1.8-1.8,2.797-4.292,2.797-6.868S285.907,239.847,284.107,238.047z" />
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Photo -->
    <div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="editPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editPhotoForm" action="upload_photo.php" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPhotoModalLabel">Upload Photo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Choose a new photo</label>
                            <input class="form-control" type="file" id="avatar" name="avatar" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if ($alertMessage): ?>
    <script>
        $(document).ready(function () {
            $('#alertMessage').text('<?= $alertMessage ?>');
            $('#successAlert').show();
        });
    </script>
    <?php endif; ?>
</body>
</html>
