<?php

namespace Mig;

abstract class AbstractMigrator
{
    public $builder;
    abstract public function init();
}