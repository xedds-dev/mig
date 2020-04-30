<?php

namespace Mig\Commands;

use Mig\Commands\Command;

class RollBack extends Command
{
	
	function run($params = [])
	{
		$this->printer->yellow('Rollback in progress...');
		$this->printer->purple(json_encode($params));
	}

	function help(){}
}