<?php

$numbers = [1, 2, '3', 6, 2, 3, 2, 3];

function isInList($list, $elementToBeFound){
    foreach ($list as $val){
        if ($val === $elementToBeFound):
            return True;
        endif;
    }
    return False;
}

var_dump(isInList($numbers, '3'));