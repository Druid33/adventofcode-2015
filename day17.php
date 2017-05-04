<?php
ini_set("memory_limit","256M");


function binToGalons($bin, $boxis) {
    $revertedBin = strrev($bin);
    $galons = 0;
    for ($i = 0 ; $i < strlen($revertedBin); $i++) {
        $value = $revertedBin[$i];
        if ((int)$value === 1) {
            $galons += $boxis[(count($boxis) - 1 - $i)];
        }
    }

    return $galons;
}


$inputFile = fopen("input17.txt",'r');

$boxis = array();
$maxCombinationBin = '';
while ($row = trim(fgets($inputFile))) {
    $boxis[] = (int)$row;
    $maxCombinationBin .= '1';
}
fclose($inputFile);

$maxCombinationDec = bindec($maxCombinationBin);

$combination = array();
for ($i=1; $i <= $maxCombinationDec ; $i++) {
    $bin = decbin($i);

    $galons = binToGalons($bin, $boxis);
    if ($galons == 150) {
        $key = strlen(str_replace('0', '', $bin));
        if (isset($combination[$key])) {
            $combination[$key]++;
        } else {
            $combination[$key] = 1;
        }
    }
}

var_dump($combination);


