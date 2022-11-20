<?php

require_once '../vendor/tpl.php';
require_once 'Book.php';

$errors = ['Pealkiri peab olema 2 kuni 10 märki', 'Hinne peab olema määratud'];
$book = new Book('Head First HTML and CSS', 4 , true);

$data = [
    'currentDate' => date('Y'),
    'isEditForm' => true,
    'errors' => $errors,
    'contentPath' => 'form.html'
];

print renderTemplate('tpl/main2.html', $data);





