<?php

declare(strict_types=1);

namespace AuditLog;

use AuditLog\App\Factory\PdoFactory;
use DI\Definition\Source\DefinitionArray;
use PDO;

use function DI\factory;

/**
 * @internal This class is considered internal and should not be used outside of AuditLog
 */
class ApplicationConfig extends DefinitionArray
{
    public function __construct()
    {
        parent::__construct($this->getConfig());
    }

    public function getConfig(): array
    {
        return [
            PDO::class => factory(new PdoFactory())
        ];
    }
}
