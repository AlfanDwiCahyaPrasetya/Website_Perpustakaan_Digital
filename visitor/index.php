<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Aplikasi Perpustakaan</title>
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="../scripts/bootstrap.min.js"></script>
    <script src="../scripts/jquery.min.js"></script>
</head>
<body>
    <div class="d-flex text-white title-app"><h1>Selamat Datang di Perpustakaan</h1></div>
    <div class="container-fluid h-100 w-100 text-center main-menu">
        <div>
        <a href="buku-visitor/buku-visitor.php" class="bg-success text-white p4">Lihat Koleksi Buku</a>
        </div>
        <div>
        <a href="profile.php" class="bg-success text-white p4">Profil</a>
        </div>
        <div>
        <form action="../auth/logout.php" method="post">
        <button class="btn btn-dangers">Logout</button>
        </form>
        </div>
    </div>
</body>
</html>