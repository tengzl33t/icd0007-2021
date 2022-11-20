<?php

$sets = distributeToSets([1, 2, 1]);

var_dump($sets);

function distributeToSets(array $input) : array {
    $arrays = [];
    foreach ($input as $i){
        if (isset($arrays[$i])){
            array_push($arrays[$i], $i);
        }else{
            $arrays[$i] = [$i];
        }
    }

    return $arrays;
}
