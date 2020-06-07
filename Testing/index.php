<?php
 session_start();
require_once 'results/CreateDocx.php';

$docx = new CreateDocx();

$html='<p style="text-align: center;">This is a report.</p>

<blockquote>

	<p style="text-align: center;"><strong><em><span style="font-family: Georgia, serif; font-size: 24px;">This is another report.</span></em></strong></p>
</blockquote>

<img src="http://www.rise.hs.iastate.edu/projects/360/360_logo.jpg" style="width: 300px; float:right; text-align:right;" class="fr-fic fr-dib fr-fir">

<p><a href="https://google.com">google.com</a></p>

<table style="width: 100%;">
	<tbody>
		<tr>
			<td class="fr-thick-0px" style="width: 28.1594%;">
				<br>
			</td>
			<td style="width: 12.1391%; background-color: rgb(124, 112, 107);">
				<div style="text-align: center;"><span style="color: rgb(255, 255, 255);"><strong><u>Heyyy</u></strong></span></div>
			</td>
			<td style="width: 23.5819%; background-color: rgb(163, 143, 132);">
				<div style="text-align: center;"><span style="color: rgb(255, 255, 255);"><strong><u>Heyy</u></strong></span></div>
			</td>
			<td style="width: 17.6262%; background-color: rgb(124, 112, 107);">
				<div style="text-align: center;"><span style="color: rgb(255, 255, 255);"><strong><u>Heyyy</u></strong></span></div>
			</td>
			<td style="width: 2.1322%; background-color: rgb(163, 143, 132);">
				<div style="text-align: center;"><span style="color: rgb(255, 255, 255);"><strong><u>Heyy</u></strong></span></div>
			</td>
			<td style="width: 16.6667%; background-color: rgb(124, 112, 107);">
				<div style="text-align: center;"><span style="color: rgb(255, 255, 255);"><strong><u>Heyyy</u></strong></span></div>
			</td>
		</tr>
		<tr>
			<td style="width: 28.1594%; background-color: rgb(226, 80, 65);"><code id="QID3"><span style="font-family: Impact, Charcoal, sans-serif; color: rgb(255, 255, 255);">QID3</span></code></td>
			<td style="width: 12.1391%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
			<td style="width: 23.5819%; background-color: rgb(209, 213, 216);">
				<br>
			</td>
			<td style="width: 17.6262%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
			<td style="width: 2.1322%; background-color: rgb(209, 213, 216);">
				<br>
			</td>
			<td style="width: 16.6667%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
		</tr>
		<tr>
			<td class="fr-highlighted fr-thick" style="width: 28.1594%; background-color: rgb(226, 80, 65);"><code id="QID3_1">QID3_1</code></td>
			<td style="width: 12.1391%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
			<td style="width: 23.5819%; background-color: rgb(209, 213, 216);">
				<br>
			</td>
			<td style="width: 17.6262%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
			<td style="width: 2.1322%; background-color: rgb(209, 213, 216);">
				<br>
			</td>
			<td style="width: 16.6667%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
		</tr>
		<tr>
			<td style="width: 28.1594%; background-color: rgb(226, 80, 65);"><code id="QID3_3">QID3_3</code></td>
			<td style="width: 12.1391%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
			<td style="width: 23.5819%; background-color: rgb(209, 213, 216);">
				<br>
			</td>
			<td style="width: 17.6262%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
			<td style="width: 2.1322%; background-color: rgb(209, 213, 216);">
				<br>
			</td>
			<td style="width: 16.6667%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
		</tr>
		<tr>
			<td style="width: 28.1594%; vertical-align: middle; background-color: rgb(26, 188, 156);"><code id="QID3_4">QID3_4</code></td>
			<td style="width: 12.1391%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
			<td style="width: 23.5819%; background-color: rgb(209, 213, 216);">
				<br>
			</td>
			<td style="width: 17.6262%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
			<td style="width: 2.1322%; background-color: rgb(209, 213, 216);">
				<br>
			</td>
			<td style="width: 16.6667%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
		</tr>
		<tr>
			<td style="width: 28.1594%; background-color: rgb(226, 80, 65);"><code id="QID3_6">QID3_6</code></td>
			<td style="width: 12.1391%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
			<td style="width: 23.5819%; background-color: rgb(209, 213, 216);">
				<br>
			</td>
			<td style="width: 17.6262%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
			<td style="width: 2.1322%; background-color: rgb(209, 213, 216);">
				<br>
			</td>
			<td style="width: 16.6667%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
		</tr>
		<tr>
			<td style="width: 28.1594%; background-color: rgb(226, 80, 65);"><code id="QID3_6">QID3_6</code></td>
			<td style="width: 12.1391%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
			<td style="width: 23.5819%; background-color: rgb(209, 213, 216);">
				<br>
			</td>
			<td style="width: 17.6262%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
			<td style="width: 2.1322%; background-color: rgb(209, 213, 216);">
				<br>
			</td>
			<td style="width: 16.6667%; background-color: rgb(204, 204, 204);">
				<br>
			</td>
		</tr>
	</tbody>
</table>

';
$dom = new DOMDocument;
$dom->loadHTML($html);
$indx = 1;
foreach($dom->getElementsByTagName('code') as $node)
{
    $array[] = $dom->saveHTML($node);
    $id = $node->getAttribute('id');
    //echo($node->childNodes->length);
      do{
        var_dump($node->firstChild);
        $node = $node->firstChild;
      }while($node->firstChild !== NULL);
    $questions = $_SESSION["q_SV_0wWp6Vlf4raseeV"]["result"]["questions"];
  //  echo($questions);
    foreach ($questions as $key => $value) {
      $name = $questions[$key]["questionText"];
      $name = strip_tags($name);
      $name = preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $name));
      $name = strip_tags($name);

  //  echo($key."<br/>");
      if ($key == $id){

        //echo($name."<br/>");
      //echo($node->nodeValue."<br/>");
        $node->nodeValue = $name;
        echo($key."====".$id."=====".$name."<br/>");
      }
      if ($questions[$key]["subQuestions"] !== NULL){
          $subs = $questions[$key]["subQuestions"];
          foreach ($subs as $ky => $val) {
            $nm = $subs[$ky]["choiceText"];
            $nm = strip_tags($nm);
            $nm = preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $nm));
            $nm = strip_tags($nm);
            $kyy = $key."_".$ky;
            if ($kyy == $id){
            //  echo($name."<br/>");
            //  echo($node->nodeValue."<br/>");
              $node->nodeValue = $nm;
            //  echo($node->nodeValue."<br/>");
            }
          }
      }
    }

}

print_r($array);
$html = $dom->saveHTML();
$docx->embedHTML($html);
$docx->createDocx('simpleHTMLTest');
?>
