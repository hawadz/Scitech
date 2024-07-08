<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["avatar"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["avatar"]["size"] > 50000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $avatar_name = basename($_FILES["avatar"]["name"]);

                // Update user's avatar in the database
                $sql = "UPDATE user SET avatar = '$avatar_name' WHERE id = '$user_id'";
                if ($conn->query($sql) === TRUE) {
                    echo "The file ". basename($_FILES["avatar"]["name"]). " has been uploaded and updated in the database.";
                    header("Location: profile.php");
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            } else {
                echo "Session user ID not set.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
