<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Profile</title>
    </head>
    <body>
        <h1>Xin chào</h1>
        <?php
        if(isset($_SESSION['username'])){
            echo $_SESSION['username'];
        }
        echo "<br>";
        if(isset($_GET['msg'])){
            echo $_GET['msg'];
        }
        ?>
        <br/>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file">
            <button type="submit" name="submit">Tải ảnh lên</button>
        </form>
        <a href="logout.php">Đăng xuất</a>
    </body>
</html>
