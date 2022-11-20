<?php

include_once __DIR__ . '/Post.php';

const DATA_FILE = __DIR__ . '/data/posts.txt';

printPosts(getAllPosts());

savePost(new Post('Html', "some text about html.'\n;"));

function getAllPosts() : array {

    $new_arr = [];
    $data = file(DATA_FILE);


    foreach ($data as $row){
//        $exploded = explode(";", trim($row));
//        $title = $exploded[0];
//        $data = $exploded[1];
//        $post = new Post($title, $data);
//
        [$title, $text] = explode(";", trim($row));
        $new_arr[] = new Post($title, urldecode($text));
//        array_push($new_arr, $post);
    }

    return $new_arr;
}

function savePost(Post $post) : void {
//    $title = trim($post->title);
//    $data = trim($post->text);
    $line = $post->title . ";" . urlencode($post->text) . PHP_EOL;

    file_put_contents(DATA_FILE, $line , FILE_APPEND); # lock file after write

}

function printPosts(array $posts) {
    foreach ($posts as $post) {
        print $post . PHP_EOL;
    }
}