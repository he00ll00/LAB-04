<?php

require_once "../classes/book.php";
$bookObj = new Book();

$book =[];
$errors = [];
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["id"])){
        $pid = trim(htmlspecialchars($_GET["id"]));
        $book = $bookobj->fetchbook($pid);
        if($book){
            echo"<a href ='viewbook.php'>View Booka
         
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    $book["title"] = trim(htmlspecialchars($_POST["title"]));
    $book["author"] = trim(htmlspecialchars($_POST["author"]));
    $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $book["publication_year"] = trim(htmlspecialchars($_POST["publication_year"]));
    $book["publisher"] = trim(htmlspecialchars($_POST["publisher"]));
    $book["copies"] = trim(htmlspecialchars($_POST["copies"]));


    if(empty($book["title"])){
        $errors["title"] = "title is required!";
    } elseif($bookObj->isBookExist($book["name"],$_GET["id"])){
        $errors["title"] = "Book already exists";

    }
     if(empty($book["author"])){
        $errors["author"] = "author is required!";
    }
    
     if(empty($book[le"])e"])){
        $errors["genre"] = "genre is required!";
    }
    
     if(empty($book["publication_year"])){
        $errors["publication_year"] = "Publication year is required";
    } elseif(!is_numeric($book["publication_year"]) || $book["publication_year"] > date("Y")){
        $errors["publication_year"] = "Year must be a valid number not in the future";
    }

     if(empty($book["publisher"])){
        $errors["publisher"] = "publisher is required!";
    }
    
    if(empty($book["copies"])){
        $book["copies"] = 1; 
    } elseif(!is_numeric($book["copies"]) || $book["copies"] < 1){
        $errors["copies"] = "Copies must be at least 1";
    }
    
    

    if(empty(array_filter($errors))){
        $bookObj = new Book();
        $bookObj->title = $book["title"];
        $bookObj->author = $book["author"];
        $bookObj->genre = $book["genre"];
        $bookObj->publication_year = $book["publication_year"];
        $bookObj->publisher = $book["publisher"];
        $bookObj->copies = $book["copies"];

        if($bookObj->editBook($_GET)("id"){
            header("Location: viewBook.php");
    }else{echo "error";
        }
    } 
}
?>
<!DOCTYPE html>
<html lang="en">meta <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
    label {display: block; }
    span{ color: red; }
    p.error{ color: red; margin: 0; }

    body {
        font-family: Arial, sans-serif;
        background: #f5f5f5;
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    form {
        max-width: 500px;
        margin: 20px auto;
        padding: 20px;
        background: white;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0,0,0,0.2);
    }

    label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }

    input, select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    input[type="submit"] {
        margin-top: 15px;
        background: #28a745;
        color: white;
        border: none;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background: #218838;
    }

    .error {
        color: red;
        font-size: 12px;
        margin: 0;
    }

    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        background: white;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: center;
    }

    th {
        background: #007bff;
        color: white;
    }

    button a {
        text-decoration: none;
        color: white;
    }

    button {
        display: block;
        margin: 20px auto;
        background: #007bff;
        padding: 10px 15px;
        border: none;
        border-radius: 3px;
    }

    button:hover {
        background: #0056b3;
    }
    </style>
</head>
<body>
    <h1>ADD BOOK</h1>
    <label>Fields with <span>*</span> are required</label>
    <form action="" method="post">
        <label for="title">Book title <span>*</span></label>
        <input type="text" name ="title" id="title" value="<?php if(isset($book["title"])) { echo $book["title"];}?>">
        <p class="error"><?php if(isset($errors["title"])) echo $errors["title"]; ?></p>
        
        <label for="author">Book author <span>*</span></label>
        <input type="text" name ="author" id="author" value="<?php if(isset($book["author"])) { echo $book["author"];}?>">
        <p class="error"><?php if(isset($errors["author"])) { echo $errors["author"];}?></p>

        <label for="genre">genre <span>*</span></label>
        <select name = "genre" id="genre">
            <option value="">--Select--</option>
            <option value="action" <?=(isset($book["genre"]) && $book["genre"] == "action" )? "selected":""?>>Action</option>
            <option value="science fiction" <?=(isset($book["genre"]) && $book["genre"] == "science fiction" )? "selected":""?>>Science Fiction</option>
            <option value="thriller" <?=(isset($book["genre"]) && $book["genre"] == "thriller" )? "selected":""?>>Thriller</option>
            <option value="comedy" <?=(isset($book["genre"]) && $book["genre"] == "comedy" )? "selected":""?>>Comedy</option>
        </select>
        <p class="error"><?php if(isset($errors["Genre"])) { echo $errors["Genre"];}?></p>

        <label for="">Publication year <span>*</span></label>
        <input type="text" name ="publication_year" id="publication_year" value="<?php if(isset($book["publication_year"])) { echo $book["publication_year"];}?>">
        <p class="error"><?php if(isset($errors["publication_year"])) { echo $errors["publication_year"];}?></p>

        <label for="">Publisher <span>*</span></label>
        <input type="text" name ="publisher" id="publisher" value="<?php if(isset($book["publisher"])) { echo $book["publisher"];}?>">
        <p class="error"><?php if(isset($errors["publisher"])) { echo $errors["publisher"];}?></p>

        <label>Copies</label>
        <input type="text" name="copies" value="<?= $book["copies"] ?? "1" ?>">
        <p class="error"><?php if(isset($errors["copies"])) { echo $errors["copies"];}?></p>

        <br><br>
        <input type="Submit" value="Save Book">
    </form> 
</body>
</html>
