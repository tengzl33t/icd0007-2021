<?php

$numbers = [1, 2, 5, 6, 2, 11, 2, 7];

function getOddNumbers($list){
    $newlist = [];
    foreach ($list as $val){
        if (($val % 2) > 0):
            array_push($newlist, $val);
        endif;
    }
    return $newlist;
}

print_r(getOddNumbers($numbers));
