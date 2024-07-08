<?php
session_start();
require 'config.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data dari form
$user_id = $_SESSION['user_id'];
$username = $_POST['username'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$prodi = $_POST['prodi'];
$nim = $_POST['nim'];

// Validasi data
if (empty($username) || empty($nama) || empty($email) || empty($prodi) || empty($nim)) {
    echo "All fields are required.";
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit();
}

// Perbarui data di database
$stmt = $conn->prepare("UPDATE user SET username = ?, nama = ?, email = ?, prodi = ?, nim = ? WHERE id = ?");
$stmt->bind_param("sssssi", $username, $nama, $email, $prodi, $nim, $user_id);

if ($stmt->execute()) {
    // Jika berhasil, kembalikan ke halaman profil
    header("Location: profile.php");
} else {
    echo "Error updating record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
                