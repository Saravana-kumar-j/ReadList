<?php
    include('database.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <?php
        $username = $_GET['username'];
        echo "<h1>Hello, $username!</h1>";
    ?>
    <form action="welcome.php" method="post">
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
        Book Name: <input type="text" name="book_name" id="book_name"><br>
        Author Name: <input type="text" name="author_name" id="author_name"><br>
        Book Link: <input type="text" name="book_link" id="book_link"><br>
        <input type="submit" value="Add Book" name="add_book" id="add_book">
    </form>
    <form action = "welcome.php" method = "post">
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
        Book_id: <input type="text" name="bookId" id="bookId"><br>
        <input type="submit" value="Delete Book" name="delete_book" id="delete_book"> 
    </form>
</body>
</html>
<?php
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username = $_POST['username'];
        $bookname = $_POST["book_name"];
        $authorname = $_POST["author_name"];
        $booklink = $_POST["book_link"];
        $bookId  = $_POST["bookId"];

        if(isset($_POST['add_book'])){
            if(empty($bookname)){
                echo"Enter a Book Name to Insert.<br>";
            } elseif(empty($authorname)){
                echo"Enter the Author Name.<br>";
            }
            //Query for add book button
            $checkbook = "SELECT * FROM book_list WHERE book_name = '$bookname'";
            $res_checkbook = mysqli_query($conn, $checkbook);
            if(mysqli_num_rows($res_checkbook)>0){
                echo"Book already exists in the list.";
            } else {
                //Insert Book Query
                try{
                    $insertquery = "INSERT INTO book_list(user_name, book_name, author_name, book_link) VALUES ('$username','$bookname','$authorname','$booklink')";
                    mysqli_query($conn, $insertquery);
                    echo"Book is inserted successfully.";
                } catch (mysqli_sql_exception){
                    echo"Book is not Inserted";
                }
            }
        } elseif (isset($_POST['delete_book'])){
            //Query for delete book button
            try{
                $deletequery = "DELETE FROM book_list WHERE book_id = '$bookId'";
                mysqli_query($conn, $deletequery);
                echo"Book is deleted from the table succesfully.";
            } catch (mysqli_sql_exception){
                echo"Book is not Deleted";
            }
        }
    }
    mysqli_close($conn);
?>