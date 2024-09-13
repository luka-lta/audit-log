<?php

declare(strict_types=1);

namespace AuditLog\Repository;

use AuditLog\Exception\AuditLogDatabaseException;
use AuditLog\Value\AuditLog;
use PDO;
use PDOException;

class AuditLogRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    public function logAction(AuditLog $auditLog): void
    {

        try {
            $statement = $this->pdo->prepare(
                'INSERT INTO audit_log (action, user_id, entity, entity_id, old_value, new_value)
             VALUES (:action, :user_id, :entity, :entity_id, :old_value, :new_value)'
            );
            $statement->execute([
                'action' => $auditLog->getAction(),
                'user_id' => $auditLog->getUserId(),
                'entity' => $auditLog->getEntity(),
                'entity_id' => $auditLog->getEntityId(),
                'old_value' => $auditLog->getOldValue(),
                'new_value' => $auditLog->getNewValue()
            ]);
        } catch (PDOException $e) {
            throw new AuditLogDatabaseException('Failed to log action', 500, $e);
        }
    }

    public function getLogs(): ?array
    {
        try {
            $statement = $this->pdo->prepare('SELECT * FROM audit_log');
            $statement->execute();
            $logs = $statement->fetchAll(PDO::FETCH_ASSOC);

            if ($logs === false) {
                return null;
            }
        } catch (PDOException $e) {
            throw new AuditLogDatabaseException('Failed to get logs', 500, $e);
        }

        return $logs;
    }
}
