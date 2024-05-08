<?php

include "../../config/connection.php";

$idStatus = $_POST['id_status'];
$id = $_GET['id'];
$selesai = 4;
$updateStatus = mysqli_query($connect, "UPDATE tb_pinjam set id_status='$selesai' WHERE id='$id'");
// $deleteList = mysqli_query($connect, "DELETE FROM tb_pinjam WHERE id='$id'");

header('location:peminjam.php');

?>