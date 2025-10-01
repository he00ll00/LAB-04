<?php

require_once "../classes/book.php";
$bookObj = new Book();


$book = [];
$errors = [];
$id = "";

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        if (isset($_GET["id"]))
        {
            $id = trim(htmlspecialchars($_GET["id"]));
            $book = $bookObj->fetchbook($id);

            if (!$book)
            {
                echo "<a href='viewbook.php'>View Book</a>";
                exit("book Not Found");
            }
            else
            {
                $bookObj->deleteBook($id);
                header("Location: viewbook.php");
            }
        }
        else
        {
            echo "<a href='viewbook.php'>View book</a>";
            exit("book Not Found");
        }
    }

?>
