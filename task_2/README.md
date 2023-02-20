
# Fix Task 1 (SQL injection)
###### Task 1
```php
if(isset($_POST['login'])){
            $username=$_POST['username'];
            $password=$_POST['password'];
            if($username==""||$password==""){
                echo 'Điền đầy đủ thông tin';
            }else{
                $password=md5($password);
                $query= mysqli_query($connect, "SELECT * FROM `task1` WHERE username='$username'AND password='$password'");
                if(mysqli_num_rows($query)!=0){
                    $rows=mysqli_fetch_assoc($query);
                    $_SESSION['id']=$rows['id'];
                    $_SESSION['username']=$rows['username'];
                    $_SESSION['password']=$rows['password'];
                    header('location: index.php');
                }else{
                    echo 'Tên đăng nhập hoặc mật khẩu sai.';
                }
            }
        }
```

###### Task 2
```php
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
```

# Đăng ký
![](https://i.imgur.com/uCTcTRk.png)

![](https://i.imgur.com/6cYs5Pi.png)

![](https://i.imgur.com/ojAidfT.png)

![](https://i.imgur.com/rTibOcp.png)

![](https://i.imgur.com/WDdz8H0.png)

# Đăng nhập
![](https://i.imgur.com/5KSVRAi.png)

![](https://i.imgur.com/TtLqVb0.png)

![](https://i.imgur.com/5RO6K0t.png)

![](https://i.imgur.com/j8wbVGw.png)

# Upload ảnh
![](https://i.imgur.com/yi8wIPd.png)

![](https://i.imgur.com/QucSD3q.png)

![](https://i.imgur.com/P35vKri.jpg)




