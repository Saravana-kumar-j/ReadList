<?php
    include('database.php');
?>

<!-- HEADER FILE -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            width: 300px;
            max-width: 80%;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .refresh-button {
            margin-top: 10px;
            cursor: pointer;
            background-color: #3498db;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
        }

        .refresh-button:hover {
            background-color: #2980b9;
        }
        
        .book-list {
            margin-top: 20px;
        }

        .book-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .label {
            font-weight: bold;
            color: #333;
        }

        .error-message {
            background-color: #ffcccc;
            padding: 10px;
            border-radius: 8px;
            color: #cc0000;
            margin-top: 10px;
        }

    </style>
</head>
<body>
    <?php
        $username = $_GET['username'];
        echo "<h1>Hello, $username!</h1>";
    ?>
    <form action="welcome.php?username=<?php echo htmlspecialchars($username); ?>" method="post">
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
        Book Name: <input type="text" name="book_name" id="book_name"><br>
        Author Name: <input type="text" name="author_name" id="author_name"><br>
        Book Link: <input type="text" name="book_link" id="book_link"><br>
        <input type="submit" value="Add Book" name="add_book" id="add_book">
    </form>
    <form action="welcome.php?username=<?php echo htmlspecialchars($username); ?>" method="post">
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
        Book ID: <input type="text" name="bookId" id="bookId"><br>
        <input type="submit" value="Delete Book" name="delete_book" id="delete_book"> 
    </form>
    <button class="refresh-button" onclick="refreshBookList()">Refresh Book List</button>
    </form>
    <div id="bookListContainer"></div>
    
    <?php
        $sql = "SELECT * FROM book_list WHERE user_name = '$username'";

        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            // Fetch and display the book list
            while ($row = mysqli_fetch_assoc($result)) {
                echo "Book ID: " . $row['book_id'] . "<br>";
                echo "Book Name: " . $row['book_name'] . "<br>";
                echo "Author Name: " . $row['author_name'] . "<br>";
                echo "Book Link: " . $row['book_link'] . "<br><br>";
            }
        } else {
            echo "Error Occured";
        }
    ?> 

    <script>
        function refreshBookList() {
            // Perform an AJAX request to fetch the updated book list
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    // Update the content of the book list container
                    document.getElementById("bookListContainer").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "get_book_list.php?username=<?php echo htmlspecialchars($username); ?>", true);
            xhttp.send();
        }
    </script>
</body>
</html>

<!-- PHP Code for Backend -->

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
        } else {
            // 
        }
    }
    mysqli_close($conn);
?>