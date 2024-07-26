<?php
require 'config.php';

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user's details
    $sql = "SELECT avatar FROM user WHERE id = '$user_id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    // Fetch list of courses
    $course_query = "SELECT * FROM kelas";
    $result2 = $conn->query($course_query);

    if (isset($_POST['id_kelas'])) {
        $id_kelas = $_POST['id_kelas'];

        // Check if user is already enrolled in the course
        $check_query = "SELECT * FROM enrolled_class WHERE id = '$user_id' AND id_kelas = '$id_kelas'";
        $check_result = $conn->query($check_query);

        if ($check_result->num_rows == 0) {
            // User is not enrolled in the course, so insert a new record
            $sql_join = "INSERT INTO enrolled_class (id, id_kelas) VALUES ('$user_id', '$id_kelas')";
            if ($conn->query($sql_join) === TRUE) {
                // Success message
                echo "<script>var showAlert = true; var alertMessage = 'You have successfully enrolled in the class!';</script>";
            } else {
                // Error message
                echo "<script>var showAlert = true; var alertMessage = 'Error joining the course. Please try again later.';</script>";
            }
        } else {
            // User is already enrolled in the course
            echo "<script>var showAlert = true; var alertMessage = 'You are already enrolled in this course.';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>SciTech Camp</title>

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
</head>
<body>

<header class="header-area header-sticky ">
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
              <li><a href="course.php">Course</a></li>
              <li class="scroll-to-section"><a href="#portfolio">Career Kit</a></li>
              <li class="scroll-to-section"><a href="#contact">About</a></li> 
              <li class="scroll-to-section profile">
              <?php if (isset($_SESSION['user_id'])): ?>
                <div style= "display: flex">
                <div>
                  <a href="profile.php">
                    <img src="uploads/<?= $user["avatar"] ?>" class="rounded-circle border border-light" style="width: 100%; height: 100%; object-fit: cover;">
                  </a>                  
                </div>
                <div class="main-blue-button">
                    <div class="user-info">
                      <div class="main"><a href="logout.php">Logout</a></div>
                    </div>
                </div>  
                </div>    
              <?php else: ?>
                <div class="main-blue-button">
                    <a href="login.php">Join Now</a>
                </div>
              <?php endif; ?>
              </li> 
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


<div id="services" class="our-services section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="section-heading" >
                    <h6>Our Main Courses</h6>
                    <h2>Discover What We Do &amp; <span>Offer</span> To Our <em>Students</em></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
    <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
        <span id="alertMessage"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
        <div class="row">
            <?php while ($kelas = $result2->fetch_assoc()): ?>
            <div class="col-lg-4">
                <div class="service-item wow bounceInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="icon">
                                <img src="assets/images/service-icon-01.png" alt="">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="right-content">
                                <h4><?= $kelas["nama_kelas"] ?></h4>
                                <p><?= $kelas["deskripsi_kelas"] ?></p>
                                <!-- Button to open modal with specific id_kelas -->
                                <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#agreementModal" onclick="setModalData(<?= $kelas['id_kelas'] ?>)">Join Course</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<!-- Agreement Modal -->
<div class="modal fade" id="agreementModal" tabindex="-1" aria-labelledby="agreementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agreementModalLabel">Term & Agreement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="course.php" method="post">
                    <!-- Course details -->
                    <input type="hidden" id="id_kelas" name="id_kelas" value="">
                    <!-- Agreement content -->
                    <div class="mb-3">
                    These terms and conditions ("Agreement") govern your participation in class offered by Scitech. By enrolling in the course, you agree to abide by these terms and conditions:
                    <br> 
                    Course Content: You will have access to course materials, including lectures, videos, readings, and assignments, as outlined in the course syllabus.<br>
                    Payment: Payment of the course fee is required to access the course materials and participate fully in the course. <br>
                    Access and License: You are granted a limited, non-exclusive, non-transferable license to access and use the course materials solely for your personal, non-commercial use. <br>
                    Participant Conduct: You agree to conduct yourself in a respectful manner towards instructors and fellow participants. Any form of harassment, discrimination, or disruptive behavior will result in immediate termination of access to the course without refund. <br>
                    Intellectual Property: All course materials are the intellectual property of Scitech. You may not reproduce, distribute, or modify any course materials without prior written permission. <br>
                    Privacy Policy: Your personal information will be handled in accordance with our Privacy Policy, which can be found on our website. <br>
                    Refunds: Refunds will be issued only in accordance with the refund policy stated on our website. <br>
                    Disclaimer of Warranties: Scitech makes no representations or warranties of any kind, express or implied, regarding the course materials or their suitability for any particular purpose.<br>
                    Limitation of Liability: Scitech shall not be liable for any indirect, incidental, special, consequential, or punitive damages, or any loss of profits or revenues. <br>
                    Modification of Terms: SciTech reserves the right to modify these terms and conditions at any time. Changes will become effective immediately upon posting on our website. <br>
                    Governing Law: This Agreement shall be governed by and construed in accordance with the laws of [State/Country], without regard to its conflict of law principles. <br>
                    By enrolling in the course, you acknowledge that you have read, understood, and agree to be bound by these terms and conditions. <br>
                    </div>
                    <!-- Checkbox for agreement -->
                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="agreementCheckbox" onchange="updateButtonState()">
                        <label class="form-check-label" for="agreementCheckbox">
                            I accept and agree to the Terms of Use
                        </label>
                    </div>
                    <!-- Button to join course -->
                    <button type="submit" class="btn btn-primary" id="btn_join_course" disabled>Join Course</button>
                </form>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright © 2024 SciTech Camp. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap core JS and additional scripts -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/animation.js"></script>
<script src="assets/js/imagesloaded.js"></script>
<script src="assets/js/custom.js"></script>

<!-- JavaScript function to set modal data -->
<script>
    function setModalData(id_kelas) {
        document.getElementById('id_kelas').value = id_kelas;
    }

    // Function to enable/disable join button based on checkbox
    function updateButtonState() {
        var checkbox = document.getElementById("agreementCheckbox");
        var button = document.getElementById("btn_join_course");

        if (checkbox.checked) {
            button.disabled = false; // Enable button
        } else {
            button.disabled = true; // Disable button
        }
    }
</script>

<script>
    if (typeof showAlert !== 'undefined' && showAlert) {
        document.getElementById('alertMessage').innerText = alertMessage;
        document.getElementById('successAlert').style.display = 'block';
    }
</script>


</body>
</html>