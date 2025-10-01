<?php
require_once "database.php";

class Book extends Database {
    public $id = "";
    public $title = "";
    public $author = "";
    public $genre = "";
    public $publication_year = "";
    public $publisher = "";
    public $copies = 1;


    public function addBook() {
        $sql = "INSERT INTO book (title, author, genre, publication_year, publisher, copies)
                VALUES (:title, :author, :genre, :publication_year, :publisher, :copies)";
        $query = $this->connect()->prepare($sql);

        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);
        $query->bindParam(":publisher", $this->publisher);
        $query->bindParam(":copies", $this->copies);
        $query->bindParam(":id", $id);
        return $query->execute();
    }

    
    public function viewBooks($search="", $genre="") {
        $sql = "SELECT * FROM book 
                WHERE title LIKE CONCAT('%', :search, '%') 
                AND genre LIKE CONCAT('%', :genre, '%') 
                ORDER BY title ASC";
        $query = $this->connect()->prepare($sql);

        $query->bindParam(":search", $search);
        $query->bindParam(":genre", $genre);

        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    // Check duplicate title
    public function isBookExist($title){
        $sql = "SELECT COUNT(*) as total FROM book WHERE title = :title";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":title", $title);
        $record = null;

        if ($query->execute()) {
            $record = $query->fetch();
        }

        return ($record["total"] > 0);
    }
    public function fetchBook($id) {
    $sql = "SELECT * FROM book WHERE id = :id LIMIT 1";
    $query = $this->connect()->prepare($sql);
    $query->bindParam(":id", $id);
    $query->execute();
    return $query->fetch();
    }

    public function deleteBook($id) {
    $sql = "DELETE FROM book WHERE id = :id";
    $query = $this->connect()->prepare($sql);
    $query->bindParam(":id", $id);
    return $query->execute();
    }
    public function updateBook($id) {
        $sql = "UPDATE book 
                SET title = :title, author = :author, genre = :genre, 
                    publication_year = :publication_year, publisher = :publisher, copies = :copies
                WHERE id = :id";
        $query = $this->connect()->prepare($sql);

        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);
        $query->bindParam(":publisher", $this->publisher);
        $query->bindParam(":copies", $this->copies);
        $query->bindParam(":id", $id);

        return $query->execute();
    }
}

