<?php 

namespace Mig\Commands;

use Mig\Commands\Command;

class Migrate extends Command
{
	
	function run($params = [])
	{
		$this->printer->magenta('migrating...');
	}

	function help(){}
}