<?php
ini_set("memory_limit","256M");
$inputFile = fopen("input14.txt",'r');

function getFlyiedDistance($time, $reindeer) {
    $numberOfCycles = floor($time / ($reindeer["flyTime"] + $reindeer["restTime"]));
    $leftSeconds = $time % ($reindeer["flyTime"] + $reindeer["restTime"]);

    $distance = $numberOfCycles * ($reindeer["flyTime"] * $reindeer["speed"]);
    if ($reindeer["flyTime"] <= $leftSeconds) {
        $distance += $reindeer["flyTime"] * $reindeer["speed"];
    } else {
        $distance += $leftSeconds * $reindeer["speed"];
    }

    return $distance;
}

$raceTime = 2503;
$results = array();
$top = 0;
while ($row = trim(fgets($inputFile))) {
    $pom = explode(' ',$row);
    $name = $pom[0];
    $speed = $pom[3];
    $flyTime = $pom[6];
    $restTime = $pom[13];

    $reindeer = array(
        "name" => $name,
        "speed" => $speed,
        "flyTime" => $flyTime,
        "restTime" => $restTime
    );
    $distance = getFlyiedDistance($raceTime, $reindeer);
    $reindeer["distance"] = $distance;

    $results[$name] = $reindeer;

    if ($top <= $distance) {
        $top = $distance;
    }

}

// var_dump($results);
var_dump('najdlhsia preletena vzdialenost: ' .$top);

// 2. cast
$reindeers = $results;

// inicialzuje sa pole boodv
$points = array();
foreach ($reindeers as $name => $value) {
    $points[$name] = 0;
}

// spocitaju sa pozicie bazmegov v kazdej minute
for ($i=1; $i <= $raceTime; $i++) {

    $topDistance = 0;
    // kazdemu bazmegovi vypocitam preletenu vzdialenosti do casu i a ulozim do properties
    foreach ($reindeers as $name => $properties) {
        $distance = getFlyiedDistance($i, $properties);
        $reindeers[$name]['distance'] = $distance;
        if ($topDistance < $distance) {
            $topDistance = $distance;
        }
    }

    // najdem, ktory maju prejdenu vzdialenost rovnu navyssej v case i
    // moze ich byt viac a pridam im bodik
    $firstReindeers = array();
    foreach ($reindeers as $name => $properties) {
        if ($properties['distance'] == $topDistance) {
            $points[$name]++;
        }
    }

}


var_dump($points);










fclose($inputFile);