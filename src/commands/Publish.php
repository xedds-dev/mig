<?php

namespace Mig\Commands;

use Mig\Commands\Command;

class Publish extends Command
{
	function run($params = [])
	{
		$path = "migrations";
		if(! empty($params['path'])){
			$path = $params['path'];
		}
		$this->cpdir(__DIR__ . '/../app', $path);
		copy(__DIR__ . '/../mig-settings.php', 'mig-settings.php');
	}

	function help(){
		$this->printer->out('publish migration folder to desired directory');
	}

	function cpdir($src, $dst) {
  
		// open the source directory 
		$dir = opendir($src);  
	  
		// Make the destination directory if not exist 
		@mkdir($dst);
		// Loop through the files in source directory
		while( $file = readdir($dir) ) {  
	  
			if (( $file != '.' ) && ( $file != '..' )) {  
				if ( is_dir($src . '/' . $file) )  
				{  
	  
					// Recursively calling custom copy function 
					// for sub directory  
					$this->cpdir($src . '/' . $file, $dst . '/' . $file);  
	  
				}  
				else {  
					copy($src . '/' . $file, $dst . '/' . $file);  
				}  
			}  
		}  
	  
		closedir($dir); 
	}
}