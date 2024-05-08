<?php

include "../../config/connection.php";

$ID = $_POST['id'];
$nama_kategori = $_POST['nama_kategori'];

$result = mysqli_query($connect, "UPDATE tb_kategori_buku set 
nama_kategori='$nama_kategori' WHERE id='$ID'");

header('location:kategori-buku.php');



?>