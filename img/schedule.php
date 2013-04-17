<?php
require_once '../php/functions.php';

function fail() {
    global $width, $height;
    $x = imagecreate(160, 40);
    $bg = imagecolorallocate($x, 192, 192, 192);
    $tex = imagecolorallocate($x, 20, 20, 20);
    $f = './droidsans.ttf';
    imagettftext($x, 12, 0, 10, 25, $tex, $f, 'Schedule not found.');
    header('Content-type: image/png');
    imagepng($x);
    imagedestroy($x);
    die;
}

// Image dimensions (default 600 x 425)
$aspect = 1.41176471;
$width = !is_get_var_empty('width') ? (int)$_GET['width'] : 600;
$height = ceil($width / $aspect);

if(is_admin_logged_in() && !is_get_var_empty('id')) {
    // Admin will be able to see any professor's schedule
    $s_id = (int)$_GET['id'];
} else if(is_user_logged_in()) {
    $s_id = $_SESSION['current_user']->id;
} else {
    fail();
}
$s = new ScheduleProvider;
$schedule = $s->get($s_id);

if(is_null($schedule)) fail();

$image = imagecreate($width, $height);
$mainBackground = imagecolorallocate($image, 255, 255, 255);
$secondaryBackground = imagecolorallocate($image, 224, 224, 224);
$textColor = imagecolorallocate($image, 20, 20, 20);
$darkLineColor = imagecolorallocate($image, 10, 10, 10);
$lightLineColor = imagecolorallocate($image, 192, 192, 192);
$font = './droidsans.ttf';
$font_bold = './droidsans-bold.ttf';

// set line thickness
imagesetthickness($image, 1);

$cols = 6;  // day columns
$rows = 11; // header row + time rows
$cellHeight = $height / $rows;
$cellWidth = $width / $cols;

imagefilledrectangle($image, $cellWidth, $cellHeight, $width, $height, $secondaryBackground);

// draw horizontal grid lines
for ($i=0; $i < $rows * $cellWidth; $i += $cellHeight) {
    imageline($image, 0, $i, $width, $i, $lightLineColor);
    imageline($image, 0, $i, $cellWidth, $i, $darkLineColor);
}

// Write table headers
$days = array(
    'Monday'    => 0,
    'Tuesday'   => 1,
    'Wednesday' => 2,
    'Thursday'  => 3,
    'Friday'    => 4,
);
for ($i = 0; $i < $cols - 1; $i++) {
    $d = array_keys($days)[$i];
    $size = 11.0;
    $bbox = imagettfbbox($size, 0, $font_bold, $d);

    $cellCenterX = ($cellWidth / 2) + ($cellWidth * ($i + 1));
    $x = $cellCenterX - round(($bbox[4] / 2));
    $y = ($cellHeight / 2) + 5;

    imagettftext($image, $size, 0, $x, $y, $textColor, $font_bold, $d);
}

// Write time headers (on left side)
$times = array(
     800,
     900,
    1000,
    1100,
    1200,
    1300,
    1400,
    1500,
    1600,
    1700,
);
for($y = 1, $i = 0; $y < $rows; $y++, $i++) {
    $t = time24_to_string($times[$i]);
    $size = 11.0;
    $bbox = imagettfbbox($size, 0, $font, $t);

    $cellCenterX = ($cellWidth / 2);
    $cellCenterY = ($cellHeight / 2) + ($cellHeight * $y);
    $strx = $cellCenterX - round(($bbox[4] / 2));
    $stry = $cellCenterY - round(($bbox[3] / 2)) + 5;

    imagettftext($image, $size, 0, $strx, $stry, $textColor, $font, $t);
}

// Fill in the schedule
for($y = 1, $time = 800; $y < $rows; $y++, $time += 100) {
    for($x = 1, $day = 0; $x < $cols; $x++, $day++) {
        $course = array_filter($schedule->courses, function($var) {
            global $time, $day, $days;
            $correctDay = $days[$var->day] == $day;
            $correctTime = $var->start == $time;

            return $correctDay and $correctTime;
        });
        $course = array_shift($course);
        if($course) {
            $leftX = $cellWidth * $x;
            $leftY = $cellHeight * $y;
            $rightX = $leftX + $cellWidth;
            $rightY = $leftY + $cellHeight;

            $size = 8.0;
            $cname = "$course->courseCode\nCRN: $course->crn\n$course->room\n".
                     $course->startToString() . '-' . $course->finishToString();

            $bbox = imagettfbbox($size, 0, $font, $cname);

            $strx = $bbox[6] + $leftX + 7;
            $stry = $bbox[7] + $leftY + 26;

            if($time - intval($time) != 0.5) {
                $newY = $rightY + $cellHeight;
                imagefilledrectangle($image, $leftX, $leftY, $rightX, $newY, $mainBackground);
                imageline($image, $leftX, $leftY, $rightX, $leftY, $lightLineColor);
                imageline($image, $leftX, $newY, $rightX, $newY, $lightLineColor);
                imagettftext($image, $size, 0, $strx, $stry, $textColor, $font, $cname);
            }
        }
    }
}

// draw vertical grid lines
for ($i=0; $i < $cols * $cellWidth; $i += $cellWidth) {
    imageline($image, $i, 0, $i, $height, $lightLineColor);
    imageline($image, $i, 0, $i, $cellHeight, $darkLineColor);
}
imageline($image, $cellWidth, 0, $cellWidth, $height, $darkLineColor);

// draw header separator lines
imageline($image, 0, $cellHeight, $width, $cellHeight, $darkLineColor);

// draw black border around everything
imagerectangle($image, 0, 0, $width - 1, $height - 1, $darkLineColor);

header('Content-type: image/png');
// output the image
imagepng($image);

// cleanup
imagecolordeallocate($image, $mainBackground);
imagecolordeallocate($image, $secondaryBackground);
imagecolordeallocate($image, $darkLineColor);
imagecolordeallocate($image, $lightLineColor);
imagecolordeallocate($image, $textColor);
imagedestroy($image);
