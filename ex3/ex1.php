<?php

$numbers = [1, 2, '3', 6, 2, 3, 2, 3];

$count = 0;
foreach ($numbers as $val){
    if ($val === 3):
        $count += 1;
    endif;
}
echo $count;