<?php

$input = 29000000;
function getNumberOfPackagesForHouse($houseNumber) {
    $packages = 0;
    for ($i=1; $i <= $houseNumber; $i++) {
        if ($houseNumber % $i) {
            // elf nefituje tento dom
        } else {
            $packages += ($i * 10);
        }
    }

    return $packages;
}

// for ($i=1; $i < 10; $i++) {
//     var_dump(getNumberOfPackagesForHouse($i));
// }

// var_dump(getNumberOfPackagesForHouse(1*2*3*4*5*6*7*8*9*2));
// die();
$continue = true;
$from = 0;
$to = 702240;
$limit = 29000000;
for ($i=$from; $i < $to; $i = $i+2) {
    $p = getNumberOfPackagesForHouse($i);
    var_dump($i);
    if ($p >= $limit) {
        var_dump($i);
        break;
    }
}
