<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan</title>
    <link rel="stylesheet" href="../../styles/bootstrap.min.css">
    <link rel="stylesheet" href="../../styles/styles.css">
    <script src="../../scripts/bootstrap.min.js"></script>
    <script src="../../scripts/jquery.min.js"></script>
</head>
<body>
<div class="container-fluid bg-primary text-white p-3 text-center d-flex  justify-content-center fixed-top main-book">
        <div class="title"><h1>Daftar Anggota Perpustakaan</h1></div>
    </div>
    <div class="container main-book">
        <ul class="nav nav-pills mt-4">
        <li class="nav-item">
            <a class="nav-link" href="user.php">Kembali</a>
        </li>
        <li class="nav-item">
            <form action="../../auth/logout.php" method="post">
            <button class="btn btn-outline-warning">Logout</button>
            </form>
        </li>
        </ul>
        <hr>
    </div>
    <div class="container mb-4">
    <?php
    include '../../config/connection.php';

    $ID = $_GET['id'];
    $data = mysqli_query($connect, "SELECT * FROM tb_user WHERE id='$ID'");
    while($row = mysqli_fetch_array($data)) {
    ?>
    <form action="proses-edit.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <div class="mb-3">
    <label for="namaLengkap" class="form-label">Nama Lengkap</label>
    <input type="text" class="form-control" name="nama_lengkap" value="<?php echo $row['nama_lengkap']; ?>">
    </div>
    <div class="mb-3">
    <label for="alamat" class="form-label">Alamat</label>
    <input type="text" class="form-control" name="alamat" value="<?php echo $row['alamat']; ?>">
    </div>
    <div class="mb-3">
    <label for="telepon" class="form-label">Telepon</label>
    <input type="number" class="form-control" name="telepon" value="<?php echo $row['telepon']; ?>">
    </div>
    <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>">
    </div>
    <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" name="password" value="<?php echo $row['password']; ?>">
    </div>
    <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>">
    </div>
    <div class="mb-3">
    <label for="otoritas" class="form-label">Otoritas</label>
    <select name="otoritas" class="form-control">
        <option value="0">Pilih otoritas</option>
        <option value="ADMIN" <?php if($row['otoritas'] == "ADMIN") echo 'selected="selected"'; ?>>ADMIN</option>
        <option value="MEMBER" <?php if($row['otoritas'] == "MEMBER") echo 'selected="selected"'; ?>>MEMBER</option>
    </select>
    </div>
    <div class="mb-3">
        <label for="currentImage" class="form-label">Gambar Saat Ini</label><br>
        <?php if ($row['image']): ?>
            <img src="../../uploaded_img/<?php echo $row['image'] ?>" alt="User Image" style="width: 100px; height: 100px; object-fit: cover;">
        <?php else: ?>
            <img src="../../uploads/default.png" alt="Default Image" style="width: 100px; height: 100px; object-fit: cover;">
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Gambar Baru</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>
    <div class="d-grid gap-2">
        <input type="submit" class="btn btn-primary btn-block" value="Simpan">
    </div>
    </form>
    </div>
    <?php
    }
    ?>
</body>
</html>
