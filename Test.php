
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

   if (isset($_GET["survey"])){
     $surveyI = $_GET["survey"];
     $api = "4TC8R5SvXezupaVRPKQ41zoluygOvKrQ6x7PjHiU";
   $_Qual = new Qualtrics($api, $_Globals, $_Crypto, null, false, null, null, null, null, $_Log);
   //if ($_SESSION[$surveyI] === NULL){
        $result = $_Qual->pullResponses($surveyI);
  // }else{
     //$result = "good";
   //}
 }else{
  // $_Globals->redirect("qp.php");
 }
 require_once(ROOT.ASSETS."main/".VERSION."library/view/".'StandardView.php'); //Template
 ob_start();
 /**************** Add Content ****************/
 if ($result === "good"){
   ?>

   <section id="draggable-cards" class="col-12" style="float:right; height:100%;">

     <div style="height:100%;" class="row col-12">
    		<div class="col-12">
    			<h4>Element Options</h4>
          <hr>
          <div class="col-12 card">
              <div class="card-header">
                  <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
                  <div class="heading-elements">
                      <ul class="list-inline mb-0">
                          <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      </ul>
                  </div>
              </div>
              <div class="card-content">
                  <div class="card-body">
                    <div id="froala-editor"></div>
                    <div style="display:none;" class="te-Input">
                      <div id="full-wrapper">
                        <div id="full-container">
                          <div class="editor">
                            <p>Example</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div style='display:none;' class="ie-Input">
                      <div id="img-wrapper">
                        <div id="img-container">
                          <div class="editor">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
    			<hr>
    		</div>
    	</div>
   	<!-- <div class="row col-12">
   		<div class="col-12">
   			<h4>Report Layout</h4>
   			<hr>
   		</div>
   	</div>

   	<div class="row" id="card-drag-area">
   		<div class="col-lg-12 col-sm-12">
   			<div class="card">
   				<div class="card-header">
            <h4 class="card-title">(1)Text Element</h4>
   					<a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
           			<div class="heading-elements">
   						<ul class="list-inline mb-0">
   							<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
   							<li><a data-action="close"><i class="ft-x"></i></a></li>
   						</ul>
   					</div>
   				</div>
   				<div class="card-content">
   					<div class="card-body">
   						<h4 class="card-title">Example</h4>
            </div>
   				</div>
   			</div>
   		</div>

      <hr>
   	</div> -->
   </section>
   <!-- <div class="col-md-4 card">
       <div class="card-header">
           <h4 class="card-title">Elements</h4>
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
               <p>Step 1: Select your Element!</p>
             </div>
            <div id="elements-treeview" class="treeview">
            </div>
           </div>
       </div>
   </div>
   <div class="col-md-4 card">
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
   </div> -->
   <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
   <script>


  $(function() {
    $.FroalaEditor.DefineIcon('count', {NAME: 'plus'});
   $.FroalaEditor.RegisterCommand('count', {
     title: 'Count',
     focus: true,
     undo: true,
     refreshAfterCallback: true,
     callback: function () {
       this.html.insert('<code id="count" class="text-info">count(10);</code>');
     }
   });
   $.FroalaEditor.DefineIcon('percent', {NAME: 'percent'});
  $.FroalaEditor.RegisterCommand('percent', {
    title: 'Percentage',
    focus: true,
    undo: true,
    refreshAfterCallback: true,
    callback: function () {
      this.html.insert('<code id="percent" class="text-success">percent(1/1);</code>');
    }
  });
  $.FroalaEditor.DefineIcon('comments', {NAME: 'comments'});
 $.FroalaEditor.RegisterCommand('comments', {
   title: 'Multi-Response',
   focus: true,
   undo: true,
   refreshAfterCallback: true,
   callback: function () {
     this.html.insert('<code id="multi" class="text-primary">multiResponse(R);</code>');
   }
 });
    $.FroalaEditor.DefineIcon('my_dropdown', {NAME: 'question'});
     $.FroalaEditor.RegisterCommand('my_dropdown', {
       title: 'Advanced options',
       type: 'dropdown',
       focus: false,
       undo: false,
       refreshAfterCallback: true,
       options: {
         <?php

         $surveyI =  $_GET["survey"];
         $questions = $_SESSION["q_".$surveyI]["result"]["questions"];
         $length = count($questions);
         $idx = 0;
         $did = 0;
         foreach ($questions as $key => $value) {
           $name = $questions[$key]["questionText"];
           $name = strip_tags($name);
           $name = preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $name));
           $name = $_Globals->noHTML($name);
           echo("'".$key."': '".substr($name, 0, 30)."',\n");

           if ($questions[$key]["subQuestions"] !== NULL){
             //echo("tags: ['".$idx."'],
             //nodes: [");
               $subs = $questions[$key]["subQuestions"];
               $lgth = count($subs);
               $indx = 1;
               foreach ($subs as $ky => $val) {
                 $nm = $subs[$ky]["choiceText"];
                 $nm = strip_tags($nm);
                 $nm = preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $nm));
                 $nm = $_Globals->noHTML($nm);
                 echo("'".$key."_".$ky."': '-→ ".substr($nm, 0, 30)."',\n");
                 //echo("}");

                 $indx++;
               }
           }
           if ($questions[$key]["choices"] !== NULL){
             //echo("tags: ['".$idx."'],
             //nodes: [");
               $chcs = $questions[$key]["choices"];
               $lgt = count($chcs);
               $index = 1;
               foreach ($chcs as $k => $vl) {
                 $nam = $chcs[$k]["choiceText"];
                 $nam = strip_tags($nam);
                 $nam = preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $nam));
                 $nam = $_Globals->noHTML($nam);
                 echo("'".$key."_".$ky."_".$k."': '-↓ ".substr($nam, 0, 30)."',\n");
                 //echo("}");

                 $index++;
               }
           }
           $idx++;
         }
        // echo("];

        // </script>");
         //var_dump($_SESSION["q_SV_0wWp6Vlf4raseeV"]["result"]["questions"]);
         //var_dump($_SESSION["SV_0wWp6Vlf4raseeV"]["responses"]);
         ?>
         'v1': 'Option 1',
         'v2': 'Option 2'
       },
       callback: function (cmd, val) {
         this.html.insert("<code id='" + val + "'>" + val + "</code>");
       },
       // Callback on refresh.
       refresh: function ($btn) {
       },
       // Callback on dropdown show.
       refreshOnShow: function ($btn, $dropdown) {
         //console.log ('do refresh when show');
       }
     });

     $.FroalaEditor.DefineIcon('my_dropdown2', {NAME: 'comment'});
      $.FroalaEditor.RegisterCommand('my_dropdown2', {
        title: 'Advanced options',
        type: 'dropdown',
        focus: false,
        undo: false,
        refreshAfterCallback: true,
        options: {
          <?php
          echo("");
          $questions = $_SESSION["q_".$surveyI]["result"]["questions"];
          $length = count($questions);
          $idx = 0;
          $did = 0;
          foreach ($questions as $key => $value) {
            $name = $questions[$key]["questionText"];
            $name = strip_tags($name);
            $name = preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $name));
            $name = $_Globals->noHTML($name);
            echo("'R_".$key."': '".substr($name, 0, 30)."',\n");

            if ($questions[$key]["subQuestions"] !== NULL){
              //echo("tags: ['".$idx."'],
              //nodes: [");
                $subs = $questions[$key]["subQuestions"];
                $lgth = count($subs);
                $indx = 1;
                foreach ($subs as $ky => $val) {
                  $nm = $subs[$ky]["choiceText"];
                  $nm = strip_tags($nm);
                  $nm = preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $nm));
                  $nm = $_Globals->noHTML($nm);
                  echo("'R_".$key."_".$ky."': '-→ ".substr($nm, 0, 30)."',\n");
                  //echo("}");

                  $indx++;
                }
            }
            if ($questions[$key]["choices"] !== NULL){
              //echo("tags: ['".$idx."'],
              //nodes: [");
                $chcs = $questions[$key]["choices"];
                $lgt = count($chcs);
                $index = 1;
                foreach ($chcs as $k => $vl) {
                  $nam = $chcs[$k]["choiceText"];
                  $nam = strip_tags($nam);
                  $nam = preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $nam));
                  $nam = $_Globals->noHTML($nam);
                  echo("'R_".$key."_".$ky."_".$k."': '-↓ ".substr($nam, 0, 30)."',\n");
                  //echo("}");

                  $index++;
                }
            }
            $idx++;
          }
         // echo("];

         // </script>");
          //var_dump($_SESSION["q_SV_0wWp6Vlf4raseeV"]["result"]["questions"]);
          //var_dump($_SESSION["SV_0wWp6Vlf4raseeV"]["responses"]);
          ?>
          'v1': 'Option 1',
          'v2': 'Option 2'
        },
        callback: function (cmd, val) {
          this.html.insert("<code id='" + val + "'>" + val + "</code>");
        },
        // Callback on refresh.
        refresh: function ($btn) {
        },
        // Callback on dropdown show.
        refreshOnShow: function ($btn, $dropdown) {
          //console.log ('do refresh when show');
        }
      });
  $('div#froala-editor').froalaEditor({
    toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'inlineClass', 'clearFormatting', '|', 'emoticons', 'fontAwesome', 'specialCharacters', '-', 'paragraphFormat', 'lineHeight', 'paragraphStyle', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '|', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', '-', 'insertHR', 'selectAll', 'getPDF', 'print', 'help', 'html', 'fullscreen', '|', 'undo', 'redo', 'my_dropdown', 'my_dropdown2', 'count', 'percent', 'comments']
  })
});
var elementsData = [{
      text: '<span class="icon node-icon ft-list"></span> List',
      href: 'List',
      tags: ['List']
  }, {
      text: '<span class="icon node-icon ft-italic"></span> Text',
      href: '#parent2',
      tags: ['0']
  }, {
      text: '<span class="icon node-icon ft-sidebar"></span> Table',
      href: '#parent3',
      tags: ['0']
  }, {
      text: '<span class="icon node-icon ft-box"></span> Value',
      href: '#parent4',
      tags: ['0']
  }, {
      text: '<span class="icon node-icon ft-camera"></span> Image',
      href: '#parent5',
      tags: ['0']
  }, {
      text: '<span class="icon node-icon ft-help-circle"></span> Question',
      href: '#parent6',
      tags: ['0']
  }, {
      text: '<span class="icon node-icon ft-message-circle"></span> Response',
      href: '#parent7',
      tags: ['0']
  }];
  // var ul = document.getElementById('elements-treeview');
  // function getEventTarget(e) {
  //      e = e || window.event;
  //      return e.target || e.srcElement;
  //  }
  //  ul.onclick = function(event) {
  //      var target = getEventTarget(event);
  //     if (target.dataset.nodeid == 0){
  //
  //     }else if (target.dataset.nodeid == 1){
  //       toggleTextElement();
  //     }else if (target.dataset.nodeid == 2){
  //     }else if (target.dataset.nodeid == 3){
  //     }else if (target.dataset.nodeid == 4){
  //       toggleImageElement();
  //     }
  //  };
  // var textElement = false;
  // var listElement = false;
  // var tableElement = false;
  // var valueElement = false;
  // var imageElement = false;
  // function toggleTextElement(){
  //   if (textElement){
  //     var x = document.getElementsByClassName("te-Input");
  //     hideElements(x);
  //     console.log("Hiding");
  //     textElement = false;
  //   }else if (!textElement){
  //     var x = document.getElementsByClassName("te-Input");
  //     console.log("Showing");
  //     showElements(x, "flex");
  //     textElement = true;
  //   }
  // }
  // function toggleImageElement(){
  //   if (imageElement){
  //     var x = document.getElementsByClassName("ie-Input");
  //     hideElements(x);
  //     console.log("Hiding");
  //     imageElement = false;
  //   }else if (!imageElement){
  //     var x = document.getElementsByClassName("ie-Input");
  //     console.log("Showing");
  //     showElements(x, "flex");
  //     imageElement = true;
  //   }
  // }
  // function hideElements(els){
  //   var i;
  //   for (i = 0; i < els.length; i++) {
  //       els[i].style.display="none";
  //   }
  // }
  // function showElements(els, type = "flex"){
  //   var i;
  //   for (i = 0; i < els.length; i++) {
  //       els[i].style.display=type;
  //   }
  // }
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
