<?php 
require "sambungkan.php"; 

if(isset($_POST['submit']))
{
    $file = $_FILES['userfile']['tmp_name'];

    // Mendapatkan ekstensi file csv yang akan diimport.
    $ekstensi  = explode('.', $_FILES['userfile']['name']);

    // Tampilkan peringatan jika submit tanpa memilih menambahkan file.
    if (empty($file)) {
        echo 'Data tidak berhasil disimpan. File tidak boleh kosong!';   
    } else {
        // Validasi apakah file yang diupload benar-benar file csv.
        if (strtolower(end($ekstensi)) === 'csv' && $_FILES["userfile"]["size"] > 0) {

            $i = 0;
            $handle = fopen($file, "r");
            while (($row = fgetcsv($handle, 2048)) ) {
                $i++;
                if ($i == 1) continue;

                // Escape special characters
                $CustomerId = mysqli_real_escape_string($conn, $row[1]);
                $FirstName = mysqli_real_escape_string($conn, $row[2]);
                $LastName = mysqli_real_escape_string($conn, $row[3]);
                $Company = mysqli_real_escape_string($conn, $row[4]);
                $City = mysqli_real_escape_string($conn, $row[5]);
                $Country = mysqli_real_escape_string($conn, $row[6]);
                $Phone1 = mysqli_real_escape_string($conn, $row[7]);
                $Phone2 = mysqli_real_escape_string($conn, $row[8]);
                $Email = mysqli_real_escape_string($conn, $row[9]);
                $SubscriptionDate = mysqli_real_escape_string($conn, $row[10]);
                $Website = mysqli_real_escape_string($conn, $row[11]);

                // Data yang akan disimpan ke dalam database
                $sql = "INSERT INTO kustomer (CustomerId, FirstName, LastName, Company, City, Country, Phone1, Phone2, Email, SubscriptionDate, Website) VALUES
                        ('$CustomerId', '$FirstName', '$LastName', '$Company', '$City', 
                         '$Country', '$Phone1', '$Phone2', '$Email', '$SubscriptionDate', '$Website')
                        ON DUPLICATE KEY UPDATE 
                        FirstName = VALUES(FirstName), 
                        LastName = VALUES(LastName), 
                        Company = VALUES(Company), 
                        City = VALUES(City), 
                        Country = VALUES(Country), 
                        Phone1 = VALUES(Phone1), 
                        Phone2 = VALUES(Phone2), 
                        Email = VALUES(Email), 
                        SubscriptionDate = VALUES(SubscriptionDate), 
                        Website = VALUES(Website)";
                echo $sql;  
                if (mysqli_query($conn, $sql)) {
                    echo "Data berhasil disimpan";
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
<body class="wide hero">
    <form class="form form-horizontal" method="post" enctype="multipart/form-data">
        <span>Upload File</span><input name="userfile" type="file"> 
        <input type="submit" value="Ajukan" name="submit"><br/><br/>
    </form>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>CustomerId</th>
                <th>FirstName</th>
                <th>LastName</th>
                <th>Company</th>
                <th>Country</th>
                <th>Phone1</th>
                <th>Phone2</th>
                <th>Email</th>
                <th>SubscriptionDate</th>
                <th>Website</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sqlproduct = "SELECT * FROM kustomer";
            $result = mysqli_query($conn, $sqlproduct);
            $no = 1;
            while ($row = mysqli_fetch_array($result)) { 
            ?>
            <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $row["CustomerId"];?></td>
                <td><?php echo $row["FirstName"];?></td>
                <td><?php echo $row["LastName"];?></td>
                <td><?php echo $row["Company"];?></td>
                <td><?php echo $row["Country"];?></td>
                <td><?php echo $row["Phone1"];?></td>
                <td><?php echo $row["Phone2"];?></td>
                <td><?php echo $row["Email"];?></td>
                <td><?php echo $row["SubscriptionDate"];?></td>
                <td><?php echo $row["Website"];?></td>
            </tr>
            <?php $no++ ; } ?>
        </tbody>
        <tfoot>
            <tr>
                <th>No</th>
                <th>CustomerId</th>
                <th>FirstName</th>
                <th>LastName</th>
                <th>Company</th>
                <th>Country</th>
                <th>Phone1</th>
                <th>Phone2</th>
                <th>Email</th>
                <th>SubscriptionDate</th>
                <th>Website</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
