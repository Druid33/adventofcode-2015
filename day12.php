<?php

ini_set("memory_limit","256M");
$inputFile = fopen("input12.txt",'r');
$json = trim(fgets($inputFile));
fclose($inputFile);
// var_dump($json);

$pole = json_decode($json, false);
// var_dump($pole);
function computeNumbers($pole) {
    $sum = 0;

    foreach ($pole as $key => $value) {
        if(is_object($pole) && $value === "red") {
            return 0;
        }

        if (is_array($value) || is_object($value)) {
            $sum += computeNumbers($value);
        } elseif (is_int($value) || is_float($value)) {
            $sum += $value;
        }

    }

    return $sum;
}

$sum = computeNumbers($pole);
var_dump($sum);