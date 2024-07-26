<?php
require 'config.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT avatar FROM user WHERE id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $avatar_path = './uploads/' . $user['avatar'];

        // Delete the avatar file if it exists
        if (file_exists($avatar_path)) {
            unlink($avatar_path);
        }

        // Update the user's avatar to null in the database
        $sql = "UPDATE user SET avatar = NULL WHERE id = '$user_id'";
        if ($conn->query($sql) === TRUE) {
            header("Location: profile.php?alert=Photo deleted successfully");
        } else {
            header("Location: profile.php?alert=Failed to delete photo");
        }
    } else {
        header("Location: profile.php?alert=User not found");
    }
} else {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head content -->
</head>
<body>
    <header class="header-area header-sticky">
        <!-- Your header content -->
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
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPhotoModal">Edit Photo</button>
                                <a href="delete_photo.php" class="btn btn-danger">Delete Photo</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Other card content -->
            </div>
            <!-- Other columns -->
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

    <!-- Other modals and scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var alertMessage = <?php echo json_encode($alertMessage); ?>;
            if (alertMessage) {
                document.getElementById('alertMessage').innerText = alertMessage;
                document.getElementById('successAlert').style.display = 'block';
            }
        });
    </script>
</body>
</html>
