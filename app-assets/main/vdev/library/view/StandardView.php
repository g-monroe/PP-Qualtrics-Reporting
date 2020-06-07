<?php

require_once(ROOT.ASSETS."main/".VERSION."library/view/".'PageView.php');

/**
 * StandardView Class
 * This class defines a defualt View
 * Used for pages that don't need to access the database
 *
 * author: Emmanuel Owusu
 * created: 2/17/2008
 */
class StandardView extends PageView {

    function __construct($title = "Untitled Page | RISE", $content = '<strong> Blank Page </strong>', $dev = false) {
    	$this->dev = $dev;
		parent::Begin();
			$this->appendComponents (array(
			  "META" 		=> META,
			  "LINK" 		=> LINK,
			  "SCRIPT" 		=> SCRIPT,
			  "TITLE" 		=> $title,
			  "HEADER" 		=> HEADER,
			  "CONTENT" 	=> $content,
			  "TOPBAR" 	    => TEMPLATE_COMPONENTS_DIR. 'topbar.php',
			  "SIDEBAR" 	=> TEMPLATE_COMPONENTS_DIR. 'sidebar.php',
			  "FOOTER" 		=> FOOTER
			));
    }

}
 ?>
