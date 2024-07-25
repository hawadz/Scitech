<?php
require 'config.php';

$id = $_SESSION['user_id'];
$id_kelas = $_GET['id_kelas'];
$sql = "DELETE FROM enrolled_class WHERE id = '$id' and id_kelas = '$id_kelas'";

if ($conn->query($sql) === TRUE) {
    $message = 'You have successfully canceled your enrolled class!';
} else {
    $message = 'Failed to cancel your enrolled class. Try again later.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redirecting...</title>
    <script>
        var showAlert = true;
        var alertMessage = <?php echo json_encode($message); ?>;
    </script>
</head>
<body>
    <script>
        // Redirect to the profile page with alert
        window.location.href = 'profile.php?alert=' + encodeURIComponent(alertMessage);
    </script>
</body>
</html>
