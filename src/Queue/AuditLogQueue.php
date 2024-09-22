<?php

declare(strict_types=1);

namespace AuditLog\Queue;

use AuditLog\Repository\AuditLogRepository;
use AuditLog\Value\AuditLog;

class AuditLogQueue
{
    private array $queue = [];

    public function __construct(
        private readonly AuditLogRepository $auditLogRepository
    ) {
    }

    public function push(AuditLog $auditLog): void
    {
        $this->queue[] = $auditLog;
    }

    public function processQueue(): void
    {
        while (!empty($this->queue)) {
            $auditLog = array_shift($this->queue);
            $this->save($auditLog);
        }
    }

    private function save(AuditLog $auditLog): void
    {
        $this->auditLogRepository->save($auditLog);
    }

    public function isEmpty(): bool
    {
        return empty($this->queue);
    }
}
