<?php 

namespace Mig\Commands;

use Mig\Bootstrap\Printer;

abstract class Command
{
	public $printer;

	function __construct(){
		$this->printer = new Printer();
	}

	function process($params = []){
		$this->printer->error('loading..');
		if(isset($params['help']) AND $params['help'] == true){
			return $this->help();
		}
		return $this->run($params);
	}

	abstract function run($params = []);
	abstract function help();
}