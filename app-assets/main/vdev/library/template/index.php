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
echo('<style>#content{padding-top:5em;}</style><div class="center">
<h1>Welcome to RISE</h1><p>The <strong>Research Institute for Studies in Education</strong> (RISE), a unit of the <a href="http://education.iastate.edu" target="_blank" rel="noopener" data-mce-href="http://education.iastate.edu">School of Education</a>, was formed in 1974 to conduct comprehensive, integrated research and evaluation studies that enhance PK-20 education locally, nationally, and globally. RISE operates as a self-supporting, nonprofit organization housed within <a href="http://www.iastate.edu" target="_blank" rel="noopener" data-mce-href="http://www.iastate.edu">Iowa State University</a>, a public, research-intensive university. RISE promotes the integration of evaluation, research, and policy through partnerships with schools, colleges and universities, federal and state education agencies, and private agencies and foundations.<br><br> RISE <a href="/staff.php" data-mce-href="staff.php">staff</a> apply research and evaluation expertise to deliver a broad spectrum of services related to research, analytic inquiry, and technical consulting. <!-- Research and evaluation services include: --></p><ul><li>Grant proposal preparation and budget consultation</li><li>Program and project evaluation planning and implementation</li><li>Quantitative and qualitative research design and methodology</li><li>Qualitative inquiry (e.g., focus groups, interviews, observations)</li><li>Survey development and sample selection</li><li>Needs assessment</li><li>Data collection, management, and analysis</li><li>Interpretation and presentation of results</li></ul>RISE staff have extensive experience in a variety of research and evaluation <a href="/focus.php" data-mce-href="focus.php">focus areas</a>, including projects related to climate and diversity; curriculum development; health and well-being; personal and social responsibility; social, emotional, and behavioral initiatives; STEM; student learning and development; teacher education; and technology applications.<br><br> Through collaborative efforts with clients, RISE supports institutional research activities, conducts evaluations of academic programs, and contributes data for institutional improvement, policy development, accreditation, and program review.');
/*********************************************/
$content = ob_get_contents();
ob_end_clean();

$title = "Welcome | Research Institute for Studies in Education";
$page = new StandardView($title, $content);
echo $page->display();
?>
