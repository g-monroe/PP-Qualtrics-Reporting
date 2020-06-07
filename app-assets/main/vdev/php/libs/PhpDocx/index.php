<?php
require_once 'classes/CreateDocx.php';

$docx = new CreateDocxFromTemplate('simpleTemplate.docx');

$html='<style>
ul {color: blue; font-size: 14pt; font-family: Cambria}
td {font-family: Arial}
#redBG {background-color: red; color: #f0f0f0}
table {border: 2px solid green}
.example {color: #777777}
</style>

<p>A normal paragraph.
</p><p class="example">This is a simple paragraph with <strong>text in bold</strong></p>
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
        <td>Cell 1 1</td>
        <td>Cell 1 2</td>
        <td>Cell 1 3</td>
    </tr>
    <tr>
        <td>Cell 2 1</td>
        <td>Cell 2 2</td>
        <td>Cell 2 3</td>
    </tr>
</tbody></table>
<p>And that is it.</p>';

$docx->replaceVariableByHtml('HTMLBLOCK', 'block', $html);

$docx->replaceVariableByHtml('HTMLINLINE', 'inline', $html, array('filter' => '.example'));

$docx->createDocx('simpleTemplateReplaced');
?>
