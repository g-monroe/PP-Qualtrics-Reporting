<?php


/**
 * Abstract View Class
 * Implements commom View components
 *
 * author: Emmanuel Owusu
 * created: 2/13/2008
 */
abstract class PageView {

   /**
    * $output - page source code is stored here (html)
    */
    private $source;

   /**
	* this constructor intializes $source with the contents of $template
	* param - template to be used.
	*/
	function Begin($template = TEMPLATE) {
		if (file_exists($template)) $this->source = join("", file($template));
		else exit("File not found: $template");
	}

  /**
   * Replaces the template file's tags with associated data
   */
  public function appendComponents($tags = array()) {
    if (count($tags) > 0)
      foreach ($tags as $tag => $data) {
		$this->parse($data);
        $this->source = str_replace("{".$tag."}", $data, $this->source);
      }
    else exit("Please define tags");
  }

  /**
   * If $data is a file:
   * this method evaluates the file and sets $data to the output
   */
  private function parse(&$data) {
  	if(@file_exists($data)) {
		ob_start();
		include($data);
		$data = ob_get_contents();
		ob_end_clean();
	}
  }

   /**
    * Returns the rendered HTML
    * @return string
    */
    public function display () {
        return $this->source;
    }


}// end PageView


 ?>
