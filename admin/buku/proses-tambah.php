<?php

include "../../config/connection.php";

$judul = $_POST['judul'];
$pengarang = $_POST['pengarang'];
$tahun_terbit = $_POST['tahun_terbit'];
$penerbit = $_POST['penerbit'];
$kategori = $_POST['kategori'];
$status = $_POST['status'];

$result = mysqli_query($connect, "INSERT INTO tb_buku values (null, '$judul', '$pengarang', '$tahun_terbit', '$penerbit', '$kategori', '$status')");

header('location:buku.php');

?>