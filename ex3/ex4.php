<?php

foreach (range(1,15) as $val){
    if ($val % 3 == 0 and $val % 5 == 0):
        print("FizzBuzz");
    elseif (($val % 3) == 0):
        print("Fizz");
    elseif (($val % 5) == 0):
        print("Buzz");
    else:
        print($val);
    endif;
}

