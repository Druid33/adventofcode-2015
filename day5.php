<?php
$inputFile = fopen("input5.txt",'r');


function hasVowels($string) {
    $vowels = array('a','e','i','o','u');

    $count = 0;
    foreach ($vowels as $vowel) {
        $count = $count + substr_count($string,$vowel);
        if ($count >= 3) {
            break;
        }
    }

    if ($count >= 3) {
        return true;
    } else {
        return false;
    }
}

function hasDoubbleLetters($string) {
    $double = false;

    $prev = $string[0];
    for ($i=1; $i < strlen($string); $i++) {
        $actual = $string[$i];
        if ($actual === $prev) {
            $double = true;
            break;
        }

        $prev = $actual;
    }

    return $double;
}


function hasForbidenStrings($string) {
    $forbidenStrings = array('ab','cd','pq','xy');

    $forbiden = false;
    foreach ($forbidenStrings as $substring) {
        if (strpos($string, $substring) !== FALSE) {
            $forbiden = true;
            break;
        }
    }

    return $forbiden;
}

function hasPair($string) {

    for ($i=0; $i < strlen($string)-1; $i++) {
        $workingString = $string;

        $substr = substr($workingString, $i, 2);
        $workingString[$i] = '-';
        $workingString[$i+1] = '-';

        if (strpos($workingString, $substr) !== FALSE ) {
            return true;
        };
    }

    return false;

}


function hasSingleLetterBetween($string) {
    $hasSingle = false;

    $prevPrev = $string[0];
    $prev = $string[1];
    for ($i=2; $i < strlen($string); $i++) {
        $actual = $string[$i];
        if ($actual === $prevPrev) {
            $hasSingle = true;
            break;
        }
        $prevPrev = $prev;
        $prev = $actual;
    }

    return $hasSingle;

}

$nice = 0;
while ($row = fgets($inputFile)) {
    $string = trim($row);

    // if (hasVowels($string) && hasDoubbleLetters($string) && !hasForbidenStrings($string)) {
    //     $nice++;
    // }
    if (hasPair($string) && hasSingleLetterBetween($string)) {
        $nice++;
    }

}
fclose($inputFile);

var_dump($nice);
