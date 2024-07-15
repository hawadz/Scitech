<?php
session_start();

if (isset($_POST['submit'])) {
    include "qrcode/qrlib.php";

    // Set ID SPPD untuk QR code
    $id_sppd = 5;

    if (!empty($id_sppd)) {
        $penyimpanan = "qrimg/";
        if (!file_exists($penyimpanan))
            mkdir($penyimpanan);

        // URL untuk QR code
        $isi = "https://kelasc.cerdasbelajar.xyz/2230511109";
        QRcode::png($isi, $penyimpanan . $id_sppd . ".png");

        // Menyimpan tanda tangan
        $folderPath = "ttd/";
        $img = $_POST['signed'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = $folderPath . uniqid() . ".png";
        file_put_contents($file, $data);

        require('pdf/fpdf.php');

        $nama_lengkap = $_POST['nama_lengkap'];
        $nim = $_POST['nim'];
        $program_studi = $_POST['program_studi'];
        $nama_bootcamp = $_POST['nama_bootcamp'] . " Path by Scitech";
        $date =  date('Y-m-d');
        $tgl_penetapan = "Established on " . $date;

        // Membuat PDF
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        // Mengatur latar belakang sertifikat
        $pdf->Image('background/bckg.jpg', 0, 0, 297, 210); // Sesuaikan jalur dan ukuran gambar

        // Menambahkan logo
        $pdf->Image('logo/scitech.jpg', 15, 15, 30);

        // Mengatur font dan warna teks
        $pdf->SetTextColor(0, 0, 128);
        $pdf->SetFont('Arial', 'B', 36);
        $pdf->Cell(0, 65, 'Certificate of Completion', 0, 1, 'C');

        // Jeda baris
        $pdf->Ln(5);

        // Menambahkan teks sertifikat
        $pdf->SetFont('Arial', '', 24);
        $pdf->Cell(0, 5, 'This is to certify that', 0, 5, 'C');

        // Jeda baris
        $pdf->Ln(10);

        // Menambahkan nama peserta
        $pdf->SetFont('Arial', 'B', 30);
        $pdf->Cell(0, 10, $nama_lengkap, 0, 1, 'C'); 

        // Jeda baris
        $pdf->Ln(10);

        // Menambahkan detail sertifikat
        $pdf->SetFont('Arial', '', 20);
        $pdf->Cell(0, 10, 'has successfully completed the', 0, 1, 'C');
        $pdf->Cell(0, 10, $nama_bootcamp , 0, 1, 'C');
        $pdf->Cell(0, 10, $tgl_penetapan, 0, 1, 'C');

        // Jeda baris
        $pdf->Ln(20);

        // Menambahkan tanda tangan dan QR code
        $pdf->Image($file, 50, 150, 100);
        $pdf->Cell(160, 17, 'SciTech Bootcamp', 0, 1, 'C');
        $pdf->Image($penyimpanan . $id_sppd . ".png", 220, 150, 50);

        // Menyimpan file PDF
        $pdf->Output("filepdf/".md5($id_sppd).".pdf", 'F');
        header("location: filepdf/".md5($id_sppd).".pdf"); 
    }
}
?>
