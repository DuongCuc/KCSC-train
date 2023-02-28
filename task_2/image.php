<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Image</title>
</head>
<body>
    <?php 
    session_start();
    $connect=mysqli_connect("localhost","root","","kcsc");
    $id = $_SESSION['id'];
    $sql = "SELECT `image` FROM `upload` WHERE `id`='$id'";
    $query = mysqli_query($connect, $sql);
    while($row = mysqli_fetch_assoc($query)) {
        ?>
        <img src="<?php echo $row['image'] ?>" alt="anh cua toi">
    <?php    
    }
    ?>
</body>
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Image</title>
</head>
<body>
    <?php 
    session_start();
    $connect=mysqli_connect("localhost","root","","kcsc");
    $id = $_SESSION['id'];
    $sql = "SELECT `image` FROM `upload` WHERE `id`='$id'";
    $query = mysqli_query($connect, $sql);
    while($row = mysqli_fetch_assoc($query)) {
        ?>
        <img src="<?php echo $row['image'] ?>" alt="anh cua toi">
    <?php    
    }
    ?>
</body>
>>>>>>> 75d38a7bfd679592cc53d9ec800162156a842400
</html>