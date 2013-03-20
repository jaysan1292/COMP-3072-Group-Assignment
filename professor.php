<?php
require_once 'php/global.php';
session_start();
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
      <div class="container-fluid">
        <div class="row-fluid">
          <header class="span12"><div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
              <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </a>
                <a class="brand" href="/">Bohhls Schedulr</a>

                <div class="nav-collapse collapse">
                  <ul class="nav">
                    <li class="divider-vertical"></li>
                    <li><a href="#"><i class="icon-home icon-white"></i> Home</a></li>
                    <li><a href="#"><img src="img/icon-gbc.png" class="gbc-icon" /> GBC</a></li>
                    <li><a href="#"><img src="img/icon-bb.png" class="bb-icon"> Blackboard</img></a></li>
                  </ul>
                  <div class="pull-right">
                    <ul class="nav pull-right">
                      <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <!-- <?=$_SESSION['current_user'] ?> --><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li><a href="#"><i class="icon-cog"></i> Notifications <i class="icon-exclamation-sign"></i></a></li>
                          <li><a href="#"><i class="icon-envelope"></i> Contact Support</a></li>
                          <li class="divider"></li>
                          <li><a href="logout.php"><i class="icon-off"></i> Logout</a></li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <div class="wrap">

        <!-- Dashboard Tab Pane -->
        <div id="dashboard">
         <ul class="nav nav-tabs">
          <li class="active"><a href="#profile" data-toggle="tab"><i class="icon-user"></i>Profile</a></li>
          <li><a href="#schedule" data-toggle="tab"><i class="icon-calendar"></i>Schedule</a></li>
          <li><a href="#update" data-toggle="tab"><i class="icon-info-sign"></i>News</a></li>
        </ul>

        <section class="tab-content">
          <article class="tab-pane active" id="profile">
            <h3>Profile</h3>
            <div><?php include('profile.php');?></div>
          </article>
          <article class="tab-pane" id="schedule">
            <h3>Schedule</h3>
            <?php include('schedule.php');?>
          </article>
          <article class="tab-pane" id="update">
            <h3>Class Updates</h3>
            <?php include('update.php');?>
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
