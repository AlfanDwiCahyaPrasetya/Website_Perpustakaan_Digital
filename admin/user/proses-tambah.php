<?php

include "../../config/connection.php";

// Menangani data yang dikirimkan dari form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$otoritas = $_POST['otoritas'];
$namaLengkap = $_POST['nama_lengkap'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];

// Menangani unggahan gambar
$uploadDir = '../../uploaded_img/'; // Folder tempat menyimpan gambar
$imageName = $_FILES['image']['name']; // Nama file gambar yang diunggah
$imageTemp = $_FILES['image']['tmp_name']; // Path sementara file gambar yang diunggah
$imagePath = $uploadDir . $imageName; // Path lengkap file gambar di server

// Pindahkan file gambar dari path sementara ke folder upload_img
if (move_uploaded_file($imageTemp, $imagePath)) {
    // Jika berhasil dipindahkan, tambahkan data pengguna beserta nama file gambar ke database
    $result = mysqli_query($connect, "INSERT INTO tb_user (username, email, password, otoritas, nama_lengkap, alamat, telepon, image) VALUES ('$username', '$email', '$password', '$otoritas', '$namaLengkap', '$alamat', '$telepon', '$imageName')");
    
    if ($result) {
        // Jika berhasil, arahkan kembali ke halaman daftar pengguna
        header('location:user.php');
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($connect);
    }
} else {
    // Jika gagal memindahkan file gambar, tampilkan pesan error
    echo "Sorry, there was an error uploading your file.";
}

?>
