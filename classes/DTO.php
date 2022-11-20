<?php
include_once __DIR__ . '/Author.php';
include_once __DIR__ . '/Book.php';
include_once __DIR__ . '/MySQL.php';

class DTO
{

    private function SQLConnection(): PDO
    {
        $conn = new MySQL();
        return $conn->sql_connection;
    }

    private function SQLQuery($queries, $sqlConnection): array
    {
        foreach ($queries as $query) {
            $sqlGet = $sqlConnection->prepare($query);
            $sqlGet->execute();
        }

        $lastInsertId = $sqlConnection->lastInsertId();
        return [$sqlGet, $lastInsertId];
        # 0 - return query output, 1 - return inserted object id
    }

    public function getAuthors(): array
    {
        $authors_array = [];

        $query = ['SELECT id, firstname, lastname, IFNULL(mark,0) as mark FROM authors'];
        $sqlGet = $this->SQLQuery($query, $this->SQLConnection())[0];

        foreach ($sqlGet as $line) {
            $author = new Author(urldecode($line["firstname"]), urldecode($line["lastname"]), $line["mark"]);
            $author->id = $line["id"];
            $authors_array[] = $author;

        }
        return $authors_array;
    }


    public function getBooks(): array
    {
        $books_array = [];

        $query = ["
    	SELECT id, title, mark, isread, GROUP_CONCAT(auth) AS authors, GROUP_CONCAT(auth_id) AS authors_ids
            FROM (
            SELECT books.id as id, books.title as title, books.mark as mark, books.isread as isread, 
            CONCAT(authors.firstname, ' ', authors.lastname) as auth, CONCAT(authors.id) as auth_id
            FROM books 
            LEFT JOIN book_author as booksAuthors
            ON books.id = booksAuthors.book_id
            LEFT JOIN authors
            ON booksAuthors.author_id = authors.id
            ) as book_all
            GROUP BY id;
    "];

        $sqlGet = $this->SQLQuery($query, $this->SQLConnection())[0];

        foreach ($sqlGet as $line) {
            $book = new Book(urldecode($line["title"]), $line["mark"], $line["isread"]);
            $book->id = $line["id"];
            $book->authors = explode(",", urldecode($line["authors"]));
            $book->authors_ids = explode(",", $line["authors_ids"]);

            $books_array[] = $book;
        }

        return $books_array;
    }


    public function addBook(Book $book, $authors_ids)
    {
        $SQLConn = $this->SQLConnection();

        $queries = ["INSERT INTO books (title, mark, isread) VALUES ('$book->title', '$book->mark', $book->read)"];

        $book_id = $this->SQLQuery($queries, $SQLConn)[1];

        $queries = [];
        foreach ($authors_ids as $author_id) {
            array_push($queries, "INSERT INTO book_author (book_id, author_id) VALUES ('$book_id', '$author_id')");
        }

        $this->SQLQuery($queries, $SQLConn);
    }

    public function addAuthor(Author $author)
    {
        $queries = ["INSERT INTO authors (firstname, lastname, mark) VALUES ('$author->first_name', '$author->last_name', $author->mark)"];
        $this->SQLQuery($queries, $this->SQLConnection());
    }

    public function getBookById($search_id)
    {
        $books_array = $this->getBooks();

        foreach ($books_array as $book) {
            if ($book->id == $search_id):
                return $book;
            endif;
        }
        return null;
    }

    public function getAuthorById($search_id)
    {
        $authors_array = $this->getAuthors();

        foreach ($authors_array as $author) {
            if ($author->id == $search_id):
                return $author;
            endif;
        }
        return null;
    }

    public function editBook(Book $book, $authors_ids)
    {

        $queries = [
            "UPDATE books SET title='$book->title', mark='$book->mark', isread='$book->read' WHERE id='$book->id'",
            "DELETE FROM book_author WHERE book_id='$book->id'"
        ];

        foreach ($authors_ids as $author_id) {
            array_push($queries, "INSERT INTO book_author (book_id, author_id) VALUES ('$book->id', '$author_id')");
        }

        $this->SQLQuery($queries, $this->SQLConnection());
    }

    public function editAuthor(Author $author)
    {
        $queries = ["UPDATE authors SET firstname='$author->first_name', lastname='$author->last_name', mark='$author->mark' WHERE id='$author->id'"];
        $this->SQLQuery($queries, $this->SQLConnection());
    }

    public function removeBook($search_id)
    {
        $queries = [
            "DELETE FROM books WHERE id='$search_id'",
            "DELETE FROM book_author WHERE book_id='$search_id'"
        ];
        $this->SQLQuery($queries, $this->SQLConnection());
    }

    public function removeAuthor($search_id)
    {
        $queries = ["DELETE FROM authors WHERE id='$search_id'", "DELETE FROM book_author WHERE author_id='$search_id'"];
        $this->SQLQuery($queries, $this->SQLConnection());
    }
}
