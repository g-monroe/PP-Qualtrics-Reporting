<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/account/php/session.php'); //User Session.
define('auth_LLQLJI4yJ60JUER1SEUS87Ssda2SV_ForbiddenCheck', true);
//■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
//■■■■■    GLOBAL DB FILES     ■■■■■■
//■■■■■    8/23/2017 -Gavin    ■■■■■■
//■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
require_once($_SERVER['DOCUMENT_ROOT'].'/new-web/config.php');// Vars
require($_SERVER['DOCUMENT_ROOT']."/account/php/".RANDOM_R1SE_DBCON_FOLDER.'/dbcon.php'); //Init DB TUNNEL Connection
require_once(VIEW_DIR . 'StandardView.php'); //Template

ob_start();
/**************** Add Content ****************/
echo('<style>
h1{
    text-align: center;
}
table{
  margin: auto;
}
img{
  max-width:512px;
  max-hieght:332px;
  width:95%;
  height:95%;
}
table tr:nth-child(odd) {
  background-color: none;
}
</style>
<div class="center">
<h1>360° Feedback for Educators</h1><center><img style="max-width:512px; width:95%;" src="http://www.rise.hs.iastate.edu/360/images/360_logo.jpg" data-mce-src="360/images/360_logo.jpg"></center><p>360° Feedback, once designed for use in the business sector, is now economically available through RISE for use in educational settings. 360° Feedback is designed to provide performance feedback from multiple groups of raters.<br><br> Through the 360˚ Feedback Project, RISE contracts with local, state, national, and international school districts to provide feedback on performance to teachers, administrators, and other school district personnel.<br><br> Project management involves contracting with school districts, instrument development, data collection (online and paper versions), data management, data analysis, and distribution of reports. Projects are contracted annually with school districts.</p><p><br><br></p><!-- <p><a href="http://www.rise.hs.iastate.edu/360">360&deg; Feedback Website</a></p> -->
  <div class="center" style="margin-left:10%;">
  <div style="width:50%; float:left;">
  <a href="mailto:mrkemis@iastate.edu" data-mce-href="mailto:mrkemis@iastate.edu">
    <button style="background-color:#FFCC00;color:#483A02;padding:25px;border:0px solid white;border-radius:8px;font-family:Arial;font-size:18px;cursor:pointer;">For More Information<br/>Enter Here!</button></a>
    </div>
    <div style="width:50%; float:right;">
    <a href="/360/verification.php" data-mce-href="360/verification.php">
    <button style="background-color:#66CC9A;color:#0C321D;padding:25px;border:0px solid white;border-radius:8px;font-family:Arial;font-size:18px;cursor:pointer;">Current Clients<br/>Enter Here!</button></a>
    </div></div>

</div>');
/*********************************************/
$content = ob_get_contents();
ob_end_clean();

$title = "Welcome | Research Institute for Studies in Education";
$page = new StandardView($title, $content);
echo $page->display();
?>
