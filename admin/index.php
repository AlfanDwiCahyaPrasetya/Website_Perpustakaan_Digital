<?php
session_start();
include "../koneksi.php";

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../login/login.php"); // Redirect to login page if not logged in
    exit();
}

$userID = $_SESSION['id'];
$query = "SELECT nama_lengkap, image FROM user WHERE id='$userID'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);

$nama_lengkap = $row['nama_lengkap'];
$profilePicture = !empty($row['image']) ? "../uploaded_img/" . $row['image'] : "../assets/Default_Profile.png";

// Fetch distinct years for dropdown
$distinctYearsQuery = "
    SELECT DISTINCT DATE_FORMAT(created_at, '%Y') as year
    FROM user
    ORDER BY year
";
$distinctYearsResult = mysqli_query($connect, $distinctYearsQuery);
$years = [];
while ($row = mysqli_fetch_assoc($distinctYearsResult)) {
    $years[] = $row['year'];
}

// Fetch user counts by year and authority
function fetchUserCountsByYear($connect, $year)
{
    $yearQuery = "
        SELECT otoritas, COUNT(*) as count 
        FROM user 
        WHERE YEAR(created_at) = '$year'
        GROUP BY otoritas
    ";
    $yearResult = mysqli_query($connect, $yearQuery);
    $yearlyData = [];
    while ($row = mysqli_fetch_assoc($yearResult)) {
        $yearlyData[] = $row;
    }
    return $yearlyData;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="admin.css">
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
                                <a class="nav-link mx-lg-2" href="user/index.php">Data Pengguna</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="buku/index.php">Data Buku</a>
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

    <section class="first-section d-flex justify-content-center align-items-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-box">
                        <div class="d-flex">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonYear" data-bs-toggle="dropdown" aria-expanded="false">
                                    Pilih Tahun
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonYear">
                                    <?php foreach ($years as $year) : ?>
                                        <li><a href="#" id="<?php echo $year; ?>" class="dropdown-item year-item"><?php echo $year; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <canvas id="userChart" style="max-height: 500px;"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-box">
                        <!-- <div class="info-box bg-light p-3 mb-3"> -->
                            <h5 class="info-box-title">Admin</h5>
                            <p id="adminCount">Jumlah : 0</p>
                        <!-- </div> -->
                    </div>
                    <div class="input-box">
                        <!-- <div class="info-box bg-light p-3 mb-3"> -->
                            <h5 class="info-box-title">Member</h5>
                            <p id="memberCount">Jumlah : 0</p>
                        <!-- </div> -->
                    </div>
                </div>

            </div>
        </div>
    </section>
    <script>
        const currentYear = new Date().getFullYear().toString(); // Ambil tahun saat ini dalam format string
        const distinctYears = <?php echo json_encode($years); ?>;

        async function fetchData(year) {
            const response = await fetch(`fetch_user_data.php?year=${year}`);
            const data = await response.json();
            return data;
        }

        function updateInfoBoxes(data) {
            const adminCount = data.filter(item => item.otoritas === 'ADMIN').reduce((acc, curr) => acc + curr.count, 0);
            const memberCount = data.filter(item => item.otoritas === 'MEMBER').reduce((acc, curr) => acc + curr.count, 0);

            document.getElementById('adminCount').textContent = `Jumlah: ${adminCount}`;
            document.getElementById('memberCount').textContent = `Jumlah: ${memberCount}`;
        }

        function formatData(data) {
            const admins = data.filter(item => item.otoritas === 'ADMIN');
            const members = data.filter(item => item.otoritas === 'MEMBER');
            const totalAdmins = admins.reduce((acc, curr) => acc + curr.count, 0);
            const totalMembers = members.reduce((acc, curr) => acc + curr.count, 0);

            return {
                labels: ['Admin', 'Member'],
                datasets: [{
                    data: [totalAdmins, totalMembers],
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                    borderWidth: 1
                }]
            };
        }

        var ctx = document.getElementById('userChart').getContext('2d');
        var userChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Admin', 'Member'],
                datasets: [{
                    data: [0, 0],
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            padding: 20 // Tambahkan padding antara label dan chart
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        function updateChart(chart, data) {
            chart.data = formatData(data);
            chart.update();
        }

        // Update the chart with current year data when the page loads
        document.addEventListener('DOMContentLoaded', async () => {
            if (distinctYears.includes(currentYear)) {
                document.getElementById('dropdownMenuButtonYear').innerText = `Tahun ${currentYear}`;
                document.getElementById('dropdownMenuButtonYear').classList.remove('btn-secondary');
                document.getElementById('dropdownMenuButtonYear').classList.add('btn-success');

                const initialData = await fetchData(currentYear);
                updateChart(userChart, initialData);
                updateInfoBoxes(initialData);
            }
        });

        document.querySelectorAll('.year-item').forEach(item => {
            item.addEventListener('click', async event => {
                const year = event.target.textContent;

                // Update the dropdown button text
                document.getElementById('dropdownMenuButtonYear').innerText = `Tahun ${year}`;

                // Update the dropdown button color
                document.getElementById('dropdownMenuButtonYear').classList.remove('btn-secondary');
                document.getElementById('dropdownMenuButtonYear').classList.add('btn-success');

                // Fetch and update the chart with the filtered data
                const filteredData = await fetchData(year);
                updateChart(userChart, filteredData);
                updateInfoBoxes(filteredData);
            });
        });
    </script>
</body>

</html>