<?php
require_once('lib/php-markdown/markdown.php');
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/GitHub2.css" rel="stylesheet"/>
</head>
<body>
<?php
$text = '# H1
## H2
### H3
#### H4
##### H5
###### H6

Regular text!


|Tables |are    |
|-------|-------|
|awesome|things!|

[This is a link](http://google.com)';

echo Markdown($text);
?>
<hr/>
<?php
function separator($x, $max_x) {
    return $x != $max_x - 1 ? '|' : '';
}

function day($day) {
    switch($day) {
        case 0: return 'Sunday';
        case 1: return 'Monday';
        case 2: return 'Tuesday';
        case 3: return 'Wednesday';
        case 4: return 'Thursday';
        case 5: return 'Friday';
        case 6: return 'Saturday';
        default: return '';
    }
}

// Test generate table
echo Markdown('### Test generating a table');
$table = '';
$max_x = 5;
$max_y = 10;
for($y = 0; $y < $max_y; $y++) {
    for($x = 0; $x < $max_x; $x++) {
        $separator = separator($x, $max_x);
        $table .= "X:$x, Y:$y$separator";
    }
    if($y == 0) {
        $table = $table . "\n";
        for($x = 0; $x < $max_x; $x++) {
            $separator = separator($x, $max_x);
            $table = $table . "-$separator";
        }
    }
    $table .= "\n";
}

echo Markdown($table);
echo Markdown('### Generated table');
$raw_table = preg_replace("/\n/", "\n    ", $table);
echo Markdown('    ' . $raw_table);
?>
<hr/>
<?php
$max_x = 5;
$max_y = 11;

$t = 8;
for($i = 0; $i < $max_y; $i++, $t++) {
    if($t > 12) $t = 1;
    if($t < 7 || $t == 12) {
        $suffix = 'PM';
    } else {
        $suffix = 'AM';
    }
    $times[$i] = "$t$suffix";
}

echo Markdown('### Schedulr');
$table = '|';
for($d = 1; $d <= 5; $d++) {
    $table .= day($d) . '|';
}
$table .= "\n---|---|---|---|---|---\n";

for($y = 0; $y < $max_y - 1; $y++) {
    $idx = $y + 1;
    $table .= "$times[$y]-$times[$idx]|";
    for($x = 0; $x < $max_x; $x++) {
        $separator = separator($x, $max_x);
        $data = '';
        $table .= "$data$separator";
    }
    $table .= "\n";
}

echo Markdown($table);
echo Markdown('### Generated table');
$raw_table = preg_replace("/\n/", "\n    ", $table);
echo Markdown('    ' . $raw_table);
?>
</body>
</html>
