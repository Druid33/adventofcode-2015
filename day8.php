<?php
ini_set("memory_limit","256M");
$inputFile = fopen("input8.txt",'r');


function tokenizeString($string){
    $string = str_replace('\"', '+', $string);
    $string = str_replace('\\\\', '-', $string);

    $matches = array();
    preg_match_all("/\\\x[0-9a-fA-F]{2}/", $string, $matches);
    // var_dump($matches);
    foreach ($matches[0] as $match) {
        // $replace = str_replace('\\', '0', $match);
        // var_dump($replace);
        $string =str_replace($match, '*', $string);
    }



    return $string;
}


function encodeString($string) {
    $string = str_replace('"', '++', $string);
    $string = str_replace('\\', '--', $string);

    return '"'.$string.'"';
}

// $s = '\\x15sa\\';
// $s = trim(fgets($inputFile));
// var_dump($s);
// var_dump(tokenizeString($s));

// exit;

$numberOfChars = 0;
$numberOfCharsInMemory = 0;
$numberOfencodedChars = 0;
while ($row = trim(fgets($inputFile))) {
    // var_dump($row);

    $tokenizedString = tokenizeString($row);
    // var_dump($tokenizedString);

    $encodedString = encodeString($row);
    // var_dump($encodedString);

    $numberOfChars = $numberOfChars + strlen($row);
    $numberOfCharsInMemory = $numberOfCharsInMemory + strlen($tokenizedString) - 2;
    $numberOfencodedChars = $numberOfencodedChars + strlen($encodedString);
}

var_dump('numberOfChars: ' . $numberOfChars);
var_dump('numberOfCharsInMemory: ' . $numberOfCharsInMemory);
var_dump('numberOfChars - numberOfCharsInMemory: ' . ($numberOfChars - $numberOfCharsInMemory));
var_dump('numberOfencodedChars: '. $numberOfencodedChars);
var_dump('numberOfencodedChars - numberOfChars: ' . ($numberOfencodedChars - $numberOfChars));
fclose($inputFile);