<?php

namespace Mig\Bootstrap;

use Mig\Bootstrap\Printer;

class App
{
    /**
     * @var Mig\Bootstrap\Printer
     */
    public $printer;

    /**
     * @var array
     */
    public $commands;

    /**
     * App constructor
     */
    public function __construct()
    {
        $this->printer = new Printer();
        $this->commands = include __DIR__ . '/registery.php';
    }

    /**
     * Handle incoming request
     *
     * @param array $argv
     * @param array $argc
     * @return callable|void
     */
    public function handle($argv, $argc)
    {
        $command = 'help';

        if ($argc > 1) {
            $command = $argv[1];
        }

        // parsing incomming parameters
        $params = [];
        for ($i = 2; $i < $argc; $i++) {
            $param = explode("=", $argv[$i]);
            if (!empty($param[1])) {
                $params[$param[0]] = $param[1];
            } else {
                $params[$param[0]] = true;
            }
        }

        if (in_array($command, array_keys($this->commands))) {
            return $this->call($this->commands[$command], $params);
        }
        return $this->call($this->commands['help']);
    }

    /**
     * Dispatch command
     *
     * @param string $command
     * @param array $params
     * @return mixed
     */
    protected function call($command, $params = [])
    {
        if (is_callable($command, 'process')) {
			$command = new $command();
			call_user_func_array([$command, 'process'], [$params]);
            try {
            } catch (\Throwable $e) {
                $this->printer->error('Error: ' . $e->getMessage());
            }
        }
    }
}
