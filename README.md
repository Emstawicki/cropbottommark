# cropbottommark
A simple class whereby you can cut bottom part of all images in directory. Example of use is in `index.php` file working at `imagestocrop` folder.
To reset cropped images list, just remove content of `croped.txt` file. You can also add here file exceptions with delimiter `;`

### Example 1 
Loads files from a directory with subfolders
```php
<?php
require_once 'cropbottommark.php';
$class = new cropbottommark();

$dir = '/pathToOurImages';
$class->scanDir($dir);

var_dump($class->dumpFiles());
```
### Example 2
Crop one file
```php
<?php
require_once 'cropbottommark.php';
$class = new cropbottommark();

$file = '/pathToOurImages/example.jpg';

if (!$class->fileWasCroped($file)):
$class->cropFile($file);
endif;
```
### Example 3
Crop all files in directory
```php
<?php
require_once 'cropbottommark.php';
$class = new cropbottommark();

$dir = '/pathToOurImages';
$files = $class->scanDir($dir);

echo 'Images to crop: '.$class->countFiles();

foreach ($files as $file):
	if (! $class->fileWasCroped($file)) :
    	$class->cropFile($file);
        echo 'File '.$file.' cropped success.';
    else:
    	echo 'File '.$file.' was cropped earlier';
    endif;
endforeach;

```
#### Pseudo-benchmark
Class was tested over x files (8.3 GiB) with avarage speed 21 files per second. The limitation is the maximum script execution time . Do not worry, even if you get an error 504 can restart the script , which skips previously cropped pictures .
