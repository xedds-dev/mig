<?php

namespace Mig\Commands;

use Mig\Bootstrap\Printer;
use Mig\Exceptions\SettingsNotPublishedException;

abstract class Command
{
	public $printer;
    protected $settings;
    protected $history;

    public function __construct()
    {
        $this->printer = new Printer();
        $this->printer->newLine();
    }

    public function process($params = [])
    {
        // $this->printer->error('loading..');
        if (isset($params['help']) and $params['help'] == true) {
            return $this->help();
        }
        return $this->run($params);
    }

    public function settings()
    {
		if(empty($this->settings)){
			if (file_exists('mig.json') and $settings = file_get_contents('mig.json')) {
				$this->settings = json_decode($settings);
			} else {
				throw new SettingsNotPublishedException;
			}
		}
		
		return $this->settings;
    }
    
    public function history()
    {
		if(empty($this->history)){
			if (file_exists($this->path('history.json')) and $history = file_get_contents($this->path('history.json'))) {
				$this->history = json_decode($history, true);
			} else {
                $this->history = [
                    'migrations' => 
                    [
                        'files' => [],
                        'currentBatch' => 0
                    ],
                    'seeders' =>
                    [
                        'files' =>[],
                        'currentBatch' => 0
                    ]
                ];
            }
		}
        
		return $this->history;
    }

    public function setHistory($history){
        $this->history = $history;
        $this->saveHistoryFile();
    }
    public function saveHistoryFile(){
        \file_put_contents($this->path('history.json'), json_encode($this->history, JSON_PRETTY_PRINT));
    }
    
    public function path($path){
        return $this->settings()->path . ($path[0] == '/' ? '' : '/') . $path;
    }
	
	protected function getCleanName($name)
    {
        return str_replace('_', '', ucwords($name, '_'));
    }

    abstract public function run($params = []);
    abstract public function help();
}
