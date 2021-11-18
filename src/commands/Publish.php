<?php

namespace Mig\Commands;

use Mig\Commands\Command;

class Publish extends Command
{
    public function run($params = [])
    {
		if (@$settings = file_get_contents('mig.json')){
			
			$settings = json_decode($settings);
			if($settings->published == true){
				$this->printer->error('Files were Published Before!');
				return ;
			}
			
		}
		
		
		$path = "migrations";
		
		if (!empty($params['path'])) {
            $path = $params['path'];
		}
		
		$this->cpdir(__DIR__ . '/../app', $path);
		
		$settings = json_encode([
			'path' => $path,
			'published' => true
		]);

		file_put_contents('mig.json', $settings);
		
		$this->printer->success('Files published successfully!');
    }

    public function help()
    {
        $this->printer->out('publish migration folder to desired directory');
    }

    public function cpdir($src, $dst)
    {

        // open the source directory
        $dir = opendir($src);

        // Make the destination directory if not exist
        @mkdir($dst);
        // Loop through the files in source directory
        while ($file = readdir($dir)) {

            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {

                    // Recursively calling custom copy function
                    // for sub directory
                    $this->cpdir($src . '/' . $file, $dst . '/' . $file);

                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }

        closedir($dir);
    }
}
