<?php
include "../koneksi.php";

if (isset($_GET['year'])) {
    $year = $_GET['year'];
    
    $query = "
        SELECT otoritas, COUNT(*) as count 
        FROM user 
        WHERE YEAR(created_at) = '$year'
        GROUP BY otoritas
    ";
    $result = mysqli_query($connect, $query);
    $data = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);
} else {
    echo json_encode([]);
}
?>
