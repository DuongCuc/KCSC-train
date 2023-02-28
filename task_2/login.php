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
            $username=mysqli_real_escape_string($connect, $_POST['username']);
            $password=mysqli_real_escape_string($connect, $_POST['password']);
            if($username==""||$password==""){
                echo 'Điền đầy đủ thông tin';
            }else{
                $password=md5($password);
                $query="SELECT * FROM  `task1` WHERE `username`=? ";
                $stmt=mysqli_prepare($connect, "SELECT * FROM  `task1` WHERE `username`=? AND `password`=?");
                mysqli_stmt_bind_param($stmt, "ss", $username, $password);
                mysqli_stmt_execute($stmt);
                $result=mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result)!=0){
                    $rows=mysqli_fetch_assoc($result);
                    $_SESSION['id']=$rows['id'];
                    $_SESSION['username']=$rows['username'];
                    $_SESSION['password']=$rows['password'];
                    header('location: index.php');
                }else{
                    echo 'Tên đăng nhập hoặc mật khẩu sai.';
                }
            }
        }
        if(isset($_POST['register'])){
            header('location:register.php');
        }
        ?>
    </body>
</html>
