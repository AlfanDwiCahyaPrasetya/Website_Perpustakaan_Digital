<?php

include '../../config/connection.php';

$id = $_GET['id'];
mysqli_query($connect, "DELETE FROM tb_buku WHERE id='$id'");

header("location: buku.php");

?>