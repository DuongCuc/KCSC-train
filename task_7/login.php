<?php
    session_start()
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Đăng nhập</title>
        <meta charset="utf-8">
    </head>
    <body>
        <form action="login.php" method="POST">
            Tên đăng nhập: <input type="text" name="username">
            </br>
            Mật khấu: <input type="password" name="password">
            </br>
            <input type="submit" class="button" name="login" value="Đăng nhập">
            <input type="submit" name="register" value="Đăng ký">
        </form>
        <?php
        $connect=mysqli_connect("localhost", "root", "", "kcsc");
        if(isset($_POST['login'])){
            $username=($_POST['username']);
            $password=($_POST['password']);
            if($username=="" || $password==""){
                echo'Điền đầy đủ thông tin';
            }else{
                
            }
        }
        ?>
    </body>
</html>