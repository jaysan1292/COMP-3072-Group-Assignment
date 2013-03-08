<?php
require_once __DIR__ . '/../global.php';
require_once __DIR__ . '/../lib/php-markdown/markdown.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    if (!empty($pagetitle)) {
        echo "<title>$pagetitle</title>\n";
    }
    ?>
    <link rel="stylesheet" type="text/css" href="<?=ROOT_DIR?>/stylesheets/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?=ROOT_DIR?>/stylesheets/bootstrap-responsive.css">
    <link rel="stylesheet" type="text/css" href="<?=ROOT_DIR?>/stylesheets/print.css" media="print">
    <link rel="stylesheet" type="text/css" href="<?=ROOT_DIR?>/stylesheets/application.css">
    <!--[if IE]>
        <link href="<?=ROOT_DIR?>/stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <![endif]-->

    <!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
