<?php
$pagetitle = 'Scheduling Test';
include 'php/includes/htmlheader.php';
?>
<body>
    <?php
    $x = new CourseDbProvider;
    $c = $x->get(3, 1);

    code_dump($c);
    echo $c->startToString();
    echo '<br/>';
    echo $c->finishToString();
    ?>
    <h1>Sample Schedule</h1>
    <img src="<?=ROOT_DIR?>/img/schedule.php"/>
</body>
</html>
