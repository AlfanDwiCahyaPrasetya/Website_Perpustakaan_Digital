<?php
// memanggil library FPDF
require('../../lib/fpdf.php');
include '../../config/connection.php';

// Menghindari output sebelum menggunakan FPDF
ob_start();

// instance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(200, 10, 'Laporan Riwayat Peminjaman Buku', 0, 0, 'C');

$pdf->Cell(10, 15, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(10, 7, 'NO', 1, 0, 'C');
$pdf->Cell(50, 7, 'Nama Peminjam', 1, 0, 'C');
$pdf->Cell(50, 7, 'Buku', 1, 0, 'C');
$pdf->Cell(30, 7, 'Tanggal Pinjam', 1, 0, 'C');
$pdf->Cell(30, 7, 'Tanggal Kembali', 1, 0, 'C');
$pdf->Cell(20, 7, 'Status', 1, 1, 'C');

$pdf->SetFont('Times', '', 10);
$no = 1;

$result = mysqli_query($connect, "SELECT tb_user.username, tb_user.nama_lengkap, tb_buku.judul, tgl_pinjam, tgl_kembali, tb_status.status FROM (((tb_pinjam INNER JOIN tb_user ON tb_pinjam.id_user = tb_user.id) INNER JOIN tb_buku ON tb_pinjam.id_buku = tb_buku.id ) INNER JOIN tb_status ON tb_pinjam.id_status = tb_status.id)");

while ($row = mysqli_fetch_array($result)) {
    // Only include entries for the current user
    if ($_COOKIE['username'] == $row['username']) {
        $pdf->Cell(10, 6, $no++, 1, 0, 'C');
        $pdf->Cell(50, 6, $row['nama_lengkap'], 1, 0);
        $pdf->Cell(50, 6, $row['judul'], 1, 0);
        $pdf->Cell(30, 6, $row['tgl_pinjam'], 1, 0);
        $pdf->Cell(30, 6, $row['tgl_kembali'], 1, 0);
        $pdf->Cell(20, 6, $row['status'], 1, 1);
    }
}

// Output the PDF
$pdf->Output();
ob_end_flush();
?>
