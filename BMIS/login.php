<?php session_start();
    if(isset($_POST['Submit'])){
        // Define username and associated password array
        $logins = array('2019115318' => 'admin123');
      // Check and assign submitted user_name and password to new variable
        $id_num = isset($_POST['id-num']) ? $_POST['id-num'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
      // Check user_name and password existence in defined array
        if (isset($logins[$id_num]) && $logins[$id_num] == $password){
        
        // Success: Set session variables and redirect to Protected page
        $_SESSION['UserData']['id-num']=$logins[$id_num];
        header("location:../index.php");
        exit;
        } else {
        
        
        // Unsuccessful attempt: Set error message
        $msg="
            
        
        ";
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

        <div class="error-message">
            <img src="../img/error-logo.png" alt="Error Image">
            <p class="message">Error Invalid Login Details!</p>
        </div>
    </body>
</html>