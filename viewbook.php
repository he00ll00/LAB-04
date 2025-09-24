<?php
require_once "../classes/book.php";
$bookObj = new Book();

if($_SERVER["REQUEST_METHOD"] == "GET"){
$search = isset($_GET["search"])? trim(htmlspecialchars($_GET["search"])) : "";
$genre = isset($_GET["genre"])? trim(htmlspecialchars($_GET["genre"])) : "";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Books</title>
</head>
<style>
    table {
  width: 80%;
  margin: 20px auto;
  border-collapse: collapse;
  background-color: #fff;  
}

th, td {
  border: 1px solid #000000ff;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #8dadf3ff;  
  color: #333;
}
</style>
<body>
    <h1>View Books</h1>
    <form method="get">
        <label for="">Search:</label>
        <input type="search" name="search" placeholder="Search by title" value="<?= $search ?>">
        <select name="genre">
            <option value="">All Genres</option>
            <option value="Action" <?= ($genre=="Action")?"selected":"" ?>>Action</option>
            <option value="Science Fiction" <?= ($genre=="Science Fiction")?"selected":"" ?>>Science Fiction</option>
            <option value="Comedy" <?= ($genre=="Comedy")?"selected":"" ?>>Comedy</option>
            <option value="Thriller" <?= ($genre=="Thriller")?"selected":"" ?>>Thriller</option>
        </select>
        <input type="submit" value="Search">
    </form>
    <button><a href="addbook.php">Add Book</a></button>

    <table border="1">
        <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Year</th>
            <th>Publisher</th>
            <th>Copies</th>
        </tr>
        <?php
        $no = 1;
        foreach($bookObj->viewBooks($search, $genre) as $book){
            echo "<tr>
                    <td>".$no++."</td>
                    <td>".$book["title"]."</td>
                    <td>".$book["author"]."</td>
                    <td>".$book["genre"]."</td>
                    <td>".$book["publication_year"]."</td>
                    <td>".$book["publisher"]."</td>
                    <td>".$book["copies"]."</td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
