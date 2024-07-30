<?php

function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomPassword = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomPassword;
}

if (isset($_POST['submit'])) {
    $file = $_FILES['userfile']['tmp_name'];

    // Mendapatkan ekstensi file csv yang akan diimport.
    $ekstensi = explode('.', $_FILES['userfile']['name']);

    // Tampilkan peringatan jika submit tanpa memilih menambahkan file.
    if (empty($file)) {
        echo 'Data tidak berhasil disimpan. File tidak boleh kosong!';
    } else {
        // Validasi apakah file yang diupload benar-benar file csv.
        if (strtolower(end($ekstensi)) === 'csv' && $_FILES["userfile"]["size"] > 0) {

            $i = 0;
            $handle = fopen($file, "r");
            while (($row = fgetcsv($handle, 2048)) !== FALSE) {
                $i++;
                if ($i == 1) continue;

                // Escape special characters
                $username = mysqli_real_escape_string($conn, $row[0]);
                $nama = mysqli_real_escape_string($conn, $row[1]);
                $email = mysqli_real_escape_string($conn, $row[2]);
                $prodi = mysqli_real_escape_string($conn, $row[3]);
                $nim = mysqli_real_escape_string($conn, $row[4]);
                $avatar = mysqli_real_escape_string($conn, $row[5]);

                $password = generateRandomPassword();
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Data yang akan disimpan ke dalam database
                $sql = "INSERT INTO user (username, nama, email, prodi, nim, avatar, password) VALUES
                        ('$username', '$nama', '$email', '$prodi', '$nim', '$avatar', '$hashedPassword')
                        ON DUPLICATE KEY UPDATE 
                        nama = VALUES(nama), 
                        email = VALUES(email), 
                        prodi = VALUES(prodi), 
                        nim = VALUES(nim), 
                        avatar = VALUES(avatar),
                        password = '$hashedPassword'";
                
                
                if (mysqli_query($conn, $sql)) {
                    //echo "<script>var showAlert = true; var alertMessage = 'Data berhasil disimpan';</script>";
                    //header("Location: admin/index.php?alert=Profile updated successfully");
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
            fclose($handle);
        } else {
            echo 'Data tidak berhasil disimpan. Format file tidak valid!';
        }
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="wide hero">
    <div class="container mt-5">
        <h2>Upload CSV</h2>
        <form class="form form-horizontal" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="userfile" class="form-label">Upload File</label>
                <input class="form-control" type="file" name="userfile" id="userfile">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Upload</button>
        </form>
        <table id="example" class="display table table-striped mt-5" style="width:100%">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Prodi</th>
                    <th>NIM</th>
                    <th>Avatar</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sqlproduct = "SELECT * FROM user";
                $result = mysqli_query($conn, $sqlproduct);
                while ($row = mysqli_fetch_array($result)) { 
                ?>
                <tr>
                    <td><?php echo $row["username"];?></td>
                    <td><?php echo $row["nama"];?></td>
                    <td><?php echo $row["email"];?></td>
                    <td><?php echo $row["prodi"];?></td>
                    <td><?php echo $row["nim"];?></td>
                    <td><?php echo $row["avatar"];?></td>
                </tr>
                <?php }; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
