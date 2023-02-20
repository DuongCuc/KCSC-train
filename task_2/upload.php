<?php
session_start();
$connect=mysqli_connect("localhost","root","","kcsc");
if(isset($_POST['submit'])){
    $file=$_FILES['file'];
    $fileName=$_FILES['file']['name'];
    $fileTmpName=$_FILES['file']['tmp_name'];
    $fileSize=$_FILES['file']['size'];
    $fileError=$_FILES['file']['error'];
    $fileType=$_FILES['file']['type'];

    $fileExt=explode('.', $fileName);
    $fileActualExt=strtolower(end($fileExt));

    $allowed=array('jpg', 'jpeg', 'png', 'pdf');

    if(in_array($fileActualExt, $allowed)){
        if($fileError===0){
            if($fileSize<500000){
                $fileNameNew=uniqid('', true).".".$fileActualExt;
                $fileDestination='uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $id = $_SESSION['id'];
                $sql = "INSERT INTO `upload`(`id`, `image`) VALUES ('$id','$fileDestination')";
                $query = mysqli_query($connect, $sql);
                if($query != 0) {

                    header("location: image.php");
                } else {
                    header("location: index.php/?msg=upload fail");

                }
            }else{
                echo "Kích thước file quá lớn!";
            }
        }else{
            echo "Lỗi!";
        }
    }else{
        echo "Chỉ tải tệp với định dạng .jpg, .jpeg, .png, .pdf";
    }
}
?>