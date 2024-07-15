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
        // Handle error jika tidak ada kelas yang ditemukan
        die("Error: " . $conn->error);
    }
}
?>

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
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <div style="width: 350px; height: 350px; overflow: hidden; border-radius: 50%;">
                                <img src="./uploads/<?= $user["avatar"] ?>" alt="Admin" style="width:100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="mt-3">
                                <h4>
                                    <?= $user['nama'] ?>
                                </h4>
                                <p class="text-secondary mb-1">
                                    <?= $user['prodi'] ?>
                                </p>
                                <p class="text-muted font-size-sm">
                                    <?= $user['nim'] ?>
                                </p>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editPhotoModal">Edit Photo</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
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
                                <h6 class="mb0">Email</h6>
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
                                <div class="progresss-bar" role="progressbar"
                                    style="width: 80%; background-color: #fd6a54; position: relative;">
                                    <span style="position: absolute; right: 10px; color: white; font-weight: bold;">100%</span>
                                </div>
                            </div>
                            <?php  endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Optional Bootstrap 4 CSS for progress bar styling -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <div class="row gutters-sm">
                <div class="mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="d-flex align-items-center mb-3">Sertifikat</h6>
                            <?php foreach ($kelas as $k) :?>
                            <div class="row">
                                <div class="col-6">
                                    <small>
                                        <?= $k["nama_kelas"] ?>
                                    </small>
                                </div>
                                <div class="col">
                                    <a href="signatur.php?id=<?= $k['id_kelas']; ?>">
                                    <svg height="50px" width="50px" version="1.1" id="Layer_1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 392.53 392.53"
                                            xml:space="preserve">
                                            <path style="fill:#FFFFFF;" d="M361.016,257.552c5.301,0,9.632-4.331,9.632-9.632V31.418c0-5.301-4.331-9.632-9.632-9.632H31.706
	                                            c-5.301,0-9.632,4.331-9.632,9.632v164.073h71.693c6.012,0,10.925,4.848,10.925,10.925v51.071h78.352
	                                            c-2.651-8.145-4.073-16.679-4.073-25.665c0-46.158,37.56-83.717,83.782-83.717c46.158,0,83.782,37.56,83.782,83.717
	                                            c0,8.986-1.487,17.648-4.073,25.665h18.683v0.065H361.016z" />
                                            <path style="fill:#56ACE0;"
                                                d="M108.183,235.766h70.788c-0.065-1.293-0.129-2.521-0.129-3.879c0-46.158,37.56-83.717,83.782-83.717
	                                            c46.158,0,83.782,37.56,83.782,83.717c0,0,0,0,0,0.065c1.616-1.939,2.65-4.331,2.65-7.046V54.497
	                                        c0-6.012-4.848-10.925-10.925-10.925H54.656c-6.012,0-10.925,4.848-10.925,10.925v130.198c0,3.426,1.616,6.659,4.331,8.727" />
                                                <g>
                                                <path style="fill:#194F82;" d="M316.797,82.23H75.925c-6.012,0-10.925-4.848-10.925-10.925c0-6.077,4.848-10.925,10.925-10.925
		                                            h240.937c6.012,0,10.925,4.848,10.925,10.925C327.787,77.382,322.874,82.23,316.797,82.23z" />
                                                <path style="fill:#194F82;" d="M316.797,128.259H75.925c-6.012,0-10.925-4.848-10.925-10.925c0-6.012,4.848-10.925,10.925-10.925
		h240.937c6.012,0,10.925,4.848,10.925,10.925C327.723,123.41,322.874,128.259,316.797,128.259z" />
                                                <path style="fill:#194F82;" d="M174.575,174.416H75.925c-6.012,0-10.925-4.848-10.925-10.925c0-6.012,4.848-10.925,10.925-10.925
		                                            h98.651c6.012,0,10.925,4.848,10.925,10.925C185.436,169.503,180.587,174.416,174.575,174.416z" />
                                                <path style="fill:#194F82;" d="M361.016,0H31.706C14.317,0,0.159,14.158,0.159,31.418v164.137c0,10.214,4.848,20.04,13.059,26.117
		                                            l68.073,51.071c5.624,4.267,12.606,6.594,19.653,6.594h92.703c6.788,9.891,15.774,18.23,26.053,24.436v77.705
		c-0.259,8.857,10.602,15.127,18.36,7.887l24.436-23.273l24.436,23.273c8.404,7.499,19.006-0.259,18.36-7.887v-77.705
		c10.343-6.206,19.265-14.545,26.053-24.436h29.608c17.39,0,31.418-14.158,31.418-31.418V31.418C392.563,14.158,378.405,0,361.016,0
		z M82.777,246.626l-39.046-29.285h39.046V246.626z M283.634,356.008l-13.576-12.865c-4.202-4.008-10.796-4.008-15.063,0
		l-13.511,12.8v-43.055c6.723,1.745,13.77,2.715,21.01,2.715c7.24,0,14.287-0.905,21.01-2.715v43.055h0.129V356.008z
		 M262.559,293.754c-34.133,0-61.867-27.798-61.867-61.867s27.798-61.867,61.867-61.867c34.133,0,61.867,27.798,61.867,61.867
		S296.757,293.754,262.559,293.754z M370.777,247.855c0,5.301-4.331,9.632-9.632,9.632h-18.877
		c2.65-8.145,4.073-16.679,4.073-25.665c0-46.158-37.56-83.717-83.782-83.717s-83.782,37.56-83.782,83.717
		c0,8.986,1.487,17.648,4.073,25.665h-78.287v-51.071c0-6.012-4.848-10.925-10.925-10.925H21.945V31.418
		c0-5.301,4.331-9.632,9.632-9.632h329.438c5.301,0,9.632,4.331,9.632,9.632v216.436H370.777z" />
                                            </g>
                                            <g>
                                                <path style="fill:#FFC10D;" d="M241.549,312.954v43.119l13.511-12.8c4.202-4.008,10.796-4.008,15.063,0l13.511,12.8v-43.119
		c-6.723,1.745-13.77,2.715-21.01,2.715C255.319,315.604,248.272,314.634,241.549,312.954z" />
                                                <path style="fill:#FFC10D;" d="M262.559,170.02c-34.133,0-61.867,27.798-61.867,61.867s27.798,61.867,61.867,61.867
		c34.133,0,61.867-27.798,61.867-61.867S296.757,170.02,262.559,170.02z" />
                                            </g>
                                            <polygon style="fill:#FFFFFF;"
                                                points="82.777,217.341 43.731,217.341 82.777,246.626 " />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
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

    <!-- Modal Edit Profile -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="update_profile.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?= htmlspecialchars($user['username']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="<?= htmlspecialchars($user['nama']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="prodi" class="form-label">Program Studi</label>
                            <input type="text" class="form-control" id="prodi" name="prodi"
                                value="<?= htmlspecialchars($user['prodi']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim"
                                value="<?= htmlspecialchars($user['nim']) ?>" required>
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

    <script>
        $(document).ready(function () {
            $("#editButton").on("click", function () {
                $("#editModal").modal("show");
            });
        });
    </script>
</body>

</html>