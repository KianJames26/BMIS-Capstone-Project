<?php session_start();session_destroy();?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/default.css">
        <link rel="stylesheet" href="../css/login.css">
        <title>Login to BMIS</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
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
                        <label for="id-num">Admin ID</label>
                        <input type="text" name="admin-id" id="admin-id" placeholder="Enter Admin ID" value="<?= isset($_POST['admin-id']) ? trim($_POST['admin-id']) : ''; ?>" required>
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter Password" required>
                        <input name="Submit" type="submit" value="Login" class="login-btn">
                    </form>
                    <?php
                        if(isset($_POST['Submit'])){
                            include '../BMIS/phpMethods/connection.php';
                            include '../BMIS/phpMethods/log.php';
                            $conn = OpenCon();
                            session_start();
                            $_SESSION['loggedin'] = false;
                            $adminID = trim($_POST['admin-id']);
                            $password = $_POST['password'];
                            
                            $checkIdQuery = "SELECT * FROM admin_accounts WHERE admin_accounts.admin_id = '$adminID'";
                            if(mysqli_num_rows(mysqli_query($conn, $checkIdQuery)) == 0){?>
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Invalid Admin ID'
                                    })
                                </script>
                            <?php }elseif ($result = mysqli_fetch_assoc(mysqli_query($conn, $checkIdQuery))) {
                                $adminPassword = $result['admin_password'];
                                if (password_verify($password, $adminPassword)) {
                                    $adminStatus = $result['admin_status'];
                                    if (!$adminStatus) {?>
                                        <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Account was disabled',
                                            text: 'Your account was disabled by the super admin'
                                        })
                                    </script>
                                    <?php }else{
                                        $adminRole = $result['admin_role'];
                                        $_SESSION['loggedin'] = true;
                                        $_SESSION['role'] = $adminRole;
                                        $_SESSION['username'] = $result['admin_username'];
                                        $_SESSION['admin_id'] = $result['admin_id'];
                                        logNow("Logged in to the system.", $_SESSION['admin_id'], OpenCon());
                                        if ($adminRole == 'elementary') {
                                            header("Location: admin/elementary/admin.php");
                                        }elseif ($adminRole == 'high_school') {
                                            header("Location: admin/highschool/admin.php");
                                        }
                                    }
                                }else{?>
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Invalid Password'
                                        })
                                    </script>
                                <?php }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>