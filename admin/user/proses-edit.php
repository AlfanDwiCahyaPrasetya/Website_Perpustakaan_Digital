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

if ($_FILES['image']['name']) {
    $uploadDir = '../../uploaded_img/';
    $imageName = $_FILES['image']['name'];
    $imageTemp = $_FILES['image']['tmp_name'];
    $imagePath = $uploadDir . basename($imageName);

    if (move_uploaded_file($imageTemp, $imagePath)) {
        $result = mysqli_query($connect, "UPDATE tb_user SET 
            username='$username', email='$email', password='$password', otoritas='$otoritas', 
            nama_lengkap='$namaLengkap', alamat='$alamat', telepon='$telepon', image='$imageName' 
            WHERE id='$id'");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
} else {
    $result = mysqli_query($connect, "UPDATE tb_user SET 
        username='$username', email='$email', password='$password', otoritas='$otoritas', 
        nama_lengkap='$namaLengkap', alamat='$alamat', telepon='$telepon' 
        WHERE id='$id'");
}

if ($result) {
    header('location:user.php');
} else {
    echo "Error: " . mysqli_error($connect);
}

?>
