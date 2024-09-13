<?php

declare(strict_types=1);

namespace AuditLog\Service;

use AuditLog\Exception\AuditLogNotFoundException;
use AuditLog\Repository\AuditLogRepository;
use AuditLog\Value\AuditLog;

class AuditLogService
{
    public function __construct(
        private readonly AuditLogRepository $auditLogRepository
    ) {
    }

    public function logAction(
        string $action,
        int $userId,
        string $entity,
        int $entityId,
        string $oldValue,
        string $newValue
    ): void {
        $this->auditLogRepository->logAction(
            AuditLog::from(
                $action,
                $userId,
                $entity,
                $entityId,
                $oldValue,
                $newValue
            )
        );
    }

    public function getLogs(): array
    {
        $logs = $this->auditLogRepository->getLogs();

        if ($logs === null) {
            throw new AuditLogNotFoundException('No logs found', 404);
        }

        return $logs;
    }
}
