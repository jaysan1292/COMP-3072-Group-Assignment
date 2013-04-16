<?php
require_once 'php/global.php';
session_start();

if(!isset($_SESSION['current_user'])) {
    redirect_to_page(LOGIN_PAGE);
} else if($_SESSION['current_user']->isAdmin) {
    redirect_to_page(ADMIN_PAGE);
}

$pagetitle = 'Bohhls Schedulr - Professor';
include 'php/includes/htmlheader.php';
?>
      <div class="wrap">

        <!-- Dashboard Tab Pane -->
        <div id="dashboard">
         <ul class="nav nav-tabs" id="professor-nav">
          <li class="active"><a href="#profile" data-toggle="tab"><i class="icon-user"></i>Profile</a></li>
          <li><a href="#schedule" data-toggle="tab"><i class="icon-calendar"></i>Schedule</a></li>
          <li><a href="#requests" data-toggle="tab"><i class="icon-calendar"></i>Your Time-Off Requests</a></li>
        </ul>

        <section class="tab-content">
          <article class="tab-pane active" id="profile">
            <h3>Profile</h3>
            <div><?php include('uProfile.php');?></div>
          </article>
          <article class="tab-pane" id="schedule">
            <h3>Schedule</h3>
            <?php include('uSchedule.php');?>
          </article>
          <article class="tab-pane" id="requests">
            <h3>Your Time-Off Requests</h3>
            <?php include('uRequests.php'); ?>
          </article>
        </section>
      </div>

    </div>
  </div>
</div>
<?php include 'php/includes/htmlfooter.php'; ?>
