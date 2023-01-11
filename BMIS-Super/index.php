<?php 
session_start();session_destroy();
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BMIS-SuperAdmin</title>
        <link href="logincss.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="loginbox">
        <img src="img/logo.png" alt="logo"/>
        <a>BMIS</a>
        </div>
        <center>
            <form action="" method="post">  
            <div class="container"> 
            <a>Welcome! Please enter the 
            username and password to login</a>
            <br><br><br>  
                    <label class="admin">Administrator : </label>   
                    <input type="text" placeholder="Enter Username" 
                    name="username" value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>" required>
                    <br>  
                    <label class="pass">Password : </label>   
                    <input type="password" placeholder="Enter Password" 
                    name="password" required>  
                    <?php
                        if (isset($_POST['login'])) {
                            session_start();
                            $_SESSION['logged'] = false;
                            $username = "super_admin";
                            $password = "super_admin";
                            if (trim($_POST['username']) == $username) {
                                if ($_POST['password'] == $password) {
                                    $_SESSION['logged'] = true;
                                    header("location:super-admin.php?page=user_management");
                                    exit;
                                }else {?>
                                    <h1 class="error">The password you entered is Incorrect.</h1>
                                    <style>
                                        input[name="password"]{
                                            border: 1px solid red !important;
                                        }
                                    </style>
                                <?php }
                            }else {?>
                                <h1 class="error">The username or password you entered is Incorrect.</h1>
                                <style>
                                        input[name="username"]{
                                            border: 1px solid red !important;
                                            
                                        }
                                        input[name="password"]{
                                            border: 1px solid red !important;
                                        }
                                    </style>
                            <?php }
                        }
                    ?>
                    <br>
                    <br>
                    <button type="submit" name="login" value="1">Login</button>       
                </div>   
            </form>     
        </center>
    </body>
</html>
