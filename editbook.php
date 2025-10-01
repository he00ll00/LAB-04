<?php
require_once "../classes/book.php";
$bookObj = new Book();

$book = [];
$errors = [];
$id = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = trim(htmlspecialchars($_GET["id"]));
        $book = $bookObj->fetchBook($id);

        if (!$book) {
            echo "<a href='viewbook.php'>View Book</a>";
            exit("Book Not Found");
        }
    } else {
        echo "<a href='viewbook.php'>Check Books</a>";
        exit("Book Not Found");
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_GET["id"];

    $book["title"] = trim(htmlspecialchars($_POST["title"]));
    $book["author"] = trim(htmlspecialchars($_POST["author"]));
    $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $book["publication_year"] = trim(htmlspecialchars($_POST["publication_year"]));
    $book["publisher"] = trim(htmlspecialchars($_POST["publisher"]));
    $book["copies"] = trim(htmlspecialchars($_POST["copies"]));

    // Validation
    if (empty($book["title"]))
        $errors["title"] = "Title is required";
    else if ($bookObj->isBookExist($book["title"], $book["author"]) && $book["title"] != $bookObj->fetchBook($id)["title"])
        $errors["title"] = "This book already exists";

    if (empty($book["author"]))
        $errors["author"] = "Author is required";

    if (empty($book["genre"]))
        $errors["genre"] = "Please select a genre";

    if (empty($book["publication_year"]))
        $errors["publication_year"] = "Publication year is required";
    else if (!is_numeric($book["publication_year"]) || strlen($book["publication_year"]) != 4)
        $errors["publication_year"] = "Invalid year format";

    if (empty($book["publisher"]))
        $errors["publisher"] = "Publisher is required";

    if (empty($book["copies"]) && $book["copies"] != 0)
        $errors["copies"] = "Copies is required";
    else if (!is_numeric($book["copies"]) || $book["copies"] <= 0)
        $errors["copies"] = "Copies must be a positive number";

    if (empty(array_filter($errors))) {
        $bookObj->title = $book["title"];
        $bookObj->author = $book["author"];
        $bookObj->genre = $book["genre"];
        $bookObj->publication_year = $book["publication_year"];
        $bookObj->publisher = $book["publisher"];
        $bookObj->copies = $book["copies"];

        if ($bookObj->updateBook($id)) {
            header("Location: viewbook.php");
            exit();
        } else {
            echo "An error occurred while updating.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <style>
        label { display: block; margin-top: 10px; }
        .error { color: red; margin: 0; }
    </style>
</head>
<body>
    <h1>Edit Book</h1>
    <form action="" method="post">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="<?= $book["title"] ?? "" ?>">
        <p class="error"><?= $errors["title"] ?? "" ?></p>

        <label for="author">Author</label>
        <input type="text" name="author" id="author" value="<?= $book["author"] ?? "" ?>">
        <p class="error"><?= $errors["author"] ?? "" ?></p>

        <label for="genre">Genre</label>
        <input type="text" name="genre" id="genre" value="<?= $book["genre"] ?? "" ?>">
        <p class="error"><?= $errors["genre"] ?? "" ?></p>

        <label for="publication_year">Publication Year</label>
        <input type="text" name="publication_year" id="publication_year" value="<?= $book["publication_year"] ?? "" ?>">
        <p class="error"><?= $errors["publication_year"] ?? "" ?></p>

        <label for="publisher">Publisher</label>
        <input type="text" name="publisher" id="publisher" value="<?= $book["publisher"] ?? "" ?>">
        <p class="error"><?= $errors["publisher"] ?? "" ?></p>

        <label for="copies">Copies</label>
        <input type="text" name="copies" id="copies" value="<?= $book["copies"] ?? "" ?>">
        <p class="error"><?= $errors["copies"] ?? "" ?></p>

        <br>
        <input type="submit" value="Save Book Changes">
    </form>
</body>
</html>

