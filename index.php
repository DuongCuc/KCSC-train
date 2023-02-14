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
        echo $_SESSION['username'];
        ?>
        <br/>
        <a href="logout.php">Đăng xuất</a>
    </body>
</html>
