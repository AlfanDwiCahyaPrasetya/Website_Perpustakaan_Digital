<?php 
            include "../../config/connection.php";

            $data = mysqli_query($connect, "SELECT * FROM tb_kategori_buku");
            $options = '';
            while($list = mysqli_fetch_assoc($data)) {
                $options .= '<option value = "'.$list['id'].'">'.$list['nama_kategori'].'</option>';   
            }
?>
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
        <div class="title"><h1>Tambah Buku</h1></div>
    </div>
    <div class="container main-book">
        <ul class="nav nav-pills mt-4">
        <li class="nav-item">
            <a class="nav-link" href="buku.php">Kembali</a>
        </li>
        <li class="nav-item">
            <form action="../../auth/logout.php" method="post">
            <button class="btn btn-outline-warning">Logout</button>
            </form>
        </li>
        </ul>
        <hr>
    </div>
    <div class="container">
    <?php
    include '../../config/connection.php';

    $ID = $_GET['id'];
    $data = mysqli_query($connect, "SELECT * FROM tb_buku WHERE id='$ID'");
    while($row = mysqli_fetch_array($data)) {
    ?>

<form action="proses-edit.php" method="post">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Judul Buku</label>
    <input type="text" class="form-control" name="judul" value="<?php echo $row['judul']; ?>">
    </div>
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Pengarang</label>
    <input type="text" class="form-control" name="pengarang" value="<?php echo $row['pengarang']; ?>">
    </div>
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Tahun Terbit</label>
    <input type="number" class="form-control" name="tahun_terbit" value="<?php echo $row['tahun_terbit']; ?>">
    </div>
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Penerbit</label>
    <input type="text" class="form-control" name="penerbit" value="<?php echo $row['penerbit']; ?>">
    </div>
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Kategori</label>
    <input type="text" name="kategori" class="form-control" value="<?php echo $row['kategori']; ?>">
    </div>
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Status</label>
    <select name="status" class="form-control">
    <option value="0">Pilih Status</option>
                    <option value="1" <?php if($row['status'] == "1") echo 'selected="selected"'; ?>>Tersedia</option>
                    <option value="2" <?php if($row['status'] == "2") echo 'selected="selected"'; ?>>Tidak Tersedia</option>
                    <option value="3" <?php if($row['status'] == "3") echo 'selected="selected"'; ?>>Dipinjam</option>
                    <option value="4" <?php if($row['status'] == "4") echo 'selected="selected"'; ?>>Selesai</option>
    </select>
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