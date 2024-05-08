<?php

include "../../config/connection.php";

$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$otoritas = $_POST['otoritas'];
$namaLengkap = $_POST['nama_lengkap'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];

$result = mysqli_query($connect, "UPDATE tb_user set 
username='$username', email='$email', password='$password', otoritas='$otoritas', nama_lengkap='$namaLengkap', alamat='$alamat', telepon='$telepon' WHERE id='$id'");

header('location:user.php');



?>