<?php

namespace Mig\Commands;

use Mig\Commands\Command;
use Mig\Migrator;
use Mig\Exceptions\InvalidMigrationFormatException;

class Migrate extends Command
{
	protected $migrated;

	public function __construct(){
		parent::__construct();
		$this->migrated = 0;
	}

    public function run($params = [])
    {
        require_once $this->settings()->path . '/Migrator.php';
        $migrator = new \Migrator();

        // \file_put_contents(__DIR__ . '/../app/migrations/' . date('Y_m_d_H_i_s') . '_aaa.php', 'hell');
        $migrationFiles = glob($this->settings()->path . '/migrations/*');
        foreach ($migrationFiles as $file) {
            if (preg_match('/[\d]+_[a-zA-Z\_\d]*.php/', $file)) {
                $this->migrate($file, $migrator);
            }
		}
		if($this->migrated == 0){
			$this->printer->warning('Nothing to migrate');
		}
		$this->saveHistoryFile();
    }

    public function help()
    {}

    public function migrate($file, $migrator)
    {
        require_once $file;
		$migrator->init();

        $migrationFileName = $this->getMigrationFileName($file);
		
		if(in_array($migrationFileName, array_keys($this->history()['migrations']['files'])) && $this->history()['migrations']['files'][$migrationFileName]['migrated']){
			return;
		}
        $this->printer->warning('Migrating: ' . $migrationFileName);
        preg_match("/\_[a-zA-Z0-9\_]*/", $file, $name);
        $class = $this->getCleanName($name[0]);

		if(! \class_exists($class)){
			throw new InvalidMigrationFormatException ;
		}
		
		$migration = new $class;
		$start = microtime(true);
		$migration->up($migrator);
		$end = microtime(true);

		$duration = $end - $start;

		$this->printer->success('Migrated: ' . $migrationFileName . ' in ' . round($duration, 6) .' sec.');

		$this->migrated++;
		
		$history = $this->history();
		$history['migrations']['files'][$migrationFileName] = [
			'migrated' => true,
			'batch' => $this->history()['migrations']['currentBatch']++
		];

		$this->setHistory($history);
	}
	
	protected function getMigrationFileName($file){
		$migrationFileName = explode($this->settings()->path . '/migrations/', $file);
		return end($migrationFileName);
	}
}
