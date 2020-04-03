<?php

namespace Mig;

class Installer
{
	public static function publish(){
		copy('./src/mig', '../../../mig');
	}
}