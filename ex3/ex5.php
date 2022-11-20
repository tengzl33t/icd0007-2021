<?php

$numbers = [3, 2, 5, 6];

$joined = join(",", $numbers); # same implode function
#print $joined;

$new_arr = explode(",", $joined);
#print_r($new_arr);