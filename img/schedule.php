<?php
require_once '../php/functions.php';
require_once '../php/classes.php';

$width = 500;
$height = 500;
$image = imagecreate($width, $height);
$mainBackground = imagecolorallocate($image, 255, 255, 255);
$secondaryBackground = imagecolorallocate($image, 224, 224, 224);
$textColor = imagecolorallocate($image, 20, 20, 20);
$darkLineColor = imagecolorallocate($image, 10, 10, 10);
$lightLineColor = imagecolorallocate($image, 192, 192, 192);

// schedule to test
// TODO: replace each 1 in this array to an instance of Course
$schedule = array(array(1, 1, 0, 0, 0),  // Monday
                  array(0, 0, 0, 0, 0),  // Tuesday
                  array(0, 0, 0, 0, 0),  // Wednesday
                  array(0, 0, 1, 1, 1),  // Thursday
                  array(0, 1, 1, 0, 1)); // Friday

// set background
imagefilledrectangle($image, 0, 0, $width, $height, $mainBackground);

// set line thickness
imagesetthickness($image, 1);

$cols = 5;  // day columns
$rows = 11; // header row + time rows
$cellHeight = $height / $rows;
$cellWidth = $width / $cols;

imagefilledrectangle($image, 0, $cellHeight, $width, $height, $secondaryBackground);

// draw horizontal grid lines
for ($i=0; $i < $rows * $cellWidth; $i += $cellHeight) {
    imageline($image, 0, $i, $width, $i, $lightLineColor);
}

for($y=1, $time=0.0; $y < $rows; $y++, $time+=0.5) {
    for($x=0, $day=0; $x < $cols; $x++, $day++) {
        if($schedule[$day][$time] != 0) {
            $leftX = $cellWidth * $x;
            $leftY = $cellHeight * $y;
            $rightX = $leftX + $cellWidth;
            $rightY = $leftY + $cellHeight;

            // Test information for now, will get from Course object eventually
            $cname = "COMP0000\nCRN: 12345\nProf Name\n8:00AM-10:00AM";
            $font = './droidsans.ttf';
            $size = 8.0;

            $bbox = imagettfbbox($size, 0, $font, $cname);

            // TODO: Tweak these values slightly when uploading to the server; font kerning is a bit weird on my Ubuntu PHP installation.
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
