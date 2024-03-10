<?php
    include('database.php');

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $username = $_GET['username'];
    
    $sql = "SELECT * FROM book_list WHERE user_name = '$username'";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        echo '<div class="book-list">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="book-item">';
            echo "<span class='label'>Book ID:</span> " . $row['book_id'] . "<br>";
            echo "<span class='label'>Book Name:</span> " . $row['book_name'] . "<br>";
            echo "<span class='label'>Author Name:</span> " . $row['author_name'] . "<br>";
            echo "<span class='label'>Book Link:</span> " . $row['book_link'] . "<br>";
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo "<div class='error-message'>Error Occurred</div>";
    }
    mysqli_close($conn);
?>