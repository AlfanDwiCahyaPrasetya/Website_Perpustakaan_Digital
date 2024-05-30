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

if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    // Pengaturan variabel dan periksa unggahan gambar
    $updateName = $_POST['update_name'];
    $updateEmail = $_POST['update_email'];
    $updatePass = $_POST['update_pass'];
    $newPass = $_POST['new_pass'];
    $confirmPass = $_POST['confirm_pass'];
    $imageName = $fetch['image'];

    if (!empty($_FILES['update_image']['name'])) {
        $imageName = $_FILES['update_image']['name'];
        $imageTemp = $_FILES['update_image']['tmp_name'];
        $imagePath = '../uploaded_img/' . basename($imageName);

        if (!move_uploaded_file($imageTemp, $imagePath)) {
            echo "<script>alert('Gagal mengunggah gambar');</script>";
        }
    }

    if (!empty($newPass) && $newPass === $confirmPass) {
        $updatePass = $newPass;
    } elseif (!empty($newPass)) {
        echo "<script>alert('Konfirmasi password tidak cocok');</script>";
    }

    // Perbarui profil
    $updateQuery = mysqli_query($connect, "UPDATE tb_user SET nama_lengkap='$updateName', email='$updateEmail', password='$updatePass', image='$imageName' WHERE id='$userId'");

    if ($updateQuery) {
        echo "<script>alert('Profil berhasil diperbarui');</script>";
    } else {
        echo "<script>alert('Gagal memperbarui profil');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profil</title>
   <link rel="stylesheet" href="../styles/style2.css">
</head>
<body>
<div class="update-profile">
   <form action="edit-profile.php" method="post" enctype="multipart/form-data">
      <?php
         $imageSrc = $fetch['image'] ? '../uploaded_img/'.$fetch['image'] : '../uploaded_img/default-avatar.png'; // Perbaikan direktori gambar
      ?>
      <img src="<?php echo $imageSrc; ?>" alt="User Image">
      <div class="flex">
         <div class="inputBox">
            <span>Username :</span>
            <input type="text" name="update_name" value="<?php echo $fetch['nama_lengkap']; ?>" class="box" required>
            <span>E-mail :</span>
            <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box" required>
            <span>Ganti Fotomu :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
            <span>Password Lama :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>Password Baru :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>Konfirmasi Password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <input type="submit" value="Update Profile" name="update_profile" class="btn">
      <a href="profile.php" class="delete-btn">Kembali</a>
   </form>
</div>
</body>
</html>
