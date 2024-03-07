<?php
    include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <form action="login.php" method="post">
    <h2>Login Page</h2>
    Username: <br>
    <input type="text" name="username"><br>
    Password: <br>
    <input type="password" name="password"><br>
    <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>
<?php
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    if(empty($username)){
        echo"Please enter a Username.";
    } elseif(empty($password)){
        echo"Please enter a Password.";
    } else {
        $sql = "SELECT * FROM user WHERE user_name = '$username'";
        
        try{
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result)>0){
                while($row =mysqli_fetch_assoc($result)){
                    header("Location: welcome.php?username=" . $username);
                    exit();
                };
            } else {
                echo"Your Data Doen't exists. Please Register before login.";
            }
        }
        catch(mysqli_sql_exception){
            echo"Error Occured.";
        }
    }
    mysqli_close($conn);
?>