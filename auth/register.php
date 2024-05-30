<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../styles/style2.css">
</head>
<body>
   
<div class="form-container">

   <form action="proses-register.php" method="post" enctype="multipart/form-data">
      <h3>Sign Up</h3>
      <?php
      if(isset($message)){
         foreach($message as $msg){
            echo '<div class="message">'.$msg.'</div>';
         }
      }
      ?>
      <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" class="box" required>
      <input type="text" name="alamat" placeholder="Alamat" class="box" required>
      <input type="number" name="telepon" placeholder="Telepon" class="box" required>
      <input type="email" name="email" placeholder="Email" class="box" required>
      <input type="password" name="password" placeholder="Password" class="box" required>
      <input type="password" name="cpassword" placeholder="Konfirmasi Password" class="box" required>
      <input type="text" name="username" placeholder="Username" class="box" required>
      <input type="hidden" name="otoritas" value="MEMBER">
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png" required>
      <input type="submit" name="submit" value="Sign Up" class="btn">
      <p>Sudah Memiliki Akun? <a href="login.php">Login</a></p>
   </form>

</div>

</body>
</html>
