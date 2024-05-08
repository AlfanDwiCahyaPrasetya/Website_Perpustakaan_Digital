<?php

include "../../config/connection.php";

$nama_kategori = $_POST['nama_kategori'];

$result = mysqli_query($connect, "INSERT INTO tb_kategori_buku values (null, '$nama_kategori')");

header('location:kategori-buku.php');

?>