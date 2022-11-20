<?php

require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/MenuItem.php';

function getMenu() : array {

    $conn = getConnection();

    $stmt = $conn->prepare('SELECT id, parent_id, name 
                            FROM menu_item ORDER BY id');

    $stmt->execute();

    $array = [];
    $result = [];

    foreach ($stmt as $row) {
        $id = $row["id"];
        $parent = $row["parent_id"];
        $name = $row['name'];

        $item = new MenuItem($id, $name);
        $array[$id] = $item;

        if ($parent == null){
            $result[] = $item;
        }else{
            $array[$parent]->addSubItem($item);
        }


    }

    return $result;
}











function printMenu($items, $level = 0) : void {
    $padding = str_repeat(' ', $level * 3);
    foreach ($items as $item) {
        printf("%s%s\n", $padding, $item->name);
        if ($item->subItems) {
            printMenu($item->subItems, $level + 1);
        }
    }
}
