<?php
ini_set("memory_limit","256M");
$inputFile = fopen("input7.txt",'r');


$wires = array();
$queue = array();
function processQueue($index, &$queue, &$wires) {

    if (count($queue) == 0) {
        return;
    }

    if ($index >= count($queue)) {
        return;
    }

    $row = $queue[$index];


    $order = explode(' ', $row);

    $arg = trim($order[0]);
    if ( ctype_alpha($arg) ) {
        $arg1 = (isset($wires[$arg])) ? (int)$wires[$arg] : null;
    } else {
        $arg1 = (int)$arg;
    }

    $arg = trim($order[2]);
    if ( ctype_alpha($arg) ) {
        $arg2 = (isset($wires[$arg])) ? (int)$wires[$arg] : null;
    } else {
        $arg2 = (int)$arg;
    }

    $operation = false;
    switch ($order[1]) {
        case 'AND':
            if (($arg1 === NULL) || ($arg2 === NULL)) {
                // tak vraj nic
            } else {
                $wires[trim($order[4])] = $arg1 & $arg2;
                $operation = true;
            }
            break;

        case 'OR':
            if (($arg1 === NULL) || ($arg2 === NULL)) {
                // tak vraj nic
            } else {
                $wires[trim($order[4])] = $arg1 | $arg2;
                $operation = true;
            }
            break;

        case 'LSHIFT':
            if (($arg1 === NULL) || ($arg2 === NULL)) {
                // tak vraj nic
            } else {
                $wires[trim($order[4])] = $arg1 << $arg2;
                $operation = true;
            }
            break;

        case 'RSHIFT':
            if (($arg1 === NULL) || ($arg2 === NULL)) {
                // tak vraj nic
            } else {
                $wires[trim($order[4])] = $arg1 >> $arg2;
                $operation = true;
            }
            break;

        case 'NOT':
            if ($arg2 === NULL) {
                // tak vraj nic
            } else {
                $wires[trim($order[4])] = 65535 - $arg2;
                $operation = true;
            }
            break;

        case '->':
            if ($arg1 === NULL) {
                // tak vraj nic
            } else {
                $wires[trim($order[2])] = $arg1;
                $operation = true;
            }
            break;


        default:
            throw new \RuntimeException(":( " . $order[1]);

            break;
    }

    // podarilo sa instrukciu vyhodnotit
    if ($operation) {
        // aktualna instrukcia sa z pola odstrani
        array_splice($queue, $index, 1);
        // zacne sa vyhodnocovanie od zaciatku
        processQueue(0, $queue, $wires);
        return;
    } else {
        // zacne sa vyhodnocovanie nasledujucej instrukcie
        processQueue($index+1, $queue, $wires);
        return;
    }

    return;
}


$bzdocha = array();
while ($row = trim(fgets($inputFile))) {
    $pom = explode(' ',$row);
    $lastIndex = $pom[count($pom)-1];
    if(isset($bzdocha[$lastIndex])) {
        $bzdocha[$lastIndex] = $bzdocha[$lastIndex] + 1;
        var_dump($lastIndex .' = ' . $bzdocha[$lastIndex]);
    } else {
        $bzdocha[$lastIndex] = 1;
    }


    $row = str_replace('NOT', 'xxxxxx NOT', $row);
    $queue[] = $row;
    // spracuje postupne instrukcie. ak sa nejaka vyhodnoti, tak ju vyhodi
    // a zacne spracovavat vsetky v queue znovu
    processQueue(count($queue)-1, $queue, $wires);
}

var_dump($queue);
var_dump($wires['a']);
// var_dump($wires);
// var_dump($bzdocha);

exit;















// 2 cast.
$a = $wires['a'];

// $wires = array('b' => $a);
$wires = array();
$queue = array();

rewind($inputFile);
while ($row = trim(fgets($inputFile))) {
    if (substr($row,-2,2) == ' b') {
        continue;
    }
    $row = str_replace('NOT', 'xxxxxx NOT', $row);
    $row = str_replace(' b ', ' '.$a.' ' , $row);
    $row = preg_replace('/^(b) /', $a.' ', $row);

    $queue[] = $row;
    // spracuje postupne instrukcie. ak sa nejaka vyhodnoti, tak ju vyhodi
    // a zacne spracovavat vsetky v queue znovu
    processQueue(count($queue)-1, $queue, $wires);
}
var_dump($queue);
var_dump($wires['a']);
// var_dump($wires);











fclose($inputFile);