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
    <form action="index.php" method="POST">
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
    if ($_SERVER["REQUEST_METHOD"]== "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if(empty($username)){
            echo"Please enter a Username.";
        } elseif(empty($password)){
            echo"Please enter a Password.";
        } else {
            $checkuser = "SELECT * FROM user WHERE user_name = '$username'";
            try{
                $res_checkuser = mysqli_query($conn, $checkuser);
                if(mysqli_num_rows($res_checkuser) > 0){
                    echo"User already exists. Please try another username.";
                } else {
                    $insertquery = "INSERT INTO user (user_name, password) VALUES ('$username','$password')";
                    mysqli_query($conn, $insertquery);
                    echo"You'Registered succesfully.<br>";
                    echo"<a href='login.php'>Click here to Login.</a>";
                }
            }
            catch(mysqli_sql_exception){
                echo"Error Occured.";
            }
        }
    }
    mysqli_close($conn);
?>