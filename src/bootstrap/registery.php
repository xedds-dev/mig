<?php 

/****************************************************************
 * Registery array to map avialable commands to their respective
 * classes
 * **************************************************************
 */
return [
    'migrate' => '\Mig\Commands\Migrate',
    'rollback' => '\Mig\Commands\Rollback',
    'help' => '\Mig\Commands\Help',
    'publish' => '\Mig\Commands\Publish'
];