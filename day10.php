<?php
$input = '1113222113';


function sayNumber($numberInString) {

    if (strlen($numberInString) == 0) {
        throw new RuntimeException("Empty string");
    }

    if (strlen($numberInString) == 1) {
        return '1' . $numberInString;
    }

    $output = '';
    $cisloSkupiny = $numberInString[0];
    $pocetCislicVSkupine = 0;
    for ($i=0; $i < strlen($numberInString); $i++) {
        $char = $numberInString[$i];
        if($char == $cisloSkupiny) {
            $pocetCislicVSkupine++;
        } else {
            $output .= $pocetCislicVSkupine . $cisloSkupiny;
            $cisloSkupiny = $char;
            $pocetCislicVSkupine = 1;
        }
    }

    if ($pocetCislicVSkupine > 0) {
        $output .= $pocetCislicVSkupine . $cisloSkupiny;
    }


    return $output;
}

// var_dump(sayNumber('111221'));
$output = $input;
for ($i=0; $i < 50; $i++) {
    $output = sayNumber($output);
}

var_dump(strlen($output));