<?php
$secret = "yzbqklnj";

$continue = true;
$i = 0;
while ($continue) {
    $hash = md5($secret . $i);
    if (substr($hash, 0,6) === "000000") {
        $continue = false;
        var_dump($i);
        var_dump($hash);

    }
    $i++;
}
echo 'koniec';