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

/*
 * Redirects to the specified page. Please note, however,
 * that it will only redirect to pages within the application
 * (i.e., anything under ROOT_DIR). To redirect elsewhere,
 * just set the location header yourself.
 */
function redirect_to_page($page) {
    $vars = get_defined_vars();
    if(!array_key_exists('page', $vars) ||
       is_null($page) ||
       empty($page)) {
        throw new Exception('No page specified', 1);
    }
    // if passed in string does not contain ROOT_DIR
    if(strpos($page, ROOT_DIR) !== FALSE) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $page);
    } else {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . ROOT_DIR . $page);
    }
}

function time24_to_string($time) {
    $time = str_replace(':', '', $time);
    $min = substr($time, -2);
    $hour = intval(substr($time, 0, -2));
    $pm = $hour >= 12;

    if($pm && $hour != 12) $hour -= 12;

    return "$hour:$min" . ($pm ? 'PM' : 'AM');

}
