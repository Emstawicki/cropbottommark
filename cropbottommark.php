<?php

/**
 * Cuts (crop) a bottom part of images
 * for example watemarks etc
 * 
 * @author emstawicki
 *
 */
class cropbottommark
{
    
    // CAN BE CONFIGURED:
    public $cut = 36;
 // HEIGHT IN PX
                      // END
    public $files = array();

    public $cropedfiles = array();

    public $dirs = array();

    function __construct()
    {
        $this->cropedFiles();
    }

    /**
     * Gets all files (with sub-folders) to array
     * 
     * @param string $dir            
     */
    function scanDir($dir)
    {
        $rows = scandir($dir);
        foreach ($rows as $row) {
            if ($row != '.' && $row != '..') {
                if (is_file($dir . '/' . $row))
                    $this->files[] = $dir . '/' . $row;
                if (is_dir($dir . '/' . $row))
                    $this->scanDir($dir . '/' . $row);
            }
        }
    }

    /**
     * Helper to display available dirs
     * 
     * @param string $dir            
     */
    function getOnlyDirs($dir)
    {
        $rows = scandir($dir);
        echo "<ul>";
        foreach ($rows as $row) {
            if ($row != '.' && $row != '..') {
                if (! is_file($dir . '/' . $row))
                    echo '<li><a href="?dir=' . $dir . '/' . $row . '">' . $dir . '/' . $row . '</a></li>';
                if (is_dir($dir . '/' . $row))
                    $this->getOnlyDirs($dir . '/' . $row);
            }
        }
        echo "</ul>";
    }

    /**
     * Return files array
     * 
     * @return string[]
     */
    function dumpFiles()
    {
        return $this->files;
    }

    /**
     * Returns count of files
     * 
     * @return int
     */
    function countFiles()
    {
        return count($this->files);
    }

    /**
     * Gets croped files
     */
    function cropedFiles()
    {
        $file = file("croped.txt");
        $this->cropedfiles = explode(";", $file[0]);
        return $this->cropedfiles;
    }

    /**
     * Crop image with PHP GD Lib
     * 
     * @param string $file            
     */
    function cropFile($file)
    {
        list ($width, $height) = getimagesize($file);
        $offset_x = 0;
        $offset_y = 0;
        $new_height = $height - $this->cut;
        $new_width = $width;
        $image = imagecreatefromjpeg($file);
        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopy($new_image, $image, 0, 0, $offset_x, $offset_y, $width, $height);
        imagejpeg($new_image, $file);
        $this->markAsCroped($file);
    }

    /**
     * Returns if file was croped
     * 
     * @param string $file            
     * @return boolean
     */
    function fileWasCroped($file)
    {
        return (in_array($file, $this->cropedfiles));
    }

    /**
     * Set file as croped
     * 
     * @param string $file            
     */
    function markAsCroped($file)
    {
        $db = 'croped.txt';
        $file .= ';';
        file_put_contents($db, $file, FILE_APPEND | LOCK_EX);
    }
}
    
    