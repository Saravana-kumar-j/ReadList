<?php
    include ("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <h2>Registration form for Book list.</h2>
    Username: <br>
    <input type="text" name="username"><br>
    Password: <br>
    <input type="password" name="password"><br>
    <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>
<?php
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($username)){
            echo"Please enter a Username.";
        } elseif(empty($password)){
            echo"Please enter a Password.";
        } else {
            $sql = "INSERT INTO user (user_name, password) VALUES ('$username','$password')";
            try{
                mysqli_query($conn, $sql);
                echo"You are registered now.";
            }
            catch(mysqli_sql_exception){
                echo"Error Occured.";
            }
        }
    }
    mysqli_close($conn);
?>