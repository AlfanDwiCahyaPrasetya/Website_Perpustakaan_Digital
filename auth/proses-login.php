<?php
include "../config/connection.php";

$email = $_POST["email"];
$password = $_POST["password"];

$query = mysqli_query($connect,"SELECT * FROM tb_user WHERE email='$email' AND password='$password'");
$row = mysqli_fetch_array($query);
if($row['email'] == $email AND $row['password'] == $password) {
    echo "<script>alert('Berhasil Login');</script>";
    session_start();
    $_SESSION['id'] = $row['id'];
    $_SESSION['password'] = $row['password'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['otoritas'] = $row['otoritas'];
    
    $idUser = $row['id'];
    $username = $row['username'];
    $email = $row['email'];
    $otoritas = $row['otoritas'];
    $alamat = $row['alamat'];
    $telepon = $row['telepon'];
    $namaLengkap = $row['nama_lengkap'];

    setcookie('id_user', $idUser, time() + (86400 * 30), "/");
    setcookie("username", $username , time() + (86400 * 30), "/");
    setcookie("email", $email , time() + (86400 * 30), "/");
    setcookie("otoritas", $otoritas , time() + (86400 * 30), "/");
    setcookie("alamat", $alamat , time() + (86400 * 30), "/");
    setcookie("telepon", $telepon , time() + (86400 * 30), "/");
    setcookie("nama_lengkap", $namaLengkap , time() + (86400 * 30), "/");

    if($row['otoritas'] == 'ADMIN') {
        header('location:../admin/index.php');
    } else {
        header('location:../visitor/index.php');
    }
    print_r($row);
} else {
    echo "<script>alert('Username atau Password Admin tidak benar !!!');</script>";
    echo "<script>location='login.php';</script>";
}

?>