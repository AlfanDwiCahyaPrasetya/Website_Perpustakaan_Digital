<?php

include '../../config/connection.php';

$ID = $_GET['id'];
mysqli_query($connect, "DELETE FROM tb_user WHERE id='$ID'");

header("location: user.php");

?>