<?php session_start();
    if(isset($_POST['Submit'])){
        // Define username and associated password array
        $logins = array('Nick' => '123456', 'Stanley' => 'admin', 'administrator' => 'admin1234');
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
        $msg="<span style='color:red'>Invalid Login Details</span>";
        }
        }

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                        <tr>
                        <td colspan="3" align="center" valign="top"><?php echo $msg;?></td>
                        </tr>
                        <?php } ?>
                        <input type="text" name="id-num" id="id-num" placeholder="Enter ID Number">
                        <input type="password" name="password" id="password" placeholder="Enter Password">
                        <input name="Submit" type="submit" value="Login" class="login-btn">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>