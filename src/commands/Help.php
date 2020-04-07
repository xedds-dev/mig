<?php

namespace Mig\Commands;

use Mig\Commands\Command;

class Help extends Command
{
	function run($params = [])
	{
		$this->printer->newLine();
		$this->printer->info("mig v0.0.1 from xedds");
	}

	function help(){}
}