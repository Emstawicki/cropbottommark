<?php
require_once 'cropbottommark.php';

$class = new cropbottommark();

if (isset($_GET['dir']) && $_GET['dir'] != '') :
    $dir = $_GET['dir'];
    
    $class->scanDir($dir);
    $files = $class->dumpFiles();
    
    $i = $class->countFiles();
    
    $time_start = microtime(true);
    
    echo '<a href="?">< Back</a><br>';
    
    echo "[] Start crop $i images <br>";
    ini_set('max_execution_time', 0);
    
    foreach ($files as $file) :
        ob_start();
        if (! $class->fileWasCroped($file)) :
            $class->cropFile($file);
            $subtime = microtime(true) - $time_start;
            echo "[" . $subtime . "] Croping image: <a href=\"" . $file . "\">" . $file . "</a><br>";
         

        else :
            $subtime = microtime(true) - $time_start;
            echo "[" . $subtime . "] Image: <a href=\"" . $file . "\">" . $file . "</a> was croped earlier<br>";
        endif;
        ob_end_flush();
    endforeach
    ;
    
    $time_end = microtime(true);
    $time = $time_end - $time_start;
    $filePerSecond = $i / $time;
    $filePerSecond = round($filePerSecond, 2);
    echo "Finished in " . round($time, 3) . "s // avg: $filePerSecond / sec";
 else :
    $class->getOnlyDirs('imagestocrop');
endif;
?>