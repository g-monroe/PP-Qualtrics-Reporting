<?php
define('auth_LLQLJI4yJ60JUER1SEUS87Ssda2SV_ForbiddenCheck', true);
//■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
//■■■■■    GLOBAL DB FILES     ■■■■■■
//■■■■■    8/23/2017 -Gavin    ■■■■■■
//■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
require_once($_SERVER['DOCUMENT_ROOT'].'/new-web/config.php');// Vars
require_once($_SERVER['DOCUMENT_ROOT'].'/account/php/session.php'); //User Session.
require($_SERVER['DOCUMENT_ROOT']."/account/php/".RANDOM_R1SE_DBCON_FOLDER.'/dbcon.php'); //Init DB TUNNEL Connection
require_once(VIEW_DIR . 'StandardView.php'); //Template

ob_start();
/**************** Add Content ****************/

$getQ = noHTML($_GET['q']);
echo("<style>
        #searchBar{
          padding:10px;
          font-size:20px;
          width:80%;
          margin-left:10%;
        }
        #searchDiv{
          width:100%;
          height:100%;
        }
        #searchList{
              list-style: none;
              margin: 0 auto;
              width: 84%;
              height: 100%;
              margin-left:10%;
        }
        #searchResult{
          margin-top: 15px;
          margin-bottom: 15px;
          font-size:20px;
          font-weight:bold;
        }
</style>");
echo('<div class="center"><h1 style="text-align:center;">Searh RISE</h1><div id="searchDiv">
        <form method="get" action="">
        <input type="text" name="q" class="riseTB" id="searchBar" value="'.$getQ.'"/>
        </form
    </div></div>');
    echo('<ul id="searchList">');
    echo('<li id="searchList" style="border-bottom: 1px solid black; margin-left:0px;"><br/><h2>Staff:</h2></li>');
if (isset($getQ) && strlen($getQ) > 0) {
  $query = "SELECT * FROM staff WHERE active=1 AND staff_name=? OR last_name=? OR code LIKE '%$getQ%' LIMIT 10";
    if ($stmt = mysqli_prepare($link, $query)) {//Start Query and prepare
      $stmt->bind_param('ss', $getQ, $getQ);
      $stmt->execute();//Execute
      $row = array();//Declare new array.
      stmt_bind_assoc($stmt, $row);//Bind results to the new array
      while ($stmt->fetch()) {//Look through the array with a loop
        echo("<li id='searchResult'><a href='staff.php?id=".$row['staff_id']."'>".$row['staff_name'].", ".$row['last_name']." - Profile</a><br/><small style='font-size:13px; color:grey;'>".substr(strip_tags($row['code']), 50, 200)."...</small></li>");
    }//End Loop
  }//End Connection
  echo('<li id="searchList" style="border-bottom: 1px solid black; margin-left:0px;"><br/><h2>Pages:</h2></li>');
  $query = "SELECT * FROM rise_pages WHERE Name LIKE '%?%' OR code LIKE '%?%' LIMIT 15";
    if ($stmt = mysqli_prepare($link, $query)) {//Start Query and prepare
      $stmt->bind_param('ss', $getQ, $getQ);
      $stmt->execute();//Execute
      $row = array();//Declare new array.
      stmt_bind_assoc($stmt, $row);//Bind results to the new array
      while ($stmt->fetch()) {//Look through the array with a loop
        echo("<li id='searchResult'><a href='".$row['url']."'>".$row['Name']." - Page</a><br/><small style='font-size:13px; color:grey;'>".substr(strip_tags($row['code']), 50, 200)."...</small></li>");
    }//End Loop
  }//End Connection
echo('<li id="searchList" style="border-bottom: 1px solid black; margin-left:0px;"><br/><h2>Projects:</h2></li>');
$query = "SELECT * FROM proj WHERE title LIKE '%?%' OR code LIKE '%?%' LIMIT 15";
  if ($stmt = mysqli_prepare($link, $query)) {//Start Query and prepare
    $stmt->bind_param('ss', $getQ, $getQ);
    $stmt->execute();//Execute
    $row = array();//Declare new array.
    stmt_bind_assoc($stmt, $row);//Bind results to the new array
    while ($stmt->fetch()) {//Look through the array with a loop
      echo("<li id='searchResult'><a href='evaluation.php?id=".$row['id']."'>".$row['title']."</a><br/><small style='font-size:13px; color:grey;'>".substr(strip_tags($row['code']), 50, 200)."...</small></li>");
  }//End Loop
}//End Connection
} //	display staff directory
echo('</ul>');


/*********************************************/
$content = ob_get_contents();
ob_end_clean();

$title = "Search | Research Institute for Studies in Education";
$page = new StandardView($title, $content);
echo $page->display();
?>
