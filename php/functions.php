<?php
require_once 'classes.php';
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
