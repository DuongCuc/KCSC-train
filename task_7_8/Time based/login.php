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
            <br/>
            Mật khẩu: <input type="password" name="password">
            <br/>
            <input type="submit" class="button" name="login" value="Đăng nhập">
            <input type="submit" class="button" name="register" value="Đăng ký">
        </form>
        <?php
        $connect=mysqli_connect("localhost","root","","kcsc");
        if(isset($_POST['login'])){
            $username=$_POST['username'];
            $password=$_POST['password'];
            if($username==""||$password==""){
                echo 'Điền đầy đủ thông tin';
            }else{
                $password=md5($password);
                $query= mysqli_query($connect, "SELECT * FROM `task7` WHERE username='$username'AND password='$password'");
                $rows=mysqli_fetch_assoc($query);
                if($rows!=0){
                    echo 'Cuckooo...';
                    $_SESSION['id']=$rows['id'];
                    $_SESSION['username']=$rows['username'];
                    $_SESSION['password']=$rows['password'];
                }else{
                    echo 'Cuckooo...';
                }
            }
        }
        if(isset($_POST['register'])){
            header('location:register.php');
        }
        ?>
    </body>
</html>