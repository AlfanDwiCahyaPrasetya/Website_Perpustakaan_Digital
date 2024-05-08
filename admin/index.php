<?php

    // session_start();
    // if(isset($_SESSION['username'])) {
    //     // echo "Selamat Datang";
    //     // echo $_COOKIE['username'];
    // } else {
    //     header('location:../auth/login.php');
    // }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan</title>
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="../scripts/bootstrap.min.js"></script>
    <script src="../scripts/jquery.min.js"></script>
</head>
<body>
    <div class="d-flex text-white title-app"><h1>Selamat Datang di Perpustakaan</h1></div>
    <div class="container-fluid h-100 w-100 text-center main-menu">
        <div>
        <a href="user/user.php" class="bg-success text-white p4 ">Anggota</a>
        </div>
        <div>
        <a href="buku/buku.php" class="bg-success text-white p4 ">Daftar Buku</a>
        </div>
        <div>
        <a href="peminjam/peminjam.php" class="bg-success text-white p4 ">Daftar Peminjam</a>
        </div>
        <div>
        <a href="kategori-buku/kategori-buku.php" class="bg-success text-white p4 ">Kategori Buku</a>
        </div>
        <div>
        <form action="../auth/logout.php" method="post">
        <button class="btn btn-dangers">Logout</button>
        </form>
        </div>
    </div>

    <ul>
    <li>
    <a href="user/user.php">User Perpustakaan</a></li>
    <li><a href="buku/buku.php">Buku</a></li>
    <li><a href="kategori-buku/kategori-buku.php">Kategori</a></li>
    <li><a href="peminjam/peminjam.php">Daftar Peminjam</a></li>
    </ul>
    <form action="../auth/logout.php" method="post">
    <button class="btn btn-warning">Logout</button>
    </form>
</body>
</html>