<?php
require_once 'php/global.php';
session_start();

if(!isset($_SESSION['current_user'])) {
    redirect_to_page(LOGIN_PAGE);
} else if(!$_SESSION['current_user']->isAdmin) {
    redirect_to_page(HOME_PAGE);
}

$pagetitle = 'Bohhls Schedulr - Admin';
include 'php/includes/htmlheader.php';
?>
      <div class="wrap">

        <!-- Dashboard Tab Pane -->
        <div id="dashboard">
         <ul class="nav nav-tabs" id="admin-nav">
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
<?php include 'php/includes/htmlfooter.php'; ?>
