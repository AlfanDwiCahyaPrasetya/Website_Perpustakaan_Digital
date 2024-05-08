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
        <div class="title"><h1>Daftar Kategori Buku Perpustakaan</h1></div>
    </div>
    <div class="container main-book">
        <ul class="nav nav-pills mt-4">
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="tambah-kategori-buku.php">Tambah Kategori Buku</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="kategori-buku.php">Kembali</a>
        </li>
        <li class="nav-item">
            <form action="../../auth/logout.php" method="post">
            <button class="btn btn-outline-warning">Logout</button>
            </form>
        </li>
        </ul>
        <hr>
    </div>
    <?php
    include '../../config/connection.php';

    $ID = $_GET['id'];
    $data = mysqli_query($connect, "SELECT * FROM tb_kategori_buku WHERE id='$ID'");
    while($row = mysqli_fetch_array($data)) {
    ?>
    <div class="container">
    <form action="proses-edit.php" method="post">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Kategori Buku</label>
    <input type="text" class="form-control" name="nama_kategori" value="<?php echo $row['nama_kategori']; ?>">
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