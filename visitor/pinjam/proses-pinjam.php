<?php

include "../../config/connection.php";

$idUser = $_COOKIE['id_user'];
$judul = $_POST['judul'];
$tgl_pinjam = $_POST['tgl_pinjam'];
$tgl_kembali = $_POST['tgl_kembali'];
$status = $_POST['status'];

$result = mysqli_query($connect, "INSERT INTO tb_pinjam values (null, '$idUser', '$judul', '$tgl_pinjam', '$tgl_kembali', '$status')");

header('location:../data-peminjam/peminjam.php');

?>