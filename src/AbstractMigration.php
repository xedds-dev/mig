<?php 

namespace Mig;

use Mig\AbstractMigrator;

abstract class AbstractMigration {
    abstract public function up(AbstractMigrator $migrator);
    abstract public function down(AbstractMigrator $migrator);
}