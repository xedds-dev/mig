<?php

namespace Mig\Commands;

use Mig\Commands\Command;

class RollBack extends Command
{

	public function __construct(){
		parent::__construct();
		$this->rolledBack = 0;
	}
    public function run($params = [])
    {
        require_once $this->settings()->path . '/Migrator.php';
        $migrator = new \Migrator();

        $this->printer->warning("Rolling in progress...");

        $currentBatch = $this->history()['migrations']['currentBatch'];
		$latestsMigrations = array_reverse($this->history()['migrations']['files'], true);
        foreach ($latestsMigrations as $key => $file) {
        	if($file['batch'] == $currentBatch && $file['migrated']) {
        		$this->rollback($key, $migrator);
        	}
        }
        if($this->rolledBack == 0) {
        	$this->printer->purple("nothing to be rolledback !");
        }
    }

    public function help()
    {}

    private function rollback($file, $migrator){

    	// die($file);
    	require_once $this->settings()->path . '/migrations/' . $file;
		
        $migrator->init();

        $migrationFileName = $this->getMigrationFileName($file);
		
        $this->printer->warning('Rolling Back: ' . $migrationFileName);
        preg_match("/\_[a-zA-Z0-9\_]*/", $file, $name);
        $class = $this->getCleanName($name[0]);

		if(! \class_exists($class)){
			throw new InvalidMigrationFormatException ;
		}
		
		$migration = new $class;
		$start = microtime(true);
		$migration->down($migrator);
		$end = microtime(true);

		$duration = $end - $start;

		$this->printer->success('Rolled Back: ' . $migrationFileName . ' in ' . round($duration, 6) .' sec.');

		$this->rolledBack++;
		
		$history = $this->history();
		$history['migrations']['files'][$migrationFileName] = [
			'migrated' => false,
			'batch' => 'rolled'
		];

		$this->setHistory($history);
	}
	
	protected function getMigrationFileName($file){
		$migrationFileName = explode($this->settings()->path . '/migrations/', $file);
		return end($migrationFileName);
	}
}
