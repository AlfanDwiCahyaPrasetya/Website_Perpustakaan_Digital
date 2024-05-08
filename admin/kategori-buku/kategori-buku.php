<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan</title>
    <link rel="stylesheet" href="../../styles/css/all.css">
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
            <a class="nav-link" href="../index.php">Kembali</a>
        </li>
        <li class="nav-item">
            <form action="../../auth/logout.php" method="post">
            <button class="btn btn-outline-warning">Logout</button>
            </form>
        </li>
        </ul>
        <hr>
    </div>
    <div class="container table-responsive ">
    <table class="table table-striped">
    <tr>
        <th>No</th>
        <th>Kategori</th>
        <th>Aksi</th>
    </tr>
    <?php
    include '../../config/connection.php';
    $no = 1;
    $data = mysqli_query($connect, "SELECT * from tb_kategori_buku");
    while($row = mysqli_fetch_array($data)) {
        ?>
        <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $row['nama_kategori'] ?></td>
            <td>
                <a href="edit-kategori-buku.php?id=<?php echo $row['id']; ?>"><i class="fas fa-pen-square" style="font-size:1.6em; color: orange;"></i></a>
                <a href="hapus-kategori-buku.php?id=<?php echo $row['id']; ?>"><i class="fas fa-minus-square" style="font-size:1.6em;color: red"></i></a>
            </td>
        </tr>
        <?php
    }
    ?>
    </table>
</div>
</body>
</html>