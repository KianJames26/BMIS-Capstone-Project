<?php session_start();session_destroy();
    if(isset($_POST['Submit'])){
        session_start();
        $_SESSION['loggedin'] = false;
        $id_num = $_POST['id-num'];
        $password = $_POST['password'];
        if ($id_num == "elem_admin") {
            if($password == "elementary"){
                $_SESSION['login-role'] = "elementary-admin";
                $_SESSION['loggedin'] = true;
                header("location:admin/elementary/admin.php?page=dashboard");
                exit;
            }else {
                $msg="
                <div class='error-message'>
                    <img src='../img/error-logo.png' alt='Error Image'>
                    <p class='message'>Error Invalid Password!</p>
                </div>";
            }
        }else if ($id_num == "hs_admin") {
            if($password == "highschool"){
                $_SESSION['login-role'] = "highschool-admin";
                $_SESSION['loggedin'] = true;
                // header("location:../index.php");
                echo $_SESSION['login-role'] . ' is ' .$_SESSION['loggedin'];
                exit;
            }else {
                $msg="
                <div class='error-message'>
                    <img src='../img/error-logo.png' alt='Error Image'>
                    <p class='message'>Error Invalid Password!</p>
                </div>";
            }
        }else{
            $msg="
            <div class='error-message'>
                <img src='../img/error-logo.png' alt='Error Image'>
                <p class='message'>Error Invalid Id Number!</p>
            </div>";
        }
    }

?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/default.css">
        <link rel="stylesheet" href="../css/login.css">
        <title>Login to BMIS</title>
        <script src="../js/error_message.js"></script>
    </head>
    <body>
        <div class="content">
            <div class="left-column">
                <img src="../img/login.jpg" alt="school_img">
            </div>
            <div class="right-column">
                <div class="right-column-content">
                    <img src="../img/logo.png" alt="BMIS Logo">
                    <h2>Barasoain Memorial Integrated School</h2>
                    <form action="" method="post">
                        <?php if(isset($msg)){?>
                        <?php echo $msg;?>
                        <?php } ?>
                        <label for="id-num">ID number</label>
                        <input type="text" name="id-num" id="id-num" placeholder="Enter ID Number">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter Password">
                        <input name="Submit" type="submit" value="Login" class="login-btn">
                    </form>
                </div>
            </div>
        </div>

        
    </body>
</html>