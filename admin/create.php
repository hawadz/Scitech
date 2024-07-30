<?php
require '../config.php';

function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomPassword = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomPassword;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $prodi = $conn->real_escape_string($_POST['prodi']);
    $nim = $conn->real_escape_string($_POST['nim']);
    
    // Generate a random password and hash it
    $password = generateRandomPassword();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO user (username, nama, email, password, prodi, nim, role) VALUES (?, ?, ?, ?, ?, ?, 'user')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssss', $username, $nama, $email, $hashedPassword, $prodi, $nim);

    if ($stmt->execute()) {
        // Send the generated password to the user's email
        $subject = "Your new account password";
        $message = "Hello $nama,\n\nYour account has been created. Your temporary password is: $password\n\nPlease change your password after logging in.";
        $headers = "From: no-reply@scitech.com";
        mail($email, $subject, $message, $headers);
        
        header('Location: index.php');
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
