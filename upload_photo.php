<?php
require 'config.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Mengunggah dan memproses file avatar baru
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['avatar']['name'];
        $filetype = $_FILES['avatar']['type'];
        $filesize = $_FILES['avatar']['size'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // Validasi file
        if (!in_array($ext, $allowed)) {
            header("Location: profile.php?alert=Please select a valid file format.");
        }

        // Mendapatkan nama file avatar lama
        $sql = "SELECT avatar FROM user WHERE id = '$user_id'";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        $oldAvatar = $user['avatar'];

        // Menghapus foto lama dari server
        if ($oldAvatar && file_exists("uploads/$oldAvatar")) {
            unlink("uploads/$oldAvatar");
        }

        // Menyimpan file baru
        $newFilename = uniqid() . "." . $ext;
        move_uploaded_file($_FILES['avatar']['tmp_name'], "uploads/$newFilename");

        // Memperbarui database dengan nama file baru
        $sqlUpdate = "UPDATE user SET avatar = '$newFilename' WHERE id = '$user_id'";
        if ($conn->query($sqlUpdate) === TRUE) {
            header("Location: profile.php?alert=Photo uploaded successfully.");
            exit();
        } else {
            header("Location: profile.php?alert=". $conn->error);
        }
    } else {
        die("Error: " . $_FILES['avatar']['error']);
    }
} else {
    header("Location: login.php");
    exit();
}
?>
