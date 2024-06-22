<?php
// Mulai sesi dan masukkan koneksi database
session_start();
include "../koneksi.php";

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Ambil informasi pengguna
$userID = $_SESSION['id'];
$query = "SELECT nama_lengkap, image FROM user WHERE id='$userID'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);

$nama_lengkap = $row['nama_lengkap'];
$profilePicture = !empty($row['image']) ? "../uploaded_img/" . $row['image'] : "../assets/Default_Profile.png";

// Ambil daftar kategori dari tabel buku
$categoryQuery = "SELECT DISTINCT kategori FROM buku";
$categoryResult = mysqli_query($connect, $categoryQuery);
$categories = [];
while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
    $categories[] = $categoryRow['kategori'];
}

// Pagination settings
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';
$selectedCategory = isset($_GET['category']) ? mysqli_real_escape_string($connect, $_GET['category']) : '';

$bookQuery = "SELECT * FROM buku WHERE judul_buku LIKE '%$search%'";
if (!empty($selectedCategory)) {
    $bookQuery .= " AND kategori='$selectedCategory'";
}
$bookQuery .= " LIMIT $limit OFFSET $offset";
$bookResult = mysqli_query($connect, $bookQuery);

$totalBooksQuery = "SELECT COUNT(*) as total FROM buku WHERE judul_buku LIKE '%$search%'";
if (!empty($selectedCategory)) {
    $totalBooksQuery .= " AND kategori='$selectedCategory'";
}
$totalBooksResult = mysqli_query($connect, $totalBooksQuery);
$totalBooksRow = mysqli_fetch_assoc($totalBooksResult);
$totalBooks = $totalBooksRow['total'];
$totalPages = ceil($totalBooks / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="member.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid d-flex justify-content-center">
                <a class="navbar-brand me-auto" href="profile/index.php">
                    <img src="<?php echo $profilePicture; ?>" alt="" class="profile-picture">
                </a>
                <span class="full-name"><?php echo htmlspecialchars($nama_lengkap); ?></span>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2 active" aria-current="page" href="#">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="save/index.php">Tersimpan</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <form action="../logout/logout.php" method="post">
                    <button class="login-button">Keluar</button>
                </form>
                <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>

<section class="first-section d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="container-fixed-width">
        <div class="input-box">
            <form method="GET" action="" class="mb-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul buku..." value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn search-btn" type="submit">Cari</button>
                </div>
                <div class="dropdown-center mt-3">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Filter Kategori
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?search=<?php echo htmlspecialchars($search); ?>">Semua</a></li>
                        <?php foreach ($categories as $category): ?>
                            <li><a class="dropdown-item" href="?search=<?php echo htmlspecialchars($search); ?>&category=<?php echo urlencode($category); ?>"><?php echo htmlspecialchars($category); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </form>
            <div class="row row-cols-md-1 row-cols-md-2 row-cols-md-3 row-cols-md-4 row-cols-md-5 row-cols-md-6 justify-content-center">
                <?php
                while ($book = mysqli_fetch_assoc($bookResult)) {
                    $imagePath = "../uploaded_img/" . $book['image'];
                ?>
                    <div class="col">
                        <div class="card h-100">
                            <img src="<?php echo $imagePath; ?>" class="card-img-top portrait-img" alt="<?php echo $book['judul_buku']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $book['judul_buku']; ?></h5>
                                <p class="card-text">Penulis: <?php echo $book['penulis']; ?></p>
                                <p class="card-text">Penerbit: <?php echo $book['penerbit']; ?></p>
                                <p class="card-text">Kategori: <?php echo $book['penerbit']; ?></p>
                                <p class="card-text">Tahun Terbit: <?php echo $book['tahun_terbit']; ?></p>
                                <div class="d-flex mt-2">
                                    <?php
                                    $filePath = "../uploaded_file/" . $book['file'];
                                    if (file_exists($filePath)) :
                                    ?>
                                        <a href="read-book.php?file=<?php echo urlencode($book['file']); ?>" class="btn eye-btn" style="margin-right: 10px;" target="_blank"><img src="../assets/eyefill.svg" alt=""></a>
                                    <?php else : ?>
                                        <p class="text-danger">File tidak tersedia</p>
                                    <?php endif; ?>
                                    <?php
                                    $bookSavedQuery = "SELECT * FROM saved_books WHERE user_id='$userID' AND book_id='{$book['id']}'";
                                    $bookSavedResult = mysqli_query($connect, $bookSavedQuery);
                                    $isBookSaved = mysqli_num_rows($bookSavedResult) > 0;

                                    $buttonClass = $isBookSaved ? 'btn bookmark-btn bookmarked' : 'btn bookmark-btn';
                                    $buttonImage = $isBookSaved ? 'bookmark.svg' : 'bookmark1.svg';
                                    ?>
                                    <?php if ($isBookSaved) : ?>
                                        <form action="save/hapus-save-book.php" method="post" class="d-flex">
                                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                            <button type="submit" class="btn bookmark-btn">
                                                <img src="../assets/<?php echo $buttonImage; ?>" alt="Bookmark">
                                            </button>
                                        </form>
                                    <?php else : ?>
                                        <form action="save/save-book.php" method="post" class="d-flex">
                                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                            <button type="submit" class="btn bookmark-btn">
                                                <img src="../assets/<?php echo $buttonImage; ?>" alt="Bookmark">
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1) : ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>&category=<?php echo htmlspecialchars($selectedCategory); ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>&category=<?php echo htmlspecialchars($selectedCategory); ?>"><?php echo $i; ?></a></li>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages) : ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>&category=<?php echo htmlspecialchars($selectedCategory); ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</section>
</body>
</html>