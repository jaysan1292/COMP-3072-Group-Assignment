<?php
require_once '../php/functions.php';

// test data

$cdb = new CourseDbProvider;
$c1 = $cdb->get(4, 2);
$c2 = $cdb->get(4, 1);
$c3 = $cdb->get(2, 2);
$c4 = $cdb->get(2, 1);
$c5 = $cdb->get(3, 2);
$c6 = $cdb->get(3, 1);
$c7 = $cdb->get(1, 2);
$c8 = $cdb->get(1, 1);

// end test data

// schedule to test
// TODO: replace each 1 in this array to an instance of Course
$schedule = array([$c1, $c2, 0,   0,   0  ],  // Monday
                  [0,   0,   0,   0,   0  ],  // Tuesday
                  [0,   0,   0,   0,   0  ],  // Wednesday
                  [0,   0,   $c3, $c4, $c7],  // Thursday
                  [0,   $c5, $c6, 0,   $c8]); // Friday

$width = 600;
$height = 425;
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
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday'
);
for ($i = 0; $i < $cols - 1; $i++) {
    $d = $days[$i];
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
for($y = 1, $time = 0.0; $y < $rows; $y++, $time += 0.5) {
    for($x = 1, $day = 0; $x < $cols; $x++, $day++) {
        if(($slot = $schedule[$day][$time])) {
            $leftX = $cellWidth * $x;
            $leftY = $cellHeight * $y;
            $rightX = $leftX + $cellWidth;
            $rightY = $leftY + $cellHeight;

            $size = 8.0;
            $cname = "$slot->courseCode\nCRN: $slot->crn\n$slot->room\n" .
                    $slot->startToString() . '-' . $slot->finishToString();

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
