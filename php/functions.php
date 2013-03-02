<?php
require_once 'global.php';

function code_dump($var) {
    echo '<pre><code>';
    var_dump($var);
    echo '</code></pre>';
}

function to_rectangle($bbox) {
    code_dump($bbox);
    $lowLeft = new Point($bbox[0], $bbox[1]);
    $lowRight = new Point($bbox[2], $bbox[3]);
    $upLeft = new Point($bbox[4], $bbox[5]);
    $upRight = new Point($bbox[6], $bbox[7]);

    $x = $upLeft->x;
    $y = $upLeft->y;
    $width = $upRight->x - $x;
    $height = $lowLeft->y - $y;

    return new Rectangle($x, $y, $width, $height);
}

function time24_to_string($time) {
    $time = str_replace(':', '', $time);
    $min = substr($time, -2);
    $hour = intval(substr($time, 0, -2));
    $pm = $hour >= 12;

    if($pm && $hour != 12) $hour -= 12;

    return "$hour:$min" . ($pm ? 'PM' : 'AM');

}
