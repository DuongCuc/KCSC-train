<<<<<<< HEAD
<?php
    session_start()
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Đăng ký</title>
        <meta charset="utf-8">
    </head>
    <body>
        <form action="register.php" method="POST">
            Tên đăng nhập: <input type="text" name="username">
            <br/>
            Mật khẩu: <input type="password" name="password">
            <br/>
            Nhập lại mật khẩu: <input type="password" name="repassword">
            <br/>
            <input type="submit" class="button" name="register" value="Đăng ký">
            <input type="submit" class="button" name="login" value="Đăng nhập">
        </form>
        <?php
            $connect=mysqli_connect("localhost","root","","kcsc");
            if(isset($_POST['register'])){
                if($_POST['username']!='' && $_POST['password']!='' && $_POST['repassword']!=''){
                    $username=mysqli_real_escape_string($connect, $_POST['username']);
                    $password=mysqli_real_escape_string($connect, $_POST['password']);
                    $repassword=$_POST['repassword'];
                    $query= mysqli_query($connect, "SELECT * FROM `task1` WHERE `username`='$username'");
                    if(mysqli_num_rows($query)!=0){
                        echo 'Tên đăng nhập đã tồn tại.';
                    }else{
                        if($password!=$repassword){
                            echo 'Mật khẩu không trùng khớp.';
                        }else{
                            $password=md5($password);
                            $sql="INSERT INTO `task1` (id, username, password)
                                    VALUES (NULL, '$username', '$password')";
                            $query=mysqli_query($connect,$sql);
                            if($query!=0){
                                echo 'Đăng ký thành công.';
                            }
                        }
                    }
                }else{
                    echo 'Điền đầy đủ thông tin.';
                }
            }
            if(isset($_POST['login'])){
                header('location:login.php');
            }
        ?>
    </body>
=======
<?php
    session_start()
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Đăng ký</title>
        <meta charset="utf-8">
    </head>
    <body>
        <form action="register.php" method="POST">
            Tên đăng nhập: <input type="text" name="username">
            <br/>
            Mật khẩu: <input type="password" name="password">
            <br/>
            Nhập lại mật khẩu: <input type="password" name="repassword">
            <br/>
            <input type="submit" class="button" name="register" value="Đăng ký">
            <input type="submit" class="button" name="login" value="Đăng nhập">
        </form>
        <?php
            $connect=mysqli_connect("localhost","root","","kcsc");
            if(isset($_POST['register'])){
                if($_POST['username']!='' && $_POST['password']!='' && $_POST['repassword']!=''){
                    $username=mysqli_real_escape_string($connect, $_POST['username']);
                    $password=mysqli_real_escape_string($connect, $_POST['password']);
                    $repassword=$_POST['repassword'];
                    $query= mysqli_query($connect, "SELECT * FROM `task1` WHERE `username`='$username'");
                    if(mysqli_num_rows($query)!=0){
                        echo 'Tên đăng nhập đã tồn tại.';
                    }else{
                        if($password!=$repassword){
                            echo 'Mật khẩu không trùng khớp.';
                        }else{
                            $password=md5($password);
                            $sql="INSERT INTO `task1` (id, username, password)
                                    VALUES (NULL, '$username', '$password')";
                            $query=mysqli_query($connect,$sql);
                            if($query!=0){
                                echo 'Đăng ký thành công.';
                            }
                        }
                    }
                }else{
                    echo 'Điền đầy đủ thông tin.';
                }
            }
            if(isset($_POST['login'])){
                header('location:login.php');
            }
        ?>
    </body>
>>>>>>> 75d38a7bfd679592cc53d9ec800162156a842400
</html>