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
echo('<div class="center">
<script type="text/javascript" src="/script/contact_form.js"></script>
<h1>Contact Us</h1>

<p>Complete the Contact Form (the best method to reach us).  You can also call our office or send us an <a href="mailto:rise@iastate.edu">email</a>.</p>

<section class="sidecontact">

	<h2>Submit Your Inquiry</h2>
	<p id="errors">

	</p>
	<form method="POST" action="/contact.php" id="contactForm">
		<label for="emailFrom">Your E-mail</label><input type="text" name="emailFrom" id="emailFrom" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
		<label for="emailSubject">Subject</label><input type="text" name="emailSubject" id="emailSubject">

		<label for="emailText">Message</label><textarea placeholder="Message limited to 2000 characters" id="emailText" name="emailText"></textarea>
		<label for="challenge" style="margin-top: 285px;">Verify: What is the President\'s last name?</label><input type="text" name="challenge" id="challenge">

		<hr style="margin-top: 45px;">
		<div class="cl"></div>
		<ul class="errors"></ul>
		<input type="submit" value="Submit">
	</form>
</section>

<h2>Phone and Email</h2>
<p>Phone: (515) 294-7009<br>
Fax: (515) 294-9284<br>
E-mail: <a href="mailto:rise@iastate.edu">rise@iastate.edu</a></p><br>

<h2>Mailing Address</h2>
<p>Research Institute for Studies in Education<br>
		E005 Lagomarcino Hall<br>
		901 Stange Road<br>
        Iowa State University<br>
		Ames, Iowa 50011-1041<br></p>



				</div>');
/*********************************************/
$content = ob_get_contents();
ob_end_clean();

$title = "Welcome | Research Institute for Studies in Education";
$page = new StandardView($title, $content);
echo $page->display();
?>
