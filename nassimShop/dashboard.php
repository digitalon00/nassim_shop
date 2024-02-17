<?php
    include "connection.php";
    session_start();
    if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    } else {
    $user_id = '';
    }

    if (isset($_POST["addadmin"])) {
        $id=uniq_id();

        $name= $_POST['name'];
        $name = filter_var($name,FILTER_SANITIZE_STRING);

        $username = $_POST['username'];
        $username = filter_var($username,FILTER_SANITIZE_STRING);

        $password= $_POST['password'];
        $password = filter_var($password,FILTER_SANITIZE_STRING);

        $insert_user = $conn -> prepare("INSERT INTO `admins` (id,name,username,password) Values (?,?,?,?)");
        $insert_user->execute([$id,$name,$username,$password]);
    }

    if (isset($_POST["addproduct"])) {

        $id = $_POST['id'];
        $id = filter_var($id,FILTER_SANITIZE_STRING);

        $name= $_POST['name'];
        $name = filter_var($name,FILTER_SANITIZE_STRING);

        $fname= $_POST['fname'];
        $fname = filter_var($fname,FILTER_SANITIZE_STRING);

        $category = $_POST['category'];
        $category = filter_var($category,FILTER_SANITIZE_STRING);

        $price = $_POST['price'];
        $price = filter_var($price,FILTER_SANITIZE_STRING);

        $image= $_POST['image'];
        $image = filter_var($image,FILTER_SANITIZE_STRING);

        $nom= $_POST['nom'];
        $nom = filter_var($nom,FILTER_SANITIZE_STRING);

        $details= $_POST['details'];
        $details = filter_var($details,FILTER_SANITIZE_STRING);

        $evaluations= $_POST['evaluations'];
        $evaluations = filter_var($evaluations,FILTER_SANITIZE_STRING);

        $insert_user = $conn -> prepare("INSERT INTO `products` (id,category,name,fname,price,image,nom,details,evaluations) Values (?,?,?,?,?,?,?,?,?)");
        $insert_user->execute([$id,$category,$name,$fname,$price,$image,$nom,$details,$evaluations]);
    }

    if (isset($_POST["donecommand"])) {
        $id = uniq_id();

        $command_id= $_POST['command_id'];
        $command_id = filter_var($command_id,FILTER_SANITIZE_STRING);

        $select_commands = $conn -> prepare ("SELECT * FROM `commands` WHERE id=?");
        $select_commands ->  execute([$command_id]);
        $fetch_commands = $select_commands->fetch(PDO::FETCH_ASSOC);


        $name= $fetch_commands["name"];

        $phone= $fetch_commands["phone"];

        $adresse= $fetch_commands["adresse"];

        $product_id = $fetch_commands["product_id"];

        $product_price = $fetch_commands["product_price"];


        $insert_user = $conn -> prepare("INSERT INTO `histories` (id,command_id,name,phone,adresse,product_id,product_price) Values (?,?,?,?,?,?,?)");
        $insert_user->execute([$id,$command_id,$name,$phone,$adresse,$product_id,$product_price]);
    }

    if (isset($_POST['deleteadmin'])) {
        $admin_id = $_POST['admin_id'];
        $admin_id = filter_var($admin_id,FILTER_SANITIZE_STRING);
                                        
        $varify_delete_items=$conn->prepare("SELECT * FROM `admins` WHERE id=? ");
        $varify_delete_items->execute([$admin_id]);
                                                    
        if($varify_delete_items->rowCount()>0){
            $delete_admin_id = $conn ->prepare("DELETE FROM `admins` WHERE id=?");
            $delete_admin_id->execute([$admin_id]);
        }
    }

    if (isset($_POST['deleteproduct'])) {
        $product_id = $_POST['product_id'];
        $product_id = filter_var($product_id,FILTER_SANITIZE_STRING);
                                        
        $varify_delete_items=$conn->prepare("SELECT * FROM `products` WHERE id=? ");
        $varify_delete_items->execute([$product_id]);
                                                    
        if($varify_delete_items->rowCount()>0){
            $delete_product_id = $conn ->prepare("DELETE FROM `products` WHERE id=?");
            $delete_product_id->execute([$product_id]);
        }
    }

    if (isset($_POST['deletecommand'])) {
        $command_id = $_POST['command_id'];
        $command_id = filter_var($command_id,FILTER_SANITIZE_STRING);
                                        
        $varify_delete_items=$conn->prepare("SELECT * FROM `commands` WHERE id=? ");
        $varify_delete_items->execute([$command_id]);
                                                    
        if($varify_delete_items->rowCount()>0){
            $delete_command_id = $conn ->prepare("DELETE FROM `commands` WHERE id=?");
            $delete_command_id->execute([$command_id]);
        }
    }

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: dash_login.php');
        exit();
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: dash_login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nassim shop Dashboard</title>
    <link rel="icon" href="imgs/nassim_logo.png" type="image/x-icon">
    <style><?php include "dash_style.css"?></style>
</head>
<body>
    <div class="dashboard">
        <div class="dashboard_container">
            <div class="header">
                <h1>Your Dashboard</h1>
                <h1>Welcome <span><?php echo $_SESSION['admin_name'];?></span></h1>
            </div>
            <div class="content">
                <div class="admins">
                    <h5>admins</h5>
                    <div class="admins_table">
                        <table>
                        <thead>
                            <tr>
                                <th>name</th>
                                <th>username</th>
                                <th>password</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $select_admins = $conn -> prepare ("SELECT * FROM `admins`");
                            $select_admins -> execute();
                            if ($select_admins->rowCount()>0) {
                                while ($fetch_admins = $select_admins->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td><?=$fetch_admins["name"]?></td>
                                <td><?=$fetch_admins["username"]?></td>
                                <td><?=$fetch_admins["password"]?></td>
                                <td><form action="" method="post">
                                    <input type="hidden" name="admin_id" value="<?=$fetch_admins["id"];?>">
                                    <button type="submit" name="deleteadmin" onclick="return confirm('delete this admin ??')">Delete</button>
                                </form></td>
                            </tr>
                        <?php
                                }
                            }
                        ?>
                        </tbody>
                        </table>
                    </div>                 
                    <form action="" method="post" class="form">
                        <h4>Add an admin</h4>
                        <input type="text" placeholder="name" name="name">
                        <input type="text" placeholder="username" name="username">
                        <input type="text" placeholder="password" name="password">
                        <button type="submit" name="addadmin">add admin</button>
                    </form>
                </div>
                <div class="products">
                    <h5>products</h5>
                    <div class="product_table">
                        <table>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>name</th>
                                <th>price</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $select_products = $conn -> prepare ("SELECT * FROM `products`");
                            $select_products -> execute();
                            if ($select_products->rowCount()>0) {
                                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td><?=$fetch_products["id"]?></td>
                                <td><?=$fetch_products["name"]?></td>
                                <td><?=$fetch_products["price"]?>dh</td>
                                <td>
                                <form action="" method="post">
                                    <input type="hidden" name="product_id" value="<?=$fetch_products["id"];?>">
                                    <button type="submit" name="deleteproduct" onclick="return confirm('delete this product ??')">Delete</button>
                                </form>
                                </td>
                            </tr>
                        <?php
                                }
                            }
                        ?>
                        </tbody>
                        </table>
                    </div>
                    <?php
                    $select_id = $conn -> prepare ("SELECT MAX(id) AS max_id FROM `products`");
                    $select_id -> execute ();
                    $fetch_id = $select_id -> fetch(PDO::FETCH_ASSOC);
                    ?>
                    <form action="" method="post" class="form">
                        <h4>Add a product</h4>
                        <input type="text" name="id" value="<?=$fetch_id["max_id"]+1?>" readonly>
                        <input type="text" placeholder="category" name="category">
                        <input type="text" placeholder="name" name="name">
                        <input type="text" placeholder="fname" name="fname">
                        <input type="number" placeholder="price" name="price">
                        <input type="text" placeholder="image" name="image">
                        <input type="text" placeholder="evaluations" name="evaluations">
                        <input type="text" placeholder="nom" name="nom">
                        <textarea placeholder="details" name="details"></textarea>
                        <button type="submit" name="addproduct">add product</button>
                    </form>
                </div>
                <div class="commands">
                    <h5>Commands</h5>
                    <div class="command_table">
                        <table>
                            <thead>
                                <tr>
                                    <th>name</th>
                                    <th>product_id</th>
                                    <th>actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $select_commands = $conn -> prepare ("SELECT * FROM `commands`");
                            $select_commands -> execute();
                            if ($select_commands->rowCount()>0) {
                                while ($fetch_commands = $select_commands->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                                <tr>
                                    <td><?=$fetch_commands["name"]?></td>
                                    <td><?=$fetch_commands["product_id"]?></td>
                                    <td><form action="" method="post">
                                        <input type="hidden" name="command_id" value="<?=$fetch_commands["id"];?>">
                                        <button type="submit" name="deletecommand" onclick="return confirm('delete this command ??')">Delete</button>
                                        <button type="submit" name="donecommand" onclick="return confirm('done command ??')">Done</button>
                                        <a href="command_details.php?pid=<?=$fetch_commands["id"]?>">Details</a>
                                    </form></td>
                                </tr>
                                <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="history">
                        <a href="history.php">commands history</a>
                    </div>
                </div>
            </div>
            <div class="footer">
                <p>powered by &copy Digital<ion-icon name="power"></ion-icon>n</p>
                <form action="" method="post">
                    <button type="submit" name="logout"><ion-icon name="power"></ion-icon>Log out</button>
                </form>
            </div>
        </div>
    </div>
    <script><?php include "script.js"?></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include "alert.php" ?>
</body>
</html>