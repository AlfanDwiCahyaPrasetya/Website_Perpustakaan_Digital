<?php 
            include "../../config/connection.php";

            $buku = mysqli_query($connect, "SELECT * FROM tb_buku");
            $options = '';
            while($list = mysqli_fetch_assoc($buku)) {
                $options .= '<option value = "'.$list['id'].'">'.$list['judul'].'</option>';   
            }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/bootstrap.min.css">
    <link rel="stylesheet" href="../../styles/styles.css">
    <script src="../../scripts/bootstrap.min.js"></script>
    <script src="../../scripts/jquery.min.js"></script>
</head>
<body>
    <div class="container-fluid bg-primary text-white p-3 text-center d-flex  justify-content-center fixed-top main-book">
                <div class="title"><h1>Pinjam Buku</h1></div>
            </div>
            <div class="container main-book">
                <ul class="nav nav-pills mt-4">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="../pinjam/pinjam.php">Pinjam Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../data-peminjam/peminjam.php">Riwayat Pinjaman</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../buku-visitor/buku-visitor.php">Kembali</a>
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
    <form action="proses-pinjam.php" method="post">
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Judul Buku</label>
    <select name="judul" id="" class="form-control">
        <?php echo $options; ?>
    </select>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Tanggal Pinjam</label>
        <input type="date" class="form-control" id="exampleInputPassword1" name="tgl_pinjam">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword2" class="form-label">Tanggal Kembali</label>
        <input type="date" class="form-control" id="exampleInputPassword2" name="tgl_kembali">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Status Buku</label>
        <select name="status" class="form-control">
        <option value="0">Pilih status</option>
        <option value="1">Tersedia</option>
        <option value="2">Tidak Tersedia</option>
        <option value="3">Dipinjam</option>
        <option value="4">Selesai</option>
        </select>
    </div>
    <div class="d-grid gap-2">
    <input type="submit" class="btn btn-primary btn-block" value="Simpan">
    </div>
    </form>
    </div>
</body>
</html>