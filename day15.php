<?php
ini_set("memory_limit","256M");
$inputFile = fopen("input15.txt",'r');


function computeRecipeScore($incrediences) {
    global $incredienceProp;
    global $properties;

    // ak su kalorie a nie su 500 tak srat na recept
    if (isset($properties['calories'])) {
        $calories = 0;
        foreach ($incrediences as $incredienceName => $number) {
            $calories += $incredienceProp[$incredienceName]['calories'] * $number;
        }

        if ($calories !== 500) {
            return 0;
        }

    }


    $receipValues = array();
    $receipScore = 1;
    foreach ($properties as $propName) {
        if ($propName == "calories") {
            continue;
        }

        $receipValues[$propName] = 0;
        foreach ($incrediences as $incredienceName => $number) {
            $receipValues[$propName] += $incredienceProp[$incredienceName][$propName] * $number;
        }
        if ($receipValues[$propName] < 0) {
            $receipValues[$propName] = 0;
            $receipScore = 0;
            break;
        }

        // var_dump($propName . ': ' . $receipValues[$propName]);
        $receipScore = $receipScore * $receipValues[$propName];
        // var_dump('receipScore = '.$receipScore.' * '.$receipValues[$propName]);
        // var_dump($receipScore);
    }

    // var_dump($receipValues);
    return $receipScore;


}


$incredience = array();
$properties = array();
$incredienceProp = array();
while ($row = trim(fgets($inputFile))) {
    $pom = explode(' ',$row);

    $matches = array();
    preg_match('/^(\w+): (\w+) ([-]{0,1}\d+), (\w+) ([-]{0,1}\d+), (\w+) ([-]{0,1}\d+), (\w+) ([-]{0,1}\d+), (\w+) ([-]{0,1}\d+)$/',$row,$matches);
    // preg_match('/^(\w+): (\w+) ([-]{0,1}\d+), (\w+) ([-]{0,1}\d+), (\w+) ([-]{0,1}\d+), (\w+) ([-]{0,1}\d+)$/',$row,$matches);
    // var_dump($matches);

    $incredience[$matches[1]] = 1;

    $properties[$matches[2]] = $matches[2];
    $properties[$matches[4]] = $matches[4];
    $properties[$matches[6]] = $matches[6];
    $properties[$matches[8]] = $matches[8];
    $properties[$matches[10]] = $matches[10];

    $incredienceProp[$matches[1]] = array(
        $matches[2] => (int)$matches[3],
        $matches[4] => (int)$matches[5],
        $matches[6] => (int)$matches[7],
        $matches[8] => (int)$matches[9],
        $matches[10] => (int)$matches[11]
        );
}
fclose($inputFile);


// $incredience = array(
//     'Cinnamon' => 56,
//     'Butterscotch' => 44,
//     );
// $value = computeRecipeScore($incredience);
// var_dump($value);
// var_dump($incredienceProp);
// die;


$valueMax = 0;
for ($frosty=1; $frosty <= 97 ; $frosty++) {
    for ($candy=1; $candy <= 97 ; $candy++) {
        for ($butter=1; $butter <= 97 ; $butter++) {
            for ($sugar=1; $sugar <= 97 ; $sugar++) {
                if (($frosty + $candy + $butter + $sugar) == 100 ) {
                    $incredience = array(
                        'Frosting' => $frosty,
                        'Candy' => $candy,
                        'Butterscotch' => $butter,
                        'Sugar' => $sugar,
                        );
                    $value = computeRecipeScore($incredience);
                    if ($valueMax < $value) {
                        $valueMax = $value;
                        $receip = $incredience;
                    }
                }
            }
        }
    }
}

var_dump($properties);
var_dump($incredience);
var_dump($receip);
var_dump($valueMax);
// var_dump($sues);
// var_dump($sues2);
