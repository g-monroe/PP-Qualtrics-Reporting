
<?php
 session_start();
 define("CONFIG", "DATABASE");
 use PhpOffice\PhpWord\PhpWord;
 use PHPHtmlParser\Dom;
 //-Import Conf.
 include("config/vdev.php");
 define(DBCON_PASS, true);
 include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Globals.class.php");
 include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Account.class.php");
 include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Log.class.php");
 include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Qualtrics.class.php");
 include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/bootstrap.php");
 $_Globals = new Globals();
 $_Log = new Log();
 $_Crypto = new Crypto();
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

$phpWord = new \PhpOffice\PhpWord\PhpWord();
$docx = new CreateDocx();
// $html = '<p style="text-align: center;"><span style="font-family: Impact, Charcoal, sans-serif; font-size: 36px;">Hey This is a test.</span></p>
//
// <p style="text-align: center;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 24px;">This is a test of a paragraph that we need to do things its just how it is. Look at this is such amazing magic that we can do this <span style="color: purple;">w</span><span style="color: #4286f4;">i</span><span style="color: rgb(209, 72, 65);"><em>th</em></span><span style="color: rgb(41, 105, 176);"><u>ou</u></span><span style="color: rgb(97, 189, 109);">t</span> <strong><span style="color: red;">any coding</span></strong> :).</span>
// </p>
// ';
$html='<style>

ul {color: blue; font-size: 14pt; font-family: Cambria}

table {border: 1px solid green}

td {font-family: Arial}

#redBG {background-color: red; color: #f0f0f0}

.firstP {margin-left: 220px}

</style>


<p class="firstP">This is a simple paragraph with <strong>text in bold</strong>.</p>

<p>Now we include a list:</p>

<ul>

    <li>First item.</li>

    <li>Second item with subitems:

        <ul>

            <li style="color: red">First subitem.</li>

            <li>Second subitem.</li>

        </ul>

    </li>

    <li id="redBG">Third subitem.</li>

</ul>

<p>And now a table:</p>

<table>

    <tbody><tr>

        <td style="background-color: #ffff00">Cell 1 1</td>

        <td>Cell 1 2</td>

    </tr>

    <tr>

        <td>Cell 2 1</td>

        <td>Cell 2 2</td>

    </tr>

</tbody></table>';


/* Note: any element you append to a document must reside inside of a Section. */
//$section = $phpWord->addSection();
$docx->embedHTML($html);


$docx->createDocx('simpleHTML');
//\PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);

// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('helloWorld2.docx');
$dom = new Dom;
$dom->load('<div class="all"><p>Hey bro, <a href="google.com">click here</a><br /> :)</p></div>');
$a   = $dom->find('a')[0];
$tag = $a->getTag();
$tag->setAttribute('class', 'foo');
echo $a->getAttribute('class'); // "foo"
/* Note: we skip RTF, because it's not XML-based and requires a different example. */
/* Note: we skip PDF, because "HTML-to-PDF" approach is used to create PDF documents. */
 ?>

<?php
 /*********************************************/
 $content = ob_get_contents();
 ob_end_clean();
 $title = "Qualports - Dashboard";
 $page = new StandardView($title, $content);
 echo $page->display();
  ?>
