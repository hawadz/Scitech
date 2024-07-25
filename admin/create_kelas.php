<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kelas = $conn->real_escape_string($_POST['nama_kelas']);
    $deskripsi_kelas = $conn->real_escape_string($_POST['deskripsi_kelas']);
    
    $sql = "INSERT INTO kelas (nama_kelas, deskripsi_kelas) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $nama_kelas, $deskripsi_kelas);

    if ($stmt->execute()) {
        header('Location: index.php');
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
    