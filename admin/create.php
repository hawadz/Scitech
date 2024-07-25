<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $prodi = $conn->real_escape_string($_POST['prodi']);
    $nim = $conn->real_escape_string($_POST['nim']);
    
    $sql = "INSERT INTO user (username, nama, email, prodi, nim, role) VALUES (?, ?, ?, ?, ?, 'user')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $username, $nama, $email, $prodi, $nim);

    if ($stmt->execute()) {
        header('Location: index.php');
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
    