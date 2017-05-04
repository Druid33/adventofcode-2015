<?php
ini_set("memory_limit","256M");
$inputFile = fopen("input6.txt",'r');

$grid = array();

while ($row = trim(fgets($inputFile))) {
    $row = str_replace('toggle', 'toggle it', $row);

    $order = explode(' ', $row);

    $startCoord = explode(',',$order[2]);
    $startX = $startCoord[0];
    $startY = $startCoord[1];

    $stopCoord = explode(',',$order[4]);
    $stopX = $stopCoord[0];
    $stopY = $stopCoord[1];


    for ($i = $startX; $i <= $stopX; $i++) {
        for ($j= $startY; $j <= $stopY; $j++) {
            switch ($order[0] . $order[1]) {
                case 'turnon':
                    if (isset($grid[$i][$j])) {
                        $grid[$i][$j] = $grid[$i][$j] + 1;
                    } else {
                        $grid[$i][$j] = 1;
                    };
                    break;

                case 'turnoff':
                    // $grid[$i][$j] = false;
                    if(isset($grid[$i][$j])) {
                        $grid[$i][$j] = $grid[$i][$j] - 1;
                        if ($grid[$i][$j] <= 0) {
                            unset($grid[$i][$j]);
                        }
                    }
                    break;

                case 'toggleit':
                    if (isset($grid[$i][$j])) {
                        $grid[$i][$j] = $grid[$i][$j] + 2;
                    } else {
                        $grid[$i][$j] = 2;
                    }
                    break;

                default:
                    throw new \RuntimeException(":(");
                    break;
            }
        }
    }



}

$lit = 0;
for ($i=0; $i < 1000; $i++) {
    for ($j=0; $j < 1000; $j++) {
        if (isset($grid[$i][$j])) {
            $lit = $lit + $grid[$i][$j];
        };
    }
}

var_dump($lit);
fclose($inputFile);