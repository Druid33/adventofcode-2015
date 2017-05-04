<?php
$input = 'vzbxkghb';

function isValid($char) {
    switch ($char) {
        case 'i':
        case 'l':
        case 'o': return false;
    }
    return true;
}

function nextChar($char) {
    $continue = true;
    $iterator = 0;

    while ($continue) {
        $iterator++;
        if ($char == 'z') {
            $nextChar = 'a';
        } else {
            $nextChar = chr(ord($char) + 1);
        }

        if (isValid($nextChar)) {
            $continue = false;
        } else {
            $char = $nextChar;

            if ($iterator > 30) {
                throw new Exception("cant find next valid char");
            }
        }


    }

    return $nextChar;
}

function increaseLetter($string, $index) {
    // $lastChar = 'x';
    $firstChar = 'a';

    if ($index < 0) {
        return $string;
    }

    $nextChar = nextChar($string[$index]);

    $string[$index]  = $nextChar;
    if ($nextChar == $firstChar) {
        return increaseLetter($string, $index-1);
    }

    $string[$index] = $nextChar;

    return $string;

}

function isValidPswd($pswd) {
    if (jePostupnost($pswd) && arePairs($pswd)) {
        return true;
    }
    return false;
}

function jePostupnost($pswd) {
    // postupnost abc
    for ($i=2; $i < strlen($pswd); $i++) {
        $actual = ord($pswd[$i]);
        $prev = ord($pswd[$i-1]);
        $prevPrev = ord($pswd[$i-2]);
        if ((($prevPrev+1) == $prev) && (($prev+1) == $actual)) {
            return true;
        }
    }
    return false;
}

function arePairs($pswd) {
    $numberOfPairs = 0;
    for ($i=1; $i < strlen($pswd); $i++) {
        $actual = $pswd[$i];
        $prev = $pswd[$i-1];
        if ($prev == $actual) {
            $pswd[$i] = '*';
            $pswd[$i-1] = '*';
            $numberOfPairs++;
        }
    }
    if ($numberOfPairs >1) {
        return true;
    }
    return false;
}

// $input = 'ghjaaaaa';
// var_dump(arePairs($input));
// die;

$lastPassword = '';
for ($i=0; $i < strlen($input); $i++) {
    $lastPassword .= 'z';
}

$globalIndex = strlen($input) - 1;
$continue = true;
$validPswd = ':(';
while ($continue) {
    $output = increaseLetter($input, $globalIndex);
    // var_dump($output);
    if (isValidPswd($output)){
        $continue = false;
        $validPswd = $output;
    }

    if ($output == $lastPassword) {
        $continue = false;
        var_dump('Vsetky moznosti prejdene');
    }

    $input = $output;
}

var_dump('validne heslo: ' . $validPswd);
// var_dump('posledne heslo: '. $output);

$input = $validPswd;
$globalIndex = strlen($input) - 1;
$continue = true;
$validPswd = ':(';
while ($continue) {
    $output = increaseLetter($input, $globalIndex);
    // var_dump($output);
    if (isValidPswd($output)){
        $continue = false;
        $validPswd = $output;
    }

    if ($output == $lastPassword) {
        $continue = false;
        var_dump('Vsetky moznosti prejdene');
    }

    $input = $output;
}
var_dump('dlasie validne heslo: ' . $validPswd);