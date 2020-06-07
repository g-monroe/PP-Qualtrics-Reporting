<?php


function listFolderFiles($dir){
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    // prevent empty ordered elements
    if (count($ffs) < 1)
        return;

  //  echo '<ul>';
    foreach($ffs as $ff){
      
       $dirr = str_replace("/vwh/hs/www.rise.hs.iastate.edu/www/","www.rise.hs.iastate.edu/",$dir);
        echo ''.$dirr."/".$ff;
        echo '</br>';
        if(is_dir($dir.'/'.$ff)){
          listFolderFiles($dir.'/'.$ff);
        }
    }
    //echo '</ul>';
}

listFolderFiles(__DIR__);




 ?>
