<?php

namespace Mig\Commands;

use Mig\Commands\Command;
use Mig\Exceptions\InvalidMigrationNameException;
use Mig\Exceptions\InvalidSeederNameException;

class Create extends Command
{

    public function run($params = [])
    {
        // if (!empty($params['-m']) || !empty($params['--migration']) || !empty($params['-s']) || !empty($params['-seeder'])) {
        //     if (empty($params['name'])) {
        //         $this->printer->error('Migration/Seeder name is missing');
        //         return;
        //     }
        //     $name = str_replace('_', '', ucwords($params['name'], '_'));
        //     echo $name;
        // } else {
        //     $this->printer->error('Type is missing');
        //     return;
        // }

        if (!empty($params['-m']) || !empty($params['-migration']) || !empty($params['--migration'])) {
            if (!empty($params['name']) and !$this->isNameInUse($params['name'], 'migrations')) {
                return $this->migration($params['name']);
            } else {
                throw new InvalidMigrationNameException;
            }
        } else if (!empty($params['-s']) || !empty($params['-seeder']) || !empty($params['--seeder'])) {
            if (!empty($params['name']) and !$this->isNameInUse($params['name'], 'seeders')) {
                return $this->seeder($params['name']);
            } else {
                throw new InvalidSeederNameException;
            }
        } else {
            $this->printer->error('Type is missing');
        }
    }

    public function help()
    {}

    protected function isNameInUse($name, $type)
    {
        $occurences = glob($this->settings()->path . '/' . $type . '/*');
        foreach($occurences as $file) {
			if(preg_match('/[\d]+_'.$name.'.php/', $file)) {
				return true;
			}
        }
        return false;
    }

    protected function migration($name)
    {
        $content = \file_get_contents(__DIR__ . '/../templates/example-mig.txt');
        $content = \str_replace('NAME', $this->getCleanName($name), $content);
        $fileName = time() . '_' . $name . '.php';
        if (file_put_contents($this->settings()->path . '/migrations/' . $fileName, $content)) {
            $this->printer->success('Migration Created:' . $fileName);
        }
    }
    protected function seeder($name)
    {
        // echo $name;
    }
}
