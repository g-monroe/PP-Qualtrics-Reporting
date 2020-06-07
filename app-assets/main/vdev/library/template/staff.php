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
$label = "Our Team"; // Label appended to page <title>
$getID = noHTML($_GET['id']);
if (isset($getID) && is_numeric($getID)) { // display staff member information
	/*$result = "";
	$query = "SELECT * FROM staff WHERE staff_id=?";
	if ($stmt = mysqli_prepare($link, $query)) {//Start Query and prepare
		$stmt->bind_param("s", $getID);//Bind
		$stmt->execute();//Execute
		$row = array();//Declare new array.
		stmt_bind_assoc($stmt, $row);//Bind results to the new array
		while ($stmt->fetch()) {//Look through the array with a loop
			if(!$row) { //if no result to display (bad ID) go to default view
				header( 'Location: http://www.rise.hs.iastate.edu/staff.php' );
				ob_flush();
			}
			//OUTPUT (Not Gavin's Code for the output)
			$label = $row['staff_name'] .  " " . $row['last_name'];
			$result = $result."<td width=\"40%\" style=\"border:0px; vertical-align:top\">";
			if($row['photo']) {
				$result = $result."<div class=\"photo\" style=\"float:left;\">";
				$result = $result."<img src=\"http://www.rise.hs.iastate.edu/image/photos/staff/". $row['photo'] ."\" />";
				//print("<p>". $label . "</p>");//
				$result = $result."</div>";
			}
			$result = $result."<h2>" . $label . "</h2>";
			if ($row['title'])
			if ($row['title'])
				$result = $result."<p><b>". $row['title'] . "</b></p>";
			if($row['address'])
				$result = $result."<p>". $row['address'] . "</p>";
			if($row['e_mail'])
				$result = $result."<p><a href=\"mailto:". $row['e_mail'] ."\">". $row['e_mail'] . "</a></p>";
			if($row['phone'])
				$result = $result."<p>". $row['phone'] . "</p>";
			if($row['website'])
				$result = $result."<p><a href=\"" . $row['website']. "\">Curriculum Vitae</a><small> (pdf)</small></p>";

	 		$result = $result.'<div class="clear"></div> ';
			if($row['bio']) {
				$result = $result."<td width=\"60%\" style=\"border:0px; vertical-align:top\">";
				$result = $result."<p style=\"text-align:left\">". $row['bio'] ."</p>";
				$result = $result."</td>";
			}//End IF
		}//End Loop
	}//End Connection





    $result = $result.'<br><br><p><a href="staff.php"> &#0171; Our Team</a></p>';
    try{
					$qryID = $dbc->prepare("UPDATE staff SET code=? WHERE staff_id=?");
					$qryID->execute([$result, $getID]);
					echo "Edited!";
				}catch (Exception $e){
					echo "Couldn't Update page.";
				}*/
        echo("<style>#content{
          display: inline-block;
          margin: 0 auto;
          flex-direction: row;
          flex-wrap: nowrap;
          width:94%;
          height:100%;
          margin-left:6%;
        }</style>");
        echo('<div class="center"><p><a href="staff.php"> « Our Team</a></p>');
echo(staffInitEdit($dbc));
  echo('</div>');
}else{
  echo('<link rel="stylesheet" href="'.HOMEURL.'/library/fa/css/font-awesome.min.css">');
  echo("<style>h3 a:hover{
        font-size: 1.0em;
        border-bottom: 0px dotted #004499;
  }

#content a:hover {
  border-bottom: 0px dotted #004499;
}
.research-list img {
    border: 3px solid #cccaca;
    float: left;
}
.circular--square {
  width: 150px;
  height: 200px;
  overflow: hidden;
}
table th{
  text-align: left;
}
</style>");
  echo('<div class="center"><ul class="research-list">');
/*$content = initEditing($dbc);*/
$result = "";
$query = "SELECT * FROM staff WHERE active=1 AND photo LIKE '%.%'
ORDER BY staff_name='Mari' DESC, staff_name='Todd' DESC, staff_name='Arlene' DESC, staff_name='Robin' DESC, staff_name='Brandi' DESC, staff_name='Joshua' DESC, staff_name='Elena' DESC, staff_name='Beth' DESC, staff_name='Rachel' DESC";
  if ($stmt = mysqli_prepare($link, $query)) {//Start Query and prepare
    $stmt->execute();//Execute
    $row = array();//Declare new array.
    stmt_bind_assoc($stmt, $row);//Bind results to the new array
    while ($stmt->fetch()) {//Look through the array with a loop
    echo('

                                    <li class="research-list-item">

                                            <a href="staff.php?id='.$row["staff_id"].'">
                                                <img class="circular--square" src="http://www.rise.hs.iastate.edu/image/photos/staff/'.$row['photo'].'">
                                            </a>


                                    	<div class="research-list-details">

    	                            		<h2>
                                                <a href="staff.php?id='.$row['staff_id'].'" style="padding-bottom:0px;">'.$row['staff_name'].'</a>
                                            </h2>
                                            <h2 style="padding-top:0px;">
                                                      <a href="staff.php?id='.$row['staff_id'].'" style="padding-top:0px;">'.$row['last_name'].'</a>
                                                  </h2>
                                                  <p style="font-weight:bold;color:#7b7474;font-size:10px; ">
                                                            '.$row['title'].'
                                                        </p>
    	                            		<ul>

    	                            			<li><i style="color:#7b7474; font-size: .9em" class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:'.$row['e_mail'].'">'.str_replace("@iastate.edu", "", $row['e_mail']).'</a></li>
    	                            		</ul>


    	                            	</div>
                                   	</li>



                    			');
  }//End Loop
}//End Connection
echo('  </ul>');
echo('<div>
		<h2 style="float:left;width:100%;text-align:center;">Not Pictured Above</h2><!-- <p><b>Office:</b> E016 Lagomarcino</p>
<p><b>Phone:</b> 515-294-1941</p> -->
		<table class="mce-item-table" data-mce-style="width: 100%;" style="width: 100%;">
			<tbody>
				<tr>
					<th width="25%">Name</th>
					<th width="25%">Title</th>
					<th width="25%">Email</th>
				</tr>
				<tr>
					<!-- <td width="109" height="59" valign="middle"> -->
					<td height="59" valign="middle">
						<a data-mce-href="staff.php?id=145" href="staff.php?id=145">Berta, Meg</a>
					</td><!-- <td width="120" valign="middle"> -->
          <td valign="middle">
            Graduate Research Assistant
          </td>
					<td valign="middle">
						<a data-mce-href="mailto:mmberta@iastate.edu" href="mailto:mmberta@iastate.edu">mmberta@iastate.edu</a>
					</td>
				</tr>
				<tr class="alt">
					<!-- <td width="109" height="59" valign="middle"> -->
					<td height="59" valign="middle">
						<a data-mce-href="staff.php?id=141" href="staff.php?id=141">Connelly, Jeanne</a>
					</td><!-- <td width="120" valign="middle"> -->
          <td valign="middle">
            Graduate Research Assistant
          </td>
					<td valign="middle">
						<a data-mce-href="mailto:jeannem@iastate.edu" href="mailto:jeannem@iastate.edu">jeannem@iastate.edu</a>
					</td>
				</tr>
				<tr class="alt">
					<!-- <td width="109" height="59" valign="middle"> -->
					<td height="59" valign="middle">
						<a data-mce-href="staff.php?id=112" href="staff.php?id=112">Hemer, Kevin</a>
					</td><!-- <td width="120" valign="middle"> -->
          <td valign="middle">
            Graduate Research Assistant
          </td>
					<td valign="middle">
						<a data-mce-href="mailto:khemer@iastate.edu" href="mailto:khemer@iastate.edu">khemer@iastate.edu</a>
					</td>
				</tr>
				<tr>
					<!-- <td width="109" height="59" valign="middle"> -->
					<td height="59" valign="middle">
						<a data-mce-href="staff.php?id=140" href="staff.php?id=140">Hirch, Roz</a>
					</td><!-- <td width="120" valign="middle"> -->
          <td valign="middle">
            Graduate Research Assistant
          </td>
					<td valign="middle">
						<a data-mce-href="mailto:rhirch@iastate.edu" href="mailto:rhirch@iastate.edu">rhirch@iastate.edu</a>
					</td>
				</tr>
				<tr>
					<!-- <td width="109" height="59" valign="middle"> -->
					<td height="59" valign="middle">
						<a data-mce-href="staff.php?id=139" href="staff.php?id=139">Rokkum, Jeffrey</a>
					</td><!-- <td width="120" valign="middle"> -->
          <td valign="middle">
            Graduate Research Assistant
          </td>
					<td valign="middle">
						<a data-mce-href="mailto:rokkum@iastate.edu" href="mailto:rokkum@iastate.edu">rokkum@iastate.edu</a>
					</td>
				</tr>
				<tr class="alt">
					<!-- <td width="109" height="59" valign="middle"> -->
					<td height="59" valign="middle">
						<a data-mce-href="staff.php?id=101" href="staff.php?id=101">Schiltz, James</a>
					</td><!-- <td width="120" valign="middle"> -->
          <td valign="middle">
            Graduate Research Assistant
          </td>
					<td valign="middle">
						<a data-mce-href="mailto:jschiltz@iastate.edu" href="mailto:jschiltz@iastate.edu">jschiltz@iastate.edu</a>
					</td>
				</tr>
				<tr>
					<!-- <td width="109" height="59" valign="middle"> -->
					<td height="59" valign="middle">
						<a data-mce-href="staff.php?id=144" href="staff.php?id=144">Weston, George</a>
					</td><!-- <td width="120" valign="middle"> -->
          <td valign="middle">
            Graduate Research Assistant
          </td>
					<td valign="middle">
						<a data-mce-href="mailto:gweston@iastate.edu" href="mailto:gweston@iastate.edu">gweston@iastate.edu</a>
					</td>
				</tr>
				<tr>
					<td height="59" valign="middle"><!--<a href="staff.php?id=146
                    BucknerSarah
                </a> -->Buckner, Sarah</td><!-- <td width="120" valign="middle"> -->
                <td valign="middle">
      						Undergraduate Assistant
      					</td>
					<td valign="middle">
						<a data-mce-href="mailto:sbuckner@iastate.edu" href="mailto:sbuckner@iastate.edu">sbuckner@iastate.edu</a>
					</td>
				</tr>
				<tr class="alt">
					<!-- <td width="109" height="59" valign="middle"> -->
					<td height="59" valign="middle"><!--<a href="staff.php?id=148
                    MonroeGavin
                </a> -->Monroe, Gavin</td><!-- <td width="120" valign="middle"> -->
                <td valign="middle">
      						Web Developer/Assistant
      					</td>
					<td valign="middle">
						<a data-mce-href="mailto:gmonroe@iastate.edu" href="mailto:gmonroe@iastate.edu">gmonroe@iastate.edu</a>
					</td>
				</tr>
				<tr>
					<!-- <td width="109" height="59" valign="middle"> -->
					<td height="59" valign="middle"><!--<a href="staff.php?id=142
                    MullenbachCraig
                </a> -->Mullenbach, Craig</td><!-- <td width="120" valign="middle"> -->
                <td valign="middle">
      						Undergraduate Assistant
      					</td>
					<td valign="middle">
						<a data-mce-href="mailto:craigm1@iastate.edu" href="mailto:craigm1@iastate.edu">craigm1@iastate.edu</a>
					</td>
				</tr>
				<tr class="alt">
					<!-- <td width="109" height="59" valign="middle"> -->
					<td height="59" valign="middle"><!--<a href="staff.php?id=147
                    YoungSelena
                </a> -->Young, Selena</td><!-- <td width="120" valign="middle"> -->
                <td valign="middle">
      						Undergraduate Assistant
      					</td>
					<td valign="middle">
						<a data-mce-href="mailto:slyoung@iastate.edu" href="mailto:slyoung@iastate.edu">slyoung@iastate.edu</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>');
} //	display staff directory



/*********************************************/
$content = ob_get_contents();
ob_end_clean();

$title = "Staff | Research Institute for Studies in Education";
$page = new StandardView($title, $content);
echo $page->display();
?>
