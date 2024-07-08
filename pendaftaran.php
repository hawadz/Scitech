<?php
require 'config.php';

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT * FROM user WHERE id = '$user_id'";
  $result = $conn->query($sql);
  $user = $result->fetch_assoc();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Form Pendaftaran</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="signatur/jquery.signature.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="signatur/jquery.signature.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <style>
        .kbw-signature { width: 100%; height: 200px;}
        #sig canvas {
            width: 100% !important;
            height: 200px;
        }
        canvas {
            border: 1px solid #ccc;
            border-radius: 0.5rem;
            width: 100%;
            height: 200px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body" style="background-color: #f8f9fa;">
                <h4 class="text-center">Form Pendaftaran</h4>
                <hr>
                <form method="post" action="toPDF.php" enctype="multipart/form-data">
                <div class="form-group">
        <label>Nama Lengkap:</label>
        <input type="text" class="form-control" name="nama_lengkap" value="<?= $user["nama"] ?>" required>
    </div>
    <div class="form-group">
        <label>NIM (Nomor Induk Mahasiswa):</label>
        <input type="text" class="form-control" name="nim" value="<?= $user["nim"] ?>" required>
    </div>
    <div class="form-group">
        <label>Program Studi:</label>
        <input type="text" class="form-control" name="program_studi" value="<?= $user["prodi"] ?>"required>
    </div>
    <div class="form-group">
        <label>Nama Pelatihan:</label>
        <input list="bootcamp" name="nama_bootcamp" required>
  <datalist id="bootcamp">
    <option value="Edge">
    <option value="Firefox">
    <option value="Chrome">
    <option value="Opera">
    <option value="Safari">
  </datalist>
    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-success" id="change-color">Change Color</button>
                        <button type="button" class="btn btn-dark" id="undo"><span class="fas fa-undo"></span> Undo</button>
                        <button type="button" class="btn btn-danger" id="clear1"><span class="fas fa-eraser"></span> Clear</button>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" value="Setujui" class="btn btn-primary" name="submit" onClick="savecanvas()">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            resizeCanvas();
        });

        function resizeCanvas() {
            var ratio = Math.max(window.devicePixelRatio || 1, 1);
            var canvas = document.getElementById("signature-pad");
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: '#fff',
            penColor: "rgb(0, 0, 0)",
            minWidth: 5,
            maxWidth: 5 
        });

        document.getElementById('clear1').addEventListener('click', function () {
            signaturePad.clear();
        });

        document.getElementById('undo').addEventListener('click', function () {
            var data = signaturePad.toData();
            if (data) {
                data.pop();
                signaturePad.fromData(data);
            }
        });

        document.getElementById('change-color').addEventListener('click', function () {
            if (signaturePad.penColor == "rgba(0, 0, 255, 1)") {
                signaturePad.penColor = "rgba(0, 0, 0, 1)";
            } else {
                signaturePad.penColor = "rgba(0, 0, 255, 1)";
            }
        });

        function savecanvas() {
            var dataURL = canvas.toDataURL("image/png");
            document.getElementById('signed').value = dataURL;
        }
    </script>
</body>
</html>
