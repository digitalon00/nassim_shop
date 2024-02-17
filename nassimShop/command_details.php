<?php
    include "connection.php";
    session_start();
    if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    } else {
    $user_id = '';
    }

    if (isset($_GET["pid"])) {
        $pid = $_GET["pid"];

        $select_command = $conn -> prepare("SELECT * FROM `commands` WHERE id='$pid'");
        $select_command ->execute ();
        $fetch_command = $select_command->fetch(PDO::FETCH_ASSOC);
    }

    $select_product = $conn -> prepare("SELECT * FROM `products` WHERE id=?");
    $select_product -> execute ([$fetch_command["product_id"]]);
    $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nassim shop command details</title>
    <link rel="icon" href="imgs/nassim_logo.png" type="image/x-icon">
    <style><?php include "dash_style.css"?></style>
</head>
<body>
    <div class="details_div">
        <div class="details_container">
            <h4>command N° : <?=$fetch_command["id"]?></h4>
            <div class="details">
                <h2>name : <?=$fetch_command["name"]?></h2>
                <h3>phone : <?=$fetch_command["phone"]?></h3>
                <p>adresse : <?=$fetch_command["adresse"]?></p>
                <div class="details_prodcuts">
                    <h2>product :</h2>
                    <p>id : <?=$fetch_command["product_id"]?></p>
                    <p>name : <?=$fetch_product["name"]?></p>
                    <p>price : <?=$fetch_product["price"]?></p>
                </div>
            </div>
            <a onclick="goBack()"><span class="back"><ion-icon name="arrow-back-outline"></ion-icon>Back</span></a>
        </div>
    </div>
    <script><?php include "script.js"?></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include "alert.php" ?>
</body>
</html>