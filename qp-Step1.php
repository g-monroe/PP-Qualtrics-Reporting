
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

   if (isset($_SESSION['qp_TOKEN']) && isset($_GET["survey"])){
     $surveyI = $_GET["survey"];
     $api = $_SESSION['qp_TOKEN'];
   $_Qual = new Qualtrics($api, $_Globals, $_Crypto, null, false, null, null, null, null, $_Log);
   if ($_SESSION[$surveyI] === NULL){
        $result = $_Qual->pullResponses($surveyI);
   }else{
     $result = "good";
   }
 }else{
   $_Globals->redirect("qp.php");
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
   <div id="createdCustom" style="display:none;" class="fr-popup fr-desktop fr-active" >
    <span class="fr-arrow" style="margin-left: -5px;"></span>
    <div class="fr-buttons">
       <button id="removeCODE" type="button" tabindex="-1" role="button" class="fr-command fr-btn fr-btn-font_awesome" data-cmd="tableRemove"><i class="fa fa-trash" aria-hidden="true"></i><span class="fr-sr-only">Remove</span></button>
       <button id="afterCODE" type="button" tabindex="-1" role="button" class="fr-command fr-btn fr-btn-font_awesome" data-cmd="tableRemove"><i class="fa fa-caret-right" aria-hidden="true"></i><span class="fr-sr-only">After</span></button>

  </div>
 </div>
   <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
   <script>
   function codeClicked(val){
     console.log(val);
   }

  $(function() {
    $.FroalaEditor.DefineIcon('textICON', {NAME: 'END',template: 'text'});
    $.FroalaEditor.RegisterCommand('END', {
     title: '}',
     focus: true,
     icon: '}',
     undo: true,
     refreshAfterCallback: true,
     callback: function () {
       var idNum = Math.floor(Math.random() * 100000) + 1;
       this.html.insert("<code data-span='" + idNum +"-END' id='END' class='text-info'>}</code><span id='" + idNum +"-END'> </span>");
     }
    });
$.FroalaEditor.DefineIcon('textICON', {NAME: 'IF',template: 'text'});
$.FroalaEditor.RegisterCommand('IF', {
 title: 'IF start',
 focus: true,
 icon: ' IF {',
 undo: true,
 refreshAfterCallback: true,
 callback: function () {
   var idNum = Math.floor(Math.random() * 100000) + 1;
   this.html.insert("<code data-span='" + idNum +"-IF' id='IF' class='text-info'>IF(</code><span id='" + idNum +"-IF'> </span>");
 }
});
$.FroalaEditor.DefineIcon('textICON', {NAME: 'ELSE',template: 'text'});
$.FroalaEditor.RegisterCommand('ELSE', {
 title: 'ELSE',
 focus: true,
 icon: '}else(',
 undo: true,
 refreshAfterCallback: true,
 callback: function () {
   var idNum = Math.floor(Math.random() * 100000) + 1;
   this.html.insert("<code data-span='" + idNum +"-ELSE' id='ELSE' class='text-info'>}else(</code><span id='" + idNum +"-ELSE'> </span>");
 }
});
$.FroalaEditor.DefineIcon('textICON', {NAME: 'END IF',template: 'text'});
$.FroalaEditor.RegisterCommand('ENDIF', {
 title: 'END IF ){',
 focus: true,
 icon: ' ){',
 undo: true,
 refreshAfterCallback: true,
 callback: function () {
   var idNum = Math.floor(Math.random() * 100000) + 1;
   this.html.insert("<code data-span='" + idNum +"-ENDIF' id='ENDIF' class='text-info'>){</code><span id='" + idNum +"-ENDIF'> </span>");
 }
});
$.FroalaEditor.DefineIcon('textICON', {NAME: 'EQUAL',template: 'text'});
$.FroalaEditor.RegisterCommand('EQUAL', {
 title: 'Equal =',
 focus: true,
 icon: ' ===',
 undo: true,
 refreshAfterCallback: true,
 callback: function () {
   var idNum = Math.floor(Math.random() * 100000) + 1;
   this.html.insert("<code data-span='" + idNum +"-EQUAL' id='EQUAL' class='text-warning'>===</code><span id='" + idNum +"-EQUAL'> </span>");
 }
});
    $.FroalaEditor.DefineIcon('blockVar', {NAME: 'wpforms'});
   $.FroalaEditor.RegisterCommand('blockVar', {
     title: 'Block Var',
     focus: true,
     undo: true,
     refreshAfterCallback: true,
     callback: function () {
       this.html.insert('<form id="block" class="border-info rounded bg-white bg-lighten-3 bg-glow"><fieldset class="border-info bg-info bg-lighten-3" id="varName"><label class="border-info bg-primary bg-lighten-3">Variable Name:</label><label class="border-info bg-white bg-lighten-3" id="varIn">~</label></fieldset><ul><li class="border-danger bg-danger bg-lighten-3">~</li></ul></form>');
     }
   });

    $.FroalaEditor.DefineIcon('count', {NAME: 'contao'});
   $.FroalaEditor.RegisterCommand('count', {
     title: 'Count',
     focus: true,
     undo: true,
     refreshAfterCallback: true,
     callback: function () {
       var idNum = Math.floor(Math.random() * 100000) + 1;
       this.html.insert("<code data-span='" + idNum +"-count' id='count' class='text-info'>count(1);</code><span id='" + idNum +"-count'> </span>");
     }
   });
   $.FroalaEditor.DefineIcon('min', {NAME: 'angle-down'});
  $.FroalaEditor.RegisterCommand('min', {
    title: 'Min',
    focus: true,
    undo: true,
    refreshAfterCallback: true,
    callback: function () {
      var idNum = Math.floor(Math.random() * 100000) + 1;
      this.html.insert("<code data-span='" + idNum +"-min' id='min' class='text-blue-grey'>min(1);</code><span id='" + idNum +"-min'> </span>");
    }
  });
  $.FroalaEditor.DefineIcon('max', {NAME: 'angle-up'});
 $.FroalaEditor.RegisterCommand('max', {
   title: 'Max',
   focus: true,
   undo: true,
   refreshAfterCallback: true,
   callback: function () {
     var idNum = Math.floor(Math.random() * 100000) + 1;
     this.html.insert("<code data-span='" + idNum +"-max' id='max' class='text-blue-grey'>max(1);</code><span id='" + idNum +"-max'> </span>");
   }
 });
   $.FroalaEditor.DefineIcon('add', {NAME: 'plus'});
  $.FroalaEditor.RegisterCommand('add', {
    title: 'Addition',
    focus: true,
    undo: true,
    refreshAfterCallback: true,
    callback: function () {
      var idNum = Math.floor(Math.random() * 100000) + 1;
      this.html.insert("<code data-span='" + idNum +"-add' id='add' class='text-success'>add(1);</code><span id='" + idNum +"-add'> </span>");
    }
  });
  $.FroalaEditor.DefineIcon('sub', {NAME: 'minus'});
 $.FroalaEditor.RegisterCommand('sub', {
   title: 'Subtract',
   focus: true,
   undo: true,
   refreshAfterCallback: true,
   callback: function () {
     var idNum = Math.floor(Math.random() * 100000) + 1;
     this.html.insert("<code data-span='" + idNum +"-sub' id='sub' class='text-danger'>sub(1);</code><span id='" + idNum +"-sub'> </span>");
   }
 });
   $.FroalaEditor.DefineIcon('percent', {NAME: 'percent'});
  $.FroalaEditor.RegisterCommand('percent', {
    title: 'Percentage',
    focus: true,
    undo: true,
    refreshAfterCallback: true,
    callback: function () {
      var idNum = Math.floor(Math.random() * 100000) + 1;
      this.html.insert("<code data-span='" + idNum +"-percent' id='percent' class='text-success'>percent(1/1);</code><span id='" + idNum +"-percent'> </span>");
    }
  });
  $.FroalaEditor.DefineIcon('comments', {NAME: 'comments'});
 $.FroalaEditor.RegisterCommand('comments', {
   title: 'Multi-Response',
   focus: true,
   undo: true,
   refreshAfterCallback: true,
   callback: function () {
     var idNum = Math.floor(Math.random() * 100000) + 1;
     this.html.insert("<code data-span='" + idNum +"-multiresponse' id='multi' class='text-primary'>multiResponse(R);</code><span id='" + idNum +"-multiresponse'> </span>");
   }
 });
 $.FroalaEditor.DefineIcon('var', {NAME: 'at'});
$.FroalaEditor.RegisterCommand('var', {
  title: 'Variable',
  focus: true,
  undo: true,
  refreshAfterCallback: true,
  callback: function () {
    var idNum = Math.floor(Math.random() * 100000) + 1;
    this.html.insert("<code data-span='" + idNum +"-var' id='var' class='text-primary'>var(R);</code><span id='" + idNum +"-var'> </span>");
  }
});
    $.FroalaEditor.DefineIcon('my_dropdown', {NAME: 'question'});
     $.FroalaEditor.RegisterCommand('my_dropdown', {
       title: 'Questions',
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
           echo("'".$key."[~`parser`~]".$name."': '".substr($name, 0, 30)."',\n");

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
                 echo("'".$key."_".$ky."[~`parser`~]".$name."--".$nm."': '-→ ".substr($nm, 0, 30)."',\n");
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
                 echo("'".$key."_".$ky."_".$k."[~`parser`~]".$name."--".$nam."': '-↓ ".substr($nam, 0, 30)."',\n");
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
         'NULL': 'N/A'
       },
       callback: function (cmd, val) {
            var res = val.split("[~`parser`~]");
            var vals = res[0];
            var tags = res[1];
            var idNum = Math.floor(Math.random() * 100000) + 1;
           this.html.insert("<code data-span='" + idNum +"-" + vals + "' data-toggle='tooltip' title='" + tags +"' id='" + vals + "'>" + vals + "</code><span id='" + idNum +"-" + vals + "'> </span>");
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
        title: 'Responses',
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
            echo("'R_".$key."[~`parser`~]".$name."': '".substr($name, 0, 30)."',\n");

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
                  echo("'R_".$key."_".$ky."[~`parser`~]".$name."--".$nm."': '-→ ".substr($nm, 0, 30)."',\n");
                  //echo("}");
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
                        echo("'R_".$key."_".$ky."_".$k."[~`parser`~]".$name."--".$nam."': '•-↓ ".substr($nam, 0, 30)."',\n");
                        //echo("}");

                        $index++;
                      }
                  }
                  $indx++;
                }
            }
            $idx++;
          }
         // echo("];

         // </script>");
          //var_dump($_SESSION["q_SV_0wWp6Vlf4raseeV"]["result"]["questions"]);
          //var_dump($_SESSION["SV_0wWp6Vlf4raseeV"]["responses"]);
          ?>
          'NULL': 'N/A'
        },
        callback: function (cmd, val) {
          var res = val.split("[~`parser`~]");
          var vals = res[0];
          var tags = res[1];
          var idNum = Math.floor(Math.random() * 100000) + 1;
         this.html.insert("<code data-span='" + idNum +"-" + vals + "' data-toggle='tooltip' title='" + tags +"' id='" + vals + "'>" + vals + "</code><span id='" + idNum +"-" + vals + "'> </span>");
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
    toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'inlineClass', 'clearFormatting', '|', 'emoticons', 'fontAwesome', 'specialCharacters', '-', 'paragraphFormat', 'lineHeight', 'paragraphStyle', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '|', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', '-', 'insertHR', 'selectAll', 'getPDF', 'print', 'help', 'html', 'fullscreen', '|', 'undo', 'redo', '|', 'my_dropdown', 'my_dropdown2', 'comments', '|', 'blockVar', 'var', 'count', 'percent', 'add', 'sub', 'min', 'max', '|', 'IF', 'ENDIF', 'EQUAL', 'ELSE', 'END']
  })
});
function setCaretPosition(ctrl, pos) {
  var node = ctrl;
  node.focus();
  var textNode = node.firstChild;
  var caret = pos; // insert caret after the 10th character say
  var range = document.createRange();
  range.setStart(textNode, caret);
  range.setEnd(textNode, caret);
  var sel = window.getSelection();
  sel.removeAllRanges();
  sel.addRange(range);
}
var selectedCODE = "NULL";
$(window).click(function(e) {
    var x = e.clientX, y = e.clientY,
    elementMouseIsOver = document.elementFromPoint(x, y);
    var node = elementMouseIsOver;
    var rect = node.getBoundingClientRect();
    x = rect.left;
    y = rect.top;
    if (node.tagName == "CODE"){
      selectedCODE = node;
      var d = document.getElementById("createdCustom");
      d.style.display = "block";
      var wid = (d.offsetWidth / 2);
      console.log(wid);
      d.style.position = "fixed";
      d.style.left = (x)+'px';
      d.style.top = (y + 20)+'px';
      d.style.zIndex = '9999999';
      console.log(node);
    }else{
      var d = document.getElementById("createdCustom");
      d.style.display = "none";
    }
});
document.getElementById("removeCODE").onclick = function(){
    selectedCODE.parentNode.removeChild(selectedCODE);
}
document.getElementById("afterCODE").onclick = function(){
  console.log(selectedCODE.getAttribute("data-span"));
// Set the cursor position of the "#test-input" element to the end when the page loads
var input = document.getElementById(selectedCODE.getAttribute("data-span"));
setCaretPosition(input, 1);
}
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
$questions = $_SESSION["q_".$surveyI]["result"]["questions"];
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
