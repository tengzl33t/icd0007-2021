<?php
include_once __DIR__ . '/classes/DTO.php';
include_once __DIR__ . '/vendor/tpl.php';
include_once __DIR__ . '/vendor/Request.php';

$dto = new DTO();

$request = new Request($_REQUEST);
$cmd = $request->param('cmd');

if($cmd === 'show_book_form'){

    $authors = $dto->getAuthors();

    $title = $_POST['title'] ?? '';
    $author1_id = $_POST["author1"] ?? 0;
    $author2_id = $_POST["author2"] ?? 0;
    $mark = $_POST['grade'] ?? 0;
    $read = $_POST['isRead'] ?? 0;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $book = new Book(urlencode($title), intval($mark), intval($read));
        if (strlen($title) < 3 or strlen($title) > 23) {
            $error = "Pealkiri peab olema rohkem kui 3 tähte ja vähem kui 23";
        }
        if (empty($error)) {
            $dto->addBook($book, [intval($author2_id), intval($author1_id)]);
            header("Location: /?cmd=show_book_list&saved=1");
            exit;
        }
    }

    $data = [
        'authors' => $authors,
        'book' => $book,
        'read' => $read,
        'title' => $title,
        'mark' => $mark,
        'error' => $error,
        'pageID' => 'book-form-page',
        'contentPath' => 'book-add.html'
    ];
    print renderTemplate('tpl/main.html', $data);

}else if($cmd === 'show_author_list'){

    $authors = $dto->getAuthors();
    $data = [
        'authors' => $authors,
        'saved' => $_GET['saved'],
        'deleted' => $_GET['deleted'],
        'pageID' => 'author-list-page',
        'contentPath' => 'author-list.html'
    ];
    print renderTemplate('tpl/main.html', $data);

}else if($cmd === 'show_author_form'){

    $first_name = $_POST['firstName'] ?? '';
    $last_name = $_POST['lastName'] ?? '';
    $mark = $_POST['grade'] ?? 0;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $author = new Author(urlencode($first_name), urlencode($last_name), intval($mark));
        if ((strlen($first_name) < 1 or strlen($first_name) > 21) or (strlen($last_name) < 2 or strlen($last_name) > 22)) {
            $error = "Not right firstname or lastname length!";
        }
        if (empty($error)) {

            $dto->addAuthor($author);
            header("Location: /?cmd=show_author_list&saved=1");
            exit;
        }
    }

    $data = [
        'firstName' => $first_name,
        'lastName' => $last_name,
        'mark' => $mark,
        'author' => $author,
        'error' => $error,
        'pageID' => 'author-form-page',
        'contentPath' => 'author-add.html'
    ];
    print renderTemplate('tpl/main.html', $data);

}else if($cmd === 'show_book_edit'){

    $book = $dto->getBookById($_GET['id']);
    $authors = $dto->getAuthors();

    $author1_id = $_POST["author1"] ?? $book->authors_ids[0];
    $author1 = $dto->getAuthorById($author1_id);

    #TODO: fix for empty author 2, now gives warning in console.

    $author2_id = $_POST["author2"] ?? $book->authors_ids[1];
    $author2 = $dto->getAuthorById($author2_id);

    $title = $_POST['title'] ?? urldecode($book->title);
    $mark = $_POST['grade'] ?? $book->mark;
    $read = $_POST['isRead'] ?? $book->read;

    if (isset($_POST["deleteButton"])) {
        $dto->removeBook($book->id);
        header("Location: /?cmd=show_book_list&deleted=1");
    } elseif (isset($_POST["submitButton"])) {

        if (!isset($_POST['isRead'])) {
            $read = 0;
        } else {
            $read = 1;
        }

        $edited_book = new Book(urlencode($title), intval($mark), $read);
        $edited_book->id = $book->id;
        $dto->editBook($edited_book, [intval($author2_id), intval($author1_id)]);

        header("Location: /?cmd=show_book_list&saved=1");
    }

    $data = [
        'author1' => $author1,
        'author2' => $author2,
        'authors' => $authors,
        'book' => $book,
        'title' => $title,
        'read' => $read,
        'pageID' => 'book-edit-page',
        'contentPath' => 'book-edit.html'
    ];
    print renderTemplate('tpl/main.html', $data);

}else if($cmd === 'show_author_edit'){

    $author = $dto->getAuthorById($_GET['id']);

    $first_name = $_POST['firstName'] ?? urldecode($author->first_name);
    $last_name = $_POST['lastName'] ?? urldecode($author->last_name);
    $mark = $_POST['grade'] ?? $author->mark;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if (isset($_POST["deleteButton"])) {
            $dto->removeAuthor($author->id);
            header("Location: /?cmd=show_author_list&deleted=1");
        } elseif (isset($_POST["submitButton"])) {
            $edited_author = new Author(urlencode($first_name), urlencode($last_name), intval($mark));
            $edited_author->id = $author->id;
            $dto->editAuthor($edited_author);
            header("Location: /?cmd=show_author_list&saved=1");
        }
    }

    $data = [
        'firstName' => $first_name,
        'lastName' => $last_name,
        'author' => $author,
        'mark' => $mark,
        'pageID' => 'author-edit-page',
        'contentPath' => 'author-edit.html'
    ];
    print renderTemplate('tpl/main.html', $data);

}else{

    $books = $dto->getBooks();
    $data = [
        'books' => $books,
        'saved' => $_GET['saved'],
        'deleted' => $_GET['deleted'],
        'pageID' => 'book-list-page',
        'contentPath' => 'book-list.html'
    ];
    print renderTemplate('tpl/main.html', $data);

}