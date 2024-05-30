<?php

include "../config/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $username = $_POST['username'];
    $otoritas = $_POST['otoritas'];

    // Check if passwords match
    if ($password !== $cpassword) {
        echo '<script>alert("Password and Confirm Password do not match."); window.location.href = "register.php";</script>';
        exit;
    }

    // Handle image upload
    $uploadDir = '../uploaded_img/';
    $imageName = $_FILES['image']['name'];
    $imageTemp = $_FILES['image']['tmp_name'];
    $imagePath = $uploadDir . basename($imageName);

    if (move_uploaded_file($imageTemp, $imagePath)) {
        // Insert user data into the database
        $query = "INSERT INTO tb_user (username, email, password, otoritas, nama_lengkap, alamat, telepon, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param("ssssssss", $username, $email, $password, $otoritas, $nama_lengkap, $alamat, $telepon, $imageName);

        if ($stmt->execute()) {
            echo '<script>alert("Registration successful!"); window.location.href = "login.php";</script>';
        } else {
            echo '<script>alert("Error: ' . $stmt->error . '"); window.location.href = "register.php";</script>';
        }

        $stmt->close();
    } else {
        echo '<script>alert("Sorry, there was an error uploading your file."); window.location.href = "register.php";</script>';
    }
}

$connect->close();
?>
