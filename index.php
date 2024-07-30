<?php
require 'config.php';

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT avatar, role FROM user WHERE id = '$user_id'";
  $result = $conn->query($sql);
  $user = $result->fetch_assoc();
}

$course_query = "SELECT * FROM kelas";
$result2 = $conn->query($course_query);

$project_query = "SELECT * FROM project";
$result3 = $conn->query($project_query);

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <title>SciTech Camp</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-seo-dream.css">
    <link rel="stylesheet" href="assets/css/animated.css">
    <link rel="stylesheet" href="assets/css/owl.css">
<!--



https://templatemo.com/tm-563-seo-dream

-->

</head>

<body>

  <!-- ***** Preloader Start 
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
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
              <li class="scroll-to-section"><a href="course.php">Course</a></li>
              <li class="scroll-to-section"><a href="#portfolio">Career Kit</a></li>
              <li class="scroll-to-section"><a href="#contact">About</a></li> 
              <li class="scroll-to-section profile">
              <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($user['role'] == 'admin') { ?>
                <div style= "display: flex">
                <div>
                  <a href="admin/index.php">
                    <img src="uploads/<?= $user["avatar"]?>" alt="Admin" class="rounded-circle" width="100" height="50">
                  </a>                  
                </div>
                <div class="main-blue-button ">
                    <div class="user-info">
                      <div class="main"><a href="logout.php">Logout</a></div>
                    </div>
                </div>  
                </div>
                <?php } else { ?>
                  <div style= "display: flex">
                <div>
                  <a href="profile.php">
                    <img src="uploads/<?= $user["avatar"]?>" alt="User" class="rounded-circle" width="10" height="30">
                  </a>                  
                </div>
                <div class="main-blue-button ">
                    <div class="user-info">
                      <div class="main"><a href="logout.php">Logout</a></div>
                    </div>
                </div>  
                </div>
                <?php } ?>
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
  <!-- ***** Header Area End ***** -->

  <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6 align-self-center">
              <div class="left-content header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                <div class="row">
                  <div class="col-lg-4 col-sm-4">
                    <div class="info-stat">
                      <h4>Bootcamp</h4>
                    </div>
                  </div>
                  <div class="col-lg-4 col-sm-4">
                    <div class="info-stat">
                      <h4>Course</h4>
                    </div>
                  </div>
                  <div class="col-lg-4 col-sm-4">
                    <div class="info-stat">
                      <h4>Learning</h4>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <h2>SciTech Camp Science & Technology Experience Camp</h2>
                  </div>
                  <div class="col-lg-12">
                    <div class="main-green-button scroll-to-section">
                      <a href="register.php">Get Your Experience Camp</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                <img src="assets/images/banner-right-image.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="features" class="features section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="features-content">
            <div class="row">
              <div class="col-lg-3">
                <div class="features-item first-feature wow fadeInUp" data-wow-duration="1s" data-wow-delay="0s">
                  <div class="first-number number">
                    <h6>01</h6>
                  </div>
                  <div class="icon"></div>
                  <h4>Pembelajaran Interaktif</h4>
                  <div class="line-dec"></div>
                  <p>Dalam program ini, peserta akan terlibat dalam pembelajaran yang interaktif dan praktis. Melalui sesi-sesi pelatihan yang intensif, mereka akan memperoleh pemahaman yang mendalam tentang konsep-konsep ilmiah dan teknologi terkini.</p>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="features-item second-feature wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                  <div class="second-number number">
                    <h6>02</h6>
                  </div>
                  <div class="icon"></div>
                  <h4>Keterampilan Praktis yang Dikembangkan</h4>
                  <div class="line-dec"></div>
                  <p>SciTech Camp menawarkan kesempatan bagi peserta untuk mengembangkan keterampilan praktis dalam berbagai bidang, seperti pemrograman komputer, pengembangan aplikasi, desain web, dan analisis data.</p>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="features-item first-feature wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">
                  <div class="third-number number">
                    <h6>03</h6>
                  </div>
                  <div class="icon"></div>
                  <h4>Bimbingan oleh Ahli dan Praktisi Terkemuka</h4>
                  <div class="line-dec"></div>
                  <p>Peserta akan mendapatkan bimbingan langsung dari para ahli dan praktisi terkemuka dalam industri sains dan teknologi. Mereka akan berbagi pengalaman mereka serta memberikan wawasan berharga tentang tren dan tantangan di bidang ini.</p>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="features-item second-feature last-features-item wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s">
                  <div class="fourth-number number">
                    <h6>04</h6>
                  </div>
                  <div class="icon"></div>
                  <h4>Akses ke Fasilitas dan Sumber Daya Universitas</h4>
                  <div class="line-dec"></div>
                  <p>Sebagai bagian dari Universitas Muhammadiyah Sukabumi, peserta SciTech Camp akan mendapatkan akses ke fasilitas dan sumber daya yang luas, termasuk laboratorium teknologi terkini dan perpustakaan yang lengkap. Hal ini akan memperkaya pengalaman belajar mereka dan mendukung pengembangan karir di masa depan.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="skills-content">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="about" class="about-us section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="left-image wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.5s">
            <img src="assets/images/about-left-image.png" alt="">
          </div>
        </div>
        <div class="col-lg-6 align-self-center wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
          <div class="section-heading">
            <h6>About Us</h6>
            <h2>Join the <em>SciTech</em> Camp &amp; enhance your <span>skills with us</span></h2>
          </div>
          <div class="row">
            <div class="col-lg-4 col-sm-4">
              <div class="about-item">
                <h4>100+</h4>
                <h6>workshops held</h6>
              </div>
            </div>
            <div class="col-lg-4 col-sm-4">
              <div class="about-item">
                <h4>500+</h4>
                <h6>students trained</h6>
              </div>
            </div>
            <div class="col-lg-4 col-sm-4">
              <div class="about-item">
                <h4>50+</h4>
                <h6>expert speakers</h6>
              </div>
            </div>
          </div>
          <p><a>SciTech Camp</a> is a dedicated bootcamp for science and technology students at Universitas Muhammadiyah Sukabumi. Join us to enhance your skills and knowledge in various fields of science and technology through hands-on workshops and expert guidance. For more information, visit our website. Thank you.</p>
          <div class="main-green-button"><a href="#">Discover SciTech Camp</a></div>
        </div>
      </div>
    </div>
  </div>


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


  <div id="portfolio" class="our-portfolio section">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="section-heading wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
            <h6>Our Portfolio</h6>
            <h2>Discover Our Recent <em>Projects</em> And <span>Achievements</span></h2>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid wow fadeIn" data-wow-duration="1s" data-wow-delay="0.7s">
      <div class="row">
        <div class="col-lg-12">
          <div class="loop owl-carousel">
          <?php while ($project = $result3->fetch_assoc()): ?>
            <div class="item">
              <div class="portfolio-item">
                <div class="thumb">
                  <img src="assets/images/<?= $project['foto_project']?>" alt="">
                  <div class="hover-content">
                    <div class="inner-content">
                      <a href="#"><h4><?= $project['nama_project']?></h4></a>
                      <span><?= $project['bidang']?></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="portfolio-item">
                <div class="thumb">
                  <img src="assets/images/<?= $project['foto_project']?>" alt="">
                  <div class="hover-content">
                    <div class="inner-content">
                      <a href="#"><h4><?= $project['nama_project']?></h4></a>
                      <span><?= $project['bidang']?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
    </div>
  </div>



  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright © 2024 SciTech Camp. All Rights Reserved. 
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/animation.js"></script>
  <script src="assets/js/imagesloaded.js"></script>
  <script src="assets/js/custom.js"></script>

</body>
</html>