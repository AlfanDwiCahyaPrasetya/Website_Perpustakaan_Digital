<?php

include "../../config/connection.php";

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$otoritas = $_POST['otoritas'];
$namaLengkap = $_POST['nama_lengkap'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];

$result = mysqli_query($connect, "INSERT INTO tb_user values (null, '$username', '$email', '$password', '$otoritas', '$namaLengkap', '$alamat', '$telepon')");

header('location:user.php');

?>