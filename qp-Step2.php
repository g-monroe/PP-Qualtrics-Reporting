
<?php
 session_start();
 define("CONFIG", "DATABASE");
 //-Import Conf.
 include("config/vdev.php");
 define(DBCON_PASS, true);
 include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Globals.class.php");
 include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Account.class.php");
 include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Log.class.php");
 include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Qualtrics.class.php");
 //-Class Conf.
 $_Globals = new Globals();
 $_Log = new Log();
 $_Crypto = new Crypto();
   // $_AccountHelper = new AccountHelper($_Globals, null, null, false, null, null, null, $_Log);
   // $success = $_AccountHelper->performLoginCheck();
   // if ($success[0]["Username"] == $_SESSION["user_id"]){
   //
   //   if ($success[0]["loginUserAgent"] === $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']){
   //  //var_dump("Devices and Network Matched!");
   //   }else{
   //     $_Globals->redirect("login.php");
   //   }
   // }else{
   //   $_Globals->redirect("login.php");
   // }

 if (isset($_GET['qp'])){
   $api = $_GET['qp'];
   $_Qual = new Qualtrics($api, $_Globals, $_Crypto, null, false, null, null, null, null, $_Log);
   if ($_SESSION["SV_0wWp6Vlf4raseeV"] === NULL){
        $result = $_Qual->pullResponses("SV_0wWp6Vlf4raseeV");
   }else{
     $result = "good";
   }
 }
 require_once(ROOT.ASSETS."main/".VERSION."library/view/".'StandardView.php'); //Template
 ob_start();
 /**************** Add Content ****************/
 if ($result === "good"){ ?>

   <div class="col-md-12 card">
       <div class="card-header">
           <h4 class="card-title">Questions</h4>
           <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
           <div class="heading-elements">
               <ul class="list-inline mb-0">
                   <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
               </ul>
           </div>
       </div>
       <div class="card-content">
           <div class="card-body">
             <div class="form-group text-center">
               <p>Step 2: Select your Question!</p>
             </div>
             <div id="checkable-tree"></div>
           </div>
       </div>
   </div>
   <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
   <script>
<?php
echo("var defaultData = [");
$questions = $_SESSION["q_SV_0wWp6Vlf4raseeV"]["result"]["questions"];
$length = count($questions);
$idx = 0;
foreach ($questions as $key => $value) {
  $name = $questions[$key]["questionText"];
  $name = strip_tags($name);
  $name = preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $name));
  $name = $_Globals->noHTML($name);
  echo("{
  text: '<b>".substr($name, 0, 30)."...</b>',
  href: '#".$key."',
  ");
  if ($questions[$key]["subQuestions"] !== NULL){
    echo("tags: ['".$idx."'],
    nodes: [");
      $subs = $questions[$key]["subQuestions"];
      $lgth = count($subs);
      $indx = 0;
      foreach ($subs as $ky => $val) {
        $nm = $subs[$ky]["choiceText"];
        $nm = strip_tags($nm);
        $nm = preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $nm));
        $nm = $_Globals->noHTML($nm);
        echo("{
        text: '".substr($nm, 0, 30)."...',
        href: '#".$key."_".$ky."',
        tags: ['".$idx."_".$indx."']");
        echo("}");
        if ($lgth > $indx){
          echo(",");
        }
        $indx++;
      }
    echo("]");
  }else{
    echo("tags: ['".$idx."']");
  }
  echo("}");
  if ($length > $idx){
    echo(",");
  }
  $idx++;
}
echo("];

</script>");
//var_dump($_SESSION["q_SV_0wWp6Vlf4raseeV"]["result"]["questions"]);
//var_dump($_SESSION["SV_0wWp6Vlf4raseeV"]["responses"]);
}else{?>
  <?php
  var_dump($result);
}?>
<?php
 /*********************************************/
 $content = ob_get_contents();
 ob_end_clean();
 $title = "Qualports - Dashboard";
 $page = new StandardView($title, $content);
 echo $page->display();
  ?>
