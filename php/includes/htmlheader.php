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
    <link rel="stylesheet" type="text/css" href="<?=ROOT_DIR?>/stylesheets/screen.css">
    <!--[if IE]>
        <link href="<?=ROOT_DIR?>/stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <![endif]-->

    <!-- Le Scripts -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?=ROOT_DIR?>/js/bootstrap.min.js"></script>
    <!-- x-editable -->
    <link href="<?=ROOT_DIR?>/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
    <script src="<?=ROOT_DIR?>/bootstrap-editable/js/bootstrap-editable.js"></script>
    <script src="<?=ROOT_DIR?>/js/moment.min.js"></script>
    <!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<?php include 'php/includes/navbar.php'; ?>
