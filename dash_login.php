<?php 
    include 'connection.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    }else{
    $user_id='';
    }

    if (isset($_POST['login'])) {

        $username = $_POST['username'];
        $username = filter_var($username,FILTER_SANITIZE_STRING);
    
        $pass = $_POST['pass'];
        $pass = filter_var($pass,FILTER_SANITIZE_STRING);
    
        $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE username = ? AND password = ?");
        $select_admin->execute([$username , $pass]);
        $row = $select_admin->fetch(PDO::FETCH_ASSOC);
    
        if ($select_admin->rowCount()>0) {
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['admin_name']=$row['name'];
            $_SESSION['admin_role']=$row['role'];
            header('Location: nassim_dash');
            exit();
        }
        else{
            $warning_msg[]='incorrect username or password';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion to dashboard</title>
    <link rel="icon" href="imgs/logo/ico2.ico" type="image/x-icon">
    <style>
        <?php include "dash_style.css" ?>
    </style>
</head>
<body>
    <section class="dash_login">
        <div class="dash_login_container">
            <h3>Login</h3>
            <p>Welcome Admin</p>
            <form action="" method="post">
                <input type="text" name="username" placeholder="username" required maxlength="15">
                <input type="password"  name="pass" placeholder="password" required maxlength="20">
                <button type="submit" name="login">Login</button>
            </form>
            <a href="index"><ion-icon name="close"></ion-icon></a>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script><?php include "script.js"?></script>
    <?php include "alert.php"?> 
</body>
</html>