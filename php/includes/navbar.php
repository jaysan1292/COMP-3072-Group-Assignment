<div class="container-fluid">
  <div class="row-fluid">
    <header class="span12">
      <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?=ROOT_DIR?>">Bohhls Schedulr</a>
            <div class="nav-collapse collapse">
              <ul class="nav">
                <li class="divider-vertical"></li>
                <li><a href="#"><i class="icon-home icon-white"></i> Home</a></li>
                <li><a href="http://www.georgebrown.ca/" class="a-hover"><img src="img/icon-gbc.png" class="gbc-icon" /> GBC</a></li>
                <li><a href="https://bb-gbc.blackboard.com" class="a-hover"><img src="img/icon-bb.png" class="bb-icon"> Blackboard</img></a></li>
              </ul>
              <div class="pull-right">
                <ul class="nav pull-right">
                  <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <?=$_SESSION['current_user'] ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="logout.php"><i class="icon-off"></i> Logout</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
  </div>
</div>
