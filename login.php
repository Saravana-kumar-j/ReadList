<?php
    include("database.php");
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $sql = "SELECT * FROM user WHERE user_name = '$username' AND password = '$password'";
            
            try{
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result)>0){
                    while($row = mysqli_fetch_assoc($result)){
                        header("Location: welcome.php?username=" . $username);
                        exit();
                    };
                } else {
                    echo"Your Data Doen't exists. Please <a href='register.html'>Register Here</a> before login.";
                }
            }
            catch(mysqli_sql_exception){
                echo"Error Occured.";
            }
    }
    mysqli_close($conn);
?>