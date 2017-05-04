<?php
$inputFile = fopen("input2.txt",'r');
$celkovyRibbon = $celkovaSuma = 0;
while ($row = fgets($inputFile)) {
    // var_dump(trim($row));
    $dimenzions = explode('x', trim($row));

    if (sort($dimenzions) === false) {
        throw new \RuntimeException("unable sort");
    };
    $ribbonWrap = $dimenzions[0] * 2 + $dimenzions[1] * 2;
    $ribbonBow = $dimenzions[0] * $dimenzions[1] * $dimenzions[2];
    $celkovyRibbon = $celkovyRibbon + $ribbonWrap + $ribbonBow;

    $sides = array(
        $dimenzions[0] * $dimenzions[1],
        $dimenzions[1] * $dimenzions[2],
        $dimenzions[2] * $dimenzions[0],
        );

    if (sort($sides) === false) {
        throw new \RuntimeException("unable sort");
    };

    $smallestSide = $sides[0];

    $suma = 0;
    foreach ($sides as $obsahStrany) {
        $suma = $suma + (2 * $obsahStrany);
    }

    $suma = $suma + $smallestSide;

    $celkovaSuma = $celkovaSuma + $suma;

}

var_dump($celkovaSuma);
var_dump($celkovyRibbon);


fclose($inputFile);