<?php
require_once __DIR__ . '/../global.php';
require_once __DIR__ . '/../lib/php-markdown/markdown.php';
?>

<!DOCTYPE html>
<html>
<head>
<?php
if (!empty($pagetitle)) {
    echo "<title>$pagetitle</title>\n";
}

?>
<link rel="stylesheet" type="text/css" href="<?=ROOT_DIR?>/stylesheets/GitHub2.css">
<link rel="stylesheet" type="text/css" href="<?=ROOT_DIR?>/stylesheets/print.css" media="print">
<!--[if IE]>
    <link href="<?=ROOT_DIR?>/stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
