<?php
require_once 'php\global.php';
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

    <!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container-fluid">
        <div class="row-fluid">
            <header class="span12 hero-unit">
                <div id="container" class="span8">
                    <h1>Bohhls Schedulr</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi fuga enim itaque qui eum totam veritatis perspiciatis nihil cupiditate dolore nemo excepturi aut. Eum ducimus quos suscipit illum dolor qui?</p><br>
                    <blockquote>
                        <p>&quot;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut ad temporibus eius cupiditate earum accusantium fugiat qui enim illo adipisci tenetur libero unde facere porro vero voluptates explicabo culpa cumque!&quot;</p>
                        <small><p>Bill Gates</p></small>
                    </blockquote>
                    <p><a href="#">Learn More</a></p>
                </div>
                <div class="row">
                    <div class="span3 offset1 pull-right well">
                        <legend><strong>Sign In</strong></legend>
                        <form method="POST" action="authenticate.php" accept-charset="UTF-8">

                            <?php if(isset($_GET['msg'])): ?>
                            <!-- TODO: Ew, inline styles -->
                            <label style="color: red;"><?=$_GET['msg']?></label>
                            <?php endif; ?>

                            <input type="text" id="username" class="span6" name="username" placeholder="Username"><br>
                            <input type="password" id="password" class="span6" name="password" placeholder="Password">
                            <label class="checkbox">
                                <input type="checkbox" name="remember" value="1"> Remember Me
                            </label>
                            <button type="submit" name="submit" class="btn btn-info k">Sign in</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>
    </div>
    <div class="row-fluid">
        <footer class="span12">
            &copy; Bohhls Schedulr 2013.
        </footer>
    </div>
    <!-- Le Scripts -->
    <script src="js/main.js"></script>
    <!-- Bootstrap JS -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootsrap.min.js"></script>
</body>
</html>
