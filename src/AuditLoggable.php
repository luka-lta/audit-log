<?php

declare(strict_types=1);

namespace AuditLog;

use AuditLog\Queue\AuditLogQueue;
use AuditLog\Value\AuditLog;

abstract class AuditLoggable
{
    public function __construct(
        private readonly AuditLogQueue $auditLogQueue
    ) {
    }

    public function addToQueue(
        string $action,
        int $requesterId,
        string $entity,
        int $entityId,
        string $oldValue,
        string $newValue,
    ): void {
        $auditLog = AuditLog::from(
            $action,
            $requesterId,
            $entity,
            $entityId,
            $oldValue,
            $newValue,
        );

        $this->auditLogQueue->push($auditLog);
    }
}
