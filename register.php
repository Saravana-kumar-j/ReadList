<?php
    include ("database.php");
    if ($_SERVER["REQUEST_METHOD"]== "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        
        $checkuser = "SELECT * FROM user WHERE user_name = '$username'";
            try{
                $res_checkuser = mysqli_query($conn, $checkuser);
                if(mysqli_num_rows($res_checkuser) > 0){
                    echo"User already exists. Please try another username.";
                } else {
                    $insertquery = "INSERT INTO user (user_name, email, password) VALUES ('$username','$email','$password')";
                    mysqli_query($conn, $insertquery);
                    echo"You'Registered succesfully.<br>";
                    echo"<a href='index.html'>Click here to Login.</a>";
                }
            }
            catch(mysqli_sql_exception){
                echo"Error Occured.";
            }
    }
    mysqli_close($conn);
?>