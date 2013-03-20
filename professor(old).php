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
        <title>Bohhls Login</title>
        <link rel="stylesheet" href="stylesheets/bootstrap.css">
        <link rel="stylesheet" href="stylesheets/bootstrap-responsive.css">
        <link rel=stylesheet href="stylesheets/screen.css">
        <link rel="stylesheet" href="stylesheets/custom.css">
        
        <!-- HTML5 shim for IE backwards compatibility -->
        <!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row-fluid">
                    <header class="span12 muted">
                        <div class="navbar navbar-inverse navbar-fixed-top">
                            <div class="navbar-inner">
                                <div class="container">
                                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </a>
                                    <a class="brand" href="index.php">Bohhls Schedulr</a>
                                    
                                    <div class="nav-collapse collapse">
                                        <ul class="nav">
                                            <li class="divider-vertical"></li>
                                            <li><a href="index.php"><i class="icon-home icon-white"></i> Home</a></li>
                                            <li><a href="http://www.georgebrown.ca/"><img src="img/icon-gbc.png" width="24px" /> GBC</a></li>
                                            <li><a href="http://bb-gbc.blackboard.com/"><img src="img/icon-bb.png" width="24px" /> Blackboard</a></li>
                                        </ul>
                                        <div class="pull-right">
                                            <ul class="nav pull-right">
                                                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$_SESSION['current_user'] ?><b class="caret"></b></a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="/user/preferences"><i class="icon-cog"></i> Notifications <i class="icon-exclamation-sign"></i></a></li>
                                                        <li><a href="/help/support"><i class="icon-envelope"></i> Contact Support</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="<?=ROOT_DIR?>/logout.php"><i class="icon-off"></i> Logout</a></li>
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
                <br>
                <!-- Dashboard Tab Pane -->
                <div id="dashboard">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#profile" data-toggle="tab"><i class="icon-user"></i>Profile</a></li>
                        <li><a href="#schedule" data-toggle="tab"><i class="icon-calendar"></i>Schedule</a></li>
                        <li><a href="#update" data-toggle="tab"><i class="icon-info-sign"></i>News</a></li>
                    </ul>
                    
                    <section class="tab-content">
                        <!-- Profile Tab -->
                        <article class="tab-pane active" id="profile">
                            <h3>Profile</h3>
                            <div class="container-fluid span8">
                                <div class="row-fluid">
                                    <div class="span4">
                                        <span class="name"><?=$_SESSION['current_user'] ?> </span>
                                        <br> 
                                        <img src="img/hero-image.jpg" class="img-polaroid pull-left">
                                        <div class="box"></div>
                                    </div>
                                    <div class="span8">
                                        <br>
                                        <div class="row-fluid span12 pull-left">
                                            <dl >
                                                <dt>Contact Info:</dt>
                                                <dd>Insert Phone Number Here</dd>
                                                <dd>Insert Email Address</dd>
                                                <br>
                                                <dt>Courses:</dt>
                                                <div class="row">
                                                    <dd class="span4 offset2">Course 1</dd>
                                                    <dd class="span4 offset2">Course 3</dd>
                                                </div>
                                                <div class="row">
                                                    <dd class="span4 offset2">Course 2</dd>
                                                    <dd class="span4 offset2">Course 4</dd> 
                                                </div>
                                                <br>
                                                <dt>Account Type:</dt>
                                                <div class="row">
                                                    <dd class="span 4 offset2">Determine if Admin/Professor</dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid span6">
                                <div class="row-fluid">
                                    <form action="" method="post">
                                        <h3>Edit Profile:</h3>
                                        <div class="row pull-left">
                                            <label>Phone Number</label><input type="text"><br>
                                            <label>Email Address</label><input type="text"><br>
                                            <button>Confirm</button>
                                        </div>
                                        <div class="row pull-right">
                                            <label>Course 1</label><input type="text"><br>
                                            <label>Course 2</label><input type="text"><br>
                                            <label>Course 3</label><input type="text"><br>
                                            <label>Course 4</label><input type="text"><br>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </article>
                        <!-- Schedule Tab -->
                        <article class="tab-pane" id="schedule"> 
                            <h3>Schedule</h3>
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
                            <span class="span12"> <br> </span>
                            
                        </article>
                        <!-- New Tab -->
                        <article class="tab-pane" id="update">
                            <h3>Class Updates</h3>
                            
                        </article>
                    </section>
                </div>
                
            </div>
        </div>
        <div class="push"></div>
    </div>
    <!-- Le Footer -->
    <div class="container-fluid">
        <div class="row-fluid">
            <footer class="span12">
                &copy; Bohhls Schedulr 2013.
            </footer>
        </div>
    </div>
    
    <!-- Le Scripts -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
</body>
</html>