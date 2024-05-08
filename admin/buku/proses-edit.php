<?php

include "../../config/connection.php";
$id = $_POST['id'];
$judul = $_POST['judul'];
$pengarang = $_POST['pengarang'];
$tahun_terbit = $_POST['tahun_terbit'];
$penerbit = $_POST['penerbit'];
$kategori = $_POST['kategori'];
$status = $_POST['status'];

$result = mysqli_query($connect, "UPDATE tb_buku set 
judul='$judul', pengarang='$pengarang', tahun_terbit='$tahun_terbit', penerbit='$penerbit', kategori='$kategori', status='$status' WHERE id='$id'");

header('location:buku.php');



?>