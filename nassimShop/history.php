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
    <title>nassim shop history</title>
    <link rel="icon" href="imgs/nassim_logo.png" type="image/x-icon">
    <style><?php include "dash_style.css"?></style>
</head>
<body>
    <div class="history_div">
        <div class="history_container">
            <h4>commands delivered</h4>
            <div class="history_table">
                <table>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>command_id</th>
                            <th>name</th>
                            <th>phone</th>
                            <th>adresse</th>
                            <th>product_id</th>
                            <th>product_price</th>
                            <th>date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $select_history = $conn -> prepare("SELECT * FROM `histories` ");
                    $select_history -> execute();
                    if ($select_history->rowCount()>0) {
                        while ($fetch_history = $select_history->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <tr>
                            <td><?=$fetch_history["id"]?></td>
                            <td><?=$fetch_history["command_id"]?></td>
                            <td><?=$fetch_history["name"]?></td>
                            <td><?=$fetch_history["phone"]?></td>
                            <td><?=$fetch_history["adresse"]?></td>
                            <td><?=$fetch_history["product_id"]?></td>
                            <td><?=$fetch_history["product_price"]?></td>
                            <td><?=$fetch_history["date"]?></td>
                        </tr>
                        <?php
                        }
                    }
                        ?>
                    </tbody>
                </table>
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