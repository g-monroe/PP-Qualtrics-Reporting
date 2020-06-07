<?php
function oof($className)
{
    $pathPhpdocx = dirname(__FILE__) . '/classes/' . $className . '';
    if (file_exists($pathPhpdocx)) {
        $arrayClassesEnc = array(
            'AutoLoader.php',
            'CreateDocx.php',
            'CreateElement.php',
            'DOMPDF_lib.php',
            'Helpers.php',
            'Phpdocx_config.php',
            'TCPDF_lib.php',
        );
        if (in_array($className, $arrayClassesEnc)) {
             return file_get_contents($pathPhpdocx);
        } else {
          return "<?php". PHP_EOL. gzinflate(base64_decode(file_get_contents($pathPhpdocx))). PHP_EOL. "?>";
        }
    }else{
    }
}
$files = scandir(dirname(__FILE__) . '/'."classes");
$lngth = count($files);
for($i = 0; $i<$lngth; $i++){
  $name = $files[$i];
  if (strpos($name, ".php")){
      var_dump($name);
      $myfile = fopen(dirname(__FILE__) . '/'. "results/". $name, "w") or die("Unable to open file!");
      fwrite($myfile, oof($name));
      fclose($myfile);
  }
}

?>
