<?php
require_once 'php/global.php';
session_start();

if(!isset($_SESSION['current_user'])) {
    redirect_to_page(LOGIN_PAGE);
} else if(!$_SESSION['current_user']->isAdmin) {
    redirect_to_page(HOME_PAGE);
}
?>
<!doctype html>
<html>
<head>
  <meta charset=utf-8>
  <meta name=description content="">
  <meta name=viewport content="width=device-width, initial-scale=1">
  <title>Bohhls Schedulr - Professor</title>
  <link rel="stylesheet" href="stylesheets/bootstrap.css">
  <link rel="stylesheet" href="stylesheets/bootstrap-responsive.css">
  <link rel=stylesheet href="stylesheets/screen.css">

  <!-- Le Scripts -->
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- x-editable -->
  <link href="bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
  <script src="bootstrap-editable/js/bootstrap-editable.js"></script>
  <script src="js/moment.min.js"></script>
      <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
    </head>
    <body>
      <?php include 'php/includes/navbar.php'; ?>

      <div class="wrap">

        <!-- Dashboard Tab Pane -->
        <div id="dashboard">
         <ul class="nav nav-tabs">
          <li class="active"><a href="#aProfessor" data-toggle="tab"><i class="icon-user"></i>Professors</a></li>
          <li><a href="#aClasses" data-toggle="tab"><i class="icon-calendar"></i>Classes</a></li>
          <li><a href="#aRequest" data-toggle="tab"><i class="icon-info-sign"></i>Time-Off Requests</a></li>
        </ul>

        <section class="tab-content">
          <article class="tab-pane active" id="aProfessor">
            <h3>Professors</h3>
            <div><?php include('aProfessor.php');?></div>
          </article>
          <article class="tab-pane" id="aClasses">
            <h3>Classes</h3>
            <?php include('aClasses.php');?>
          </article>
          <article class="tab-pane" id="aRequest">
            <h3>Time-Off Requests</h3>
            <?php include('aRequest.php');?>
          </article>
        </section>
      </div>

    </div>
  </div>
</div>
<!-- Le Footer -->
<div class="row-fluid">
  <footer class="span12">
    &copy; Bohhls Schedulr 2013.
  </footer>
</div>
</body>
</html>
