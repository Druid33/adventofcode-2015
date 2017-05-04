<?php
ini_set("memory_limit","256M");


function getNextAnimation($grid) {
    $newGrid = $grid;
    for ($i=1; $i < (count($grid) - 1); $i++) {
        for ($j=1; $j < (count($grid) - 1); $j++) {

            $on = 0;
            for ($k=$i-1; $k <= $i+1 ; $k++) {
                for ($l=$j-1; $l <= $j+1; $l++) {
                    if (($grid[$k][$l] === '#') && !(($k === $i) && ($l === $j))) {
                        $on++;
                    }
                    // echo $grid[$k][$l];
                }
                // echo "\n";
            }


            // var_dump($on);
            // echo "\n";
//
            if ($grid[$i][$j] === '#') {
                if ($on === 2 || $on === 3) {

                } else {
                    $newGrid[$i][$j] = ".";
                }
            } else {
                if ($on === 3) {
                    $newGrid[$i][$j] = "#";
                }
            }

        }
    }

    return $newGrid;
}

function writeGrid($grid) {
    for ($i=0; $i < count($grid); $i++) {
        for ($j=0; $j < count($grid); $j++) {
            echo $grid[$i][$j];
        }
        echo "\n";
    }
    echo "\n";
}


$inputFile = fopen("input18.txt",'r');
$grid = array();
for ($i=0; $i < 102; $i++) {
    $grid[0][$i] = ".";
}
$i = 1;
while ($row = trim(fgets($inputFile))) {

    $grid[$i][0] = ".";
    for ($j=0; $j < strlen($row); $j++) {
        $char = $row[$j];
        $index = $j+1;
        $grid[$i][$index] = $char;
    }
    $grid[$i][$index+1] = ".";
    $i++;
}
for ($i=0; $i <= 102; $i++) {
    $grid[101][$i] = ".";
}
fclose($inputFile);

$grid[1][1] = '#';
$grid[100][1] = '#';
$grid[1][100] = '#';
$grid[100][100] = '#';
// writeGrid($grid);

for ($i=0; $i < 100; $i++) {
    $grid = getNextAnimation($grid);
    $grid[1][1] = '#';
    $grid[100][1] = '#';
    $grid[1][100] = '#';
    $grid[100][100] = '#';
    // writeGrid($grid);
}

$on = 0;
for ($i=0; $i < count($grid); $i++) {
    for ($j=0; $j < count($grid); $j++) {
        if ($grid[$i][$j] === "#") {
            $on++;
        }
    }
}

var_dump($on);