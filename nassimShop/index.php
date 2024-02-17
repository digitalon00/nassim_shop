<?php
    include "connection.php";
    session_start();
    if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    } else {
    $user_id = '';
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nassim Shop</title>
    <link rel="icon" href="imgs/nassim_logo.png" type="image/x-icon">
    <style><?php include "style.css"?></style>
</head>
<body>
    <?php include "components/header.php" ?>
    <?php include "components/products.php" ?>
    <?php include "components/about.php" ?>
    <?php include "components/footer.php" ?>
    <script><?php include "script.js"?></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include "alert.php" ?>
</body>
</html>

