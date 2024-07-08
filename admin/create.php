<?php
require '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $prodi = $conn->real_escape_string($_POST['prodi']);
    $nim = $conn->real_escape_string($_POST['nim']);
    $role = 'user';

    $sql = "INSERT INTO user (username, password, nama, email, prodi, nim, role) VALUES ('$username', '$password', '$nama', '$email', '$prodi', '$nim', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful";
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<form id="contact" action="" method="post">
                <div class="row">
                  <div class="col-lg-6 offset-lg-3">
                    <div class="section-heading">
                      <h2>Register</h2>
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
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          <button type="submit" name="login" id="form-submit" class="main-button">Create User</button>
                        </fieldset>
                      </div>
                    </div>
                  </div>
              </form>
