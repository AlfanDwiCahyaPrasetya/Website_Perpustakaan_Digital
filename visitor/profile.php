<?php
session_start();
require_once "../config/connection.php";

if (!isset($_SESSION['id'])) {
    echo "<script>alert('Anda harus login terlebih dahulu');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}

$userId = $_SESSION['id'];
$select = mysqli_query($connect, "SELECT * FROM tb_user WHERE id='$userId'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profil Pengguna</title>
   <link rel="stylesheet" href="../styles/style2.css">
</head>
<body>
<div class="container">
   <div class="profile">
      <?php
         if (mysqli_num_rows($select) > 0) {
            $fetch = mysqli_fetch_assoc($select);
            $imageSrc = $fetch['image'] ? '../uploaded_img/'.$fetch['image'] : '../uploaded_img/default-avatar.png'; // Perbaikan direktori gambar
      ?>
      <img src="<?php echo $imageSrc; ?>" alt="User Image">
      <h3><?php echo $fetch['nama_lengkap']; ?></h3>
      <a href="edit-profile.php" class="btn">Update Profile</a>
      <a href="index.php" class="delete-btn">Kembali</a>
      <?php
         } else {
            echo "<p>Profil tidak ditemukan</p>";
         }
      ?>
   </div>
</div>
</body>
</html>
