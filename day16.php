<?php
ini_set("memory_limit","256M");
$inputFile = fopen("input16.txt",'r');


function checkParameterOne($name,$value){
global $MCFSAMticker;

    switch ($name) {
        case 'children':
        case 'samoyeds':
        case 'akitas':
        case 'vizslas':
        case 'cars':
        case 'perfumes':
        case 'pomeranians':
        case 'goldfish':
        case 'cats':
        case 'trees':
            if ($value == $MCFSAMticker[$name]){
                return true;
            }
            break;


        default:
            throw new \RuntimeException('unknown parameter name: ' . $name);
            break;
    }

    return false;
}


function checkParameterTwo($name,$value){
global $MCFSAMticker;

    switch ($name) {
        case 'children':
        case 'samoyeds':
        case 'akitas':
        case 'vizslas':
        case 'cars':
        case 'perfumes':
            if ($value == $MCFSAMticker[$name]){
                return true;
            }
            break;

        case 'pomeranians':
        case 'goldfish':
            if ($value < $MCFSAMticker[$name]){
                return true;
            }
            break;

        case 'cats':
        case 'trees':
            if ($value > $MCFSAMticker[$name]){
                return true;
            }
            break;

        default:
            throw new \RuntimeException('unknown parameter name: ' . $name);
            break;
    }

    return false;
}

$sues = array();
$sues2 = array();
$MCFSAMticker = array(
    "children" => 3,
    "cats" => 7,
    "samoyeds" => 2,
    "pomeranians" => 3,
    "akitas" => 0,
    "vizslas" => 0,
    "goldfish" => 5,
    "trees" => 3,
    "cars" => 2,
    "perfumes" => 1,
);

while ($row = trim(fgets($inputFile))) {
    $pom = explode(' ',$row);
    $matches = array();
    preg_match('/^Sue ([0-9]{1,3}): (\w+): (\d+), (\w+): (\d+), (\w+): (\d+)$/',$row,$matches);
    // var_dump(count($matches));
    if ( checkParameterOne($matches[2], (int)$matches[3]) and
        checkParameterOne($matches[4], (int)$matches[5]) and
        checkParameterOne($matches[6], (int)$matches[7]) )
    {
        $sues[$matches[1]] = $matches;
    }

    if ( checkParameterTwo($matches[2], (int)$matches[3]) and
        checkParameterTwo($matches[4], (int)$matches[5]) and
        checkParameterTwo($matches[6], (int)$matches[7]) )
    {
        $sues2[$matches[1]] = $matches;
    }
}
fclose($inputFile);

var_dump($sues);
var_dump($sues2);
