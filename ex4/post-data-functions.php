<?php

include_once __DIR__ . '/Post.php';

const DATA_FILE = __DIR__ . '/data/posts.txt';
const ID_FILE = __DIR__ . '/data/id.txt';

$post = new Post('1000', '45345');


savePost($post);
//print(getLastId());
//deletePostById('7');

function getLastId(): int{

    $ids = file(ID_FILE)[0];
    file_put_contents(ID_FILE, $ids+1);

    return $ids;
}

function getPostAsLine($post): string{
    return urlencode($post->id) . ";" . urlencode($post->title) . ";" . urlencode($post->text) . PHP_EOL;
}

function getAllPosts() : array {

    $lines = file(DATA_FILE);

    $result = [];
    foreach ($lines as $line) {
        [$id, $title, $text] = explode(';', trim($line));

        $post = new Post(urldecode($title), urldecode($text));

        $post->id = $id;

        $result[] = $post;

    }

    return $result;
}


function findByID($id){
    $array = getAllPosts();
    foreach ($array as $post) {
        if ($post->id == $id):
            return True;
        else:
            return False;
        endif;
    }
}

function savePost(Post $post) {
    if ($post->id):
        deletePostById($post->id);
    else:
        $post->id = getLastId();
    endif;

    file_put_contents(DATA_FILE, getPostAsLine($post), FILE_APPEND);

    return $post->id;

}

function deletePostById(string $id) : void {
    $new_file_data = "";

    foreach (getAllPosts() as $post) {
        if ($post->id === $id):
            continue;
        endif;

        $new_file_data .= getPostAsLine($post);
    }

    file_put_contents(DATA_FILE, $new_file_data);
}

function printPosts(array $posts) {
    foreach ($posts as $post) {
        print $post . PHP_EOL;
    }
}
