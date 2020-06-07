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
/*********************************************/

?>
<?php
$reqID = noHtml($_GET['id']);
if (!isset($_GET['id']) && !is_numeric($reqID)){
//EDIT PART
$editAccess = projCheckEditAccess($dbc);
if (isset($_COOKIE['PhpID'])){
	$accountID = getIDFS($_COOKIE['PhpID'], $dbc);

}
//Page Selector Vars
$htmlAll = "<a style='float:right;' href='?all=1'>Archived</a>";
if (isset($_GET['all'])){
	$htmlAll = "<a style='float:right;' href='?p=1'>Active</a>";
}
$result = "<style>
#content{
  width:98%;
  line-height: 170%;
}
</style><div class='center'>".$htmlAll."<table id='projectTable'>";
$numItems = getCount("proj", $dbc);
$numPages = floor($numItems / 10);
$reqPage = noHtml($_GET['p']);
$offset = 0;
if (!isset($_GET['p']) || !is_numeric($reqPage)){
	$reqPage = "1";
}
if (isset($_GET['p']) && is_numeric($reqPage) && $reqPage == $numPages || $reqPage < $numPages){
	$offset = $reqPage * 10;
}
$query = "SELECT * FROM proj WHERE active=1 ORDER BY title ASC LIMIT 10 OFFSET ?";
$all = "";
if (isset($_GET['all'])){
	$query = "SELECT * FROM proj ORDER BY title ASC LIMIT 10 OFFSET ?";
	$all = "&all=1";
}
	if ($stmt = mysqli_prepare($link, $query)) {//Start Query and prepare
		$stmt->bind_param("i", $offset);//Bind
		$stmt->execute();//Execute
		$row = array();//Declare new array.
		stmt_bind_assoc($stmt, $row);//Bind results to the new array
		while ($stmt->fetch()) {//Look through the array with a loop
			//OUTPUT (Not Gavin's Code for the output)
			$result = $result."<tr>
		<td class='ava'>
			<img src='";
			if (strlen($row['avatar']) == 0){
				$result = $result."http://www.rise.hs.iastate.edu/image/riselogo2.jpg";
			}else{
				$result = $result.$row['avatar'];
			}
			$result = $result."' /></td><td>
			<h2 class='sans'>";
				if ($row['active'] == 2){
					$result = $result."<a href='?id=".$row['id']."'>".$row['title']."</a></h2>";
				}else{
					$result = $result."<a href='?id=".$row['id']."'>".$row['title']."</a></h2>";
				}
				if ($editAccess){
					$result = $result."<p>".$row['abstract']."<a href='?id=".$row['id']."&edit=2'>...Edit</a>"."</p>";
				}else{
					$result = $result."<p>".$row['abstract']."</p>";
				}
			$result = $result."
		</td>
	</tr>";
		}//End Loop
	}//End Connection
$result = $result."	</table>";
//SELECTOR
$result = $result."<div class='pageSelect'>";
for ($i = 1; $i <= $numPages; $i++){
	if ($reqPage != $i){
		$result = $result."<span><a href='?p=".$i.$all."'>".$i."</a></span>";
	}else{
		$result = $result."<span class='selected'><a href='?p=".$i.$all."'>".$i."</a></span>";
	}
}
$result = $result."</div></div>";
$content = initEditing($dbc).$result;
}else{

	//$reqID = noHtml($_GET['id']);
	//$reqEdit = noHtml($_GET['edit']);
	//if (isset($_GET['id']) && is_numeric($reqID)){
		//if (projCheckEditAccess($dbc)){

		//}else{

		//}
	//}else{
		//$content = "Page not Found!";
	//}
//}

/*$codes = "";
$query = "SELECT * FROM proj WHERE id=?";
	if ($stmt = mysqli_prepare($link, $query)) {//Start Query and prepare
		$stmt->bind_param("s", $_GET['id']);//Bind
		$stmt->execute();//Execute
		$row = array();//Declare new array.
		stmt_bind_assoc($stmt, $row);//Bind results to the new array
		while ($stmt->fetch()) {//Look through the array with a loop
			$codes = $codes.'<div class="projMain">
	<small><a href="/evaluation1.php">Back</a> | Projects</small><h1>'.$row['title'].'</h1>
	<div class="projLeft">
		<!-- DESCRIPTION (html formatted) -->
		'.$row['description'];
			$sup = explode("\n", $row['support']);
			if ($sup[0]){
				$codes = $codes.'<hr /><h2>Related Documents</h2>
			<ul>';
				foreach($sup as $i=>$supItem) {
					$codes = $codes."<li>".$supItem."</li>\n";
				}
			 	$codes = $codes.'</ul>';
			}
			$codes = $codes.'</div>
	<div class="projRight">
		<!-- AVATAR (if any) -->';
		$codes = $codes.'<div  class ="ava"><div class="holder"><img src="'.$row['avatar'].'" /></div></div>
		<!-- FUNDING -->';
		if($row['funding']){
			$codes = $codes.'<div>
				<h2>Funding</h2>
				<p>'.$row['funding'].'</p>
			</div>';
		}
		$staff = getAllPeople($row['risestaffid'], $dbc);
		if (isset($staff[0])){
			$codes = $codes.'<div>
				<h2>Project Team</h2>
				<ul class="team">';
				foreach($staff as $p){
					$codes = $codes.'<li>';
					if ($p->type == 'rise'){
						$codes = $codes.'<b><a href="'.$p->url.'">'.$p->name.'</a></b>';
						$codes = $codes."(".$p->role."), ";
					} else{
						$codes = $codes.'<b>'.$p->name.'</b>';
						$codes = $codes.$p->role."(".$p->role."), ";
					}
					$codes = $codes.'</li>';
				}
				$codes = $codes.'</ul>
			</div>';
		}
		if($row['website']){
		$codes = $codes.'<div>
			<h2>Project Website</h2>
			'.$row['website'].'
		</div>';
		}
		if($row['RelatedSite']){
		$codes = $codes.'<div>
			<h2>Related Website</h2>
			'.$row['RelatedSite'].'
		</div>';
		}
	$codes = $codes.'</div>
</div>';
		}//End Loop
	}//End Connection

	$content = $codes;
try{
	$qryID = $dbc->prepare("UPDATE proj SET code=? WHERE id=?");
	$qryID->execute([$codes, $_GET['id']]);

}catch (Exception $e){
	return "Couldn't Update page.";
}*/

$content = "<style>
#content{padding-top:1em;}
@media (max-width:960px) and (min-width:0px) {
	.projMain .projRight {
		float:none;
		width:50%;
	}
	.projRight div.ava {
		box-shadow: none;
	}
}
</style><div class='center'>".projInitEdit($dbc)."</div>";

}
ob_end_clean();


$title = "Our Projects | Research Institute for Studies in Education";
$page = new StandardView($title, $content);
echo $page->display();
?>
