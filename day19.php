<?php
ini_set("memory_limit","3000M");


function applyReplacements($replacements, $molekule) {
    $newMolekules = array();
    for ($index=0; $index < strlen($molekule); $index++) {
        foreach ($replacements as $search => $replaces) {
            if (substr($molekule, $index, strlen($search)) === $search) {
                foreach ($replaces as $replace) {
                    $new = substr_replace($molekule, $replace, $index, strlen($search));
                    $newMolekules[] = $new;
                }
            }
        }
    }

    return array_unique($newMolekules);
}


function isPerspective($molekule) {
    if (strpos($molekule, 'ee') !== FALSE) {
        return false;
    }

    return true;
}

function applyReplacementsOptimized($replacements, $molekule) {
    $newMolekules = array();
    for ($index=0; $index < strlen($molekule); $index++) {
        foreach ($replacements as $search => $replaces) {
            if (substr($molekule, $index, strlen($search)) === $search) {
                foreach ($replaces as $replace) {
                    $new = substr_replace($molekule, $replace, $index, strlen($search));
                    if ($new === "e") {
                        $newMolekules = array($new);
                        var_dump('find!');
                        return $newMolekules;
                    }

                    if (isPerspective($new)) {
                        $newMolekules[] = $new;
                    }
                }
            }
        }
    }

    return array_unique($newMolekules);
}

$inputFile = fopen("input19.txt",'r');
$replacements = array();
while ($row = trim(fgets($inputFile))) {
    if ($row === "") {
        break;
    }
    $pom = explode(' ',$row);
    $replacements[$pom[0]][] = $pom[2];
}
$row = trim(fgets($inputFile));
$molekulePrototype = $row;

// var_dump($replacements);

fclose($inputFile);

// $newMolekules = array();
// for ($index=0; $index < strlen($molekule); $index++) {
//     foreach ($replacements as $search => $replaces) {
//         if (substr($molekule, $index, strlen($search)) === $search) {
//             foreach ($replaces as $replace) {
//                 $newMolekules[] = substr_replace($molekule, $replace, $index, strlen($search));
//             }
//         }
//     }
// }

// $newMolekules = array_unique($newMolekules);
var_dump(count(applyReplacements($replacements, $molekulePrototype)));
// die();

// druha cast
//


$inputFile = fopen("input19.txt",'r');
$replacements = array();
while ($row = trim(fgets($inputFile))) {
    if ($row === "") {
        break;
    }
    $pom = explode(' ',$row);
    $replacements[$pom[2]][] = $pom[0];
}
$row = trim(fgets($inputFile));
$molekulePrototype = $row;

// var_dump($replacements);
// die();
fclose($inputFile);


$molekules = array($molekulePrototype);

$step = 0;
$continue = true;
while ($continue) {
    $step++;
    echo 'step ' . $step . ' started' . "\n";
    $molekulesAfterStep = array();
    foreach ($molekules as $molekule) {
        $newMolekules = applyReplacementsOptimized($replacements, $molekule);
        if (array_search("e", $newMolekules) !== false) {
            $continue = false;
            var_dump('find! at step '. $step);
            break;
        }
        $molekulesAfterStep = array_merge($molekulesAfterStep,$newMolekules);
    }
    $molekules = array_unique($molekulesAfterStep);
    echo "pocet molekul " . count($molekules);
    if ($step === 5) {
        echo '10 opakovanii...STOP';
        $continue = false;
        break;
    }
    echo 'step ' . $step . ' ended'. "\n";
    echo "\n";
}

