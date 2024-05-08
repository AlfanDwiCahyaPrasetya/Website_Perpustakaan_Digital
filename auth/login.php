<?php
require_once "../config/connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="../scripts/bootstrap.min.js"></script>
    <script src="../scripts/jquery.min.js"></script>
</head>
<body>
<div class="container-fluid login text-white">
  <div class="row justify-content-center">
    <div class="col-sm-6 bg-dark mt-4 pt-4 pl-4 pr-4 pb-4 rounded card-login">
    <div class="h2 text-center mb-4">Login Ke Sistem Perpustakaan</div>
    <form action="proses-login.php" method="post">
    <div class="form-group mb-4">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" aria-describedby="email" placeholder="Enter email" name="email">
        <small id="email" class="form-text text-white">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group mb-4">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-primary">Submit</button>
      <button class="btn btn-danger">Reset</button>
    </div>
    </form>
    </div>
  </div>
</div>
</body>
</html>