<?php

declare(strict_types=1);

namespace AuditLog\Value;

use DateTimeImmutable;

class AuditLog
{
    private function __construct(
        private readonly ?int $auditLogId,
        private readonly string $action,
        private readonly int $userId,
        private readonly string $entity,
        private readonly int $entityId,
        private readonly string $oldValue,
        private readonly string $newValue,
        private readonly ?DateTimeImmutable $createdAt = null,
    ) {
    }

    public static function from(
        string $action,
        int $userId,
        string $entity,
        int $entityId,
        string $oldValue,
        string $newValue,
    ): self {
        return new self(
            null,
            $action,
            $userId,
            $entity,
            $entityId,
            $oldValue,
            $newValue,
        );
    }

    public static function fromDatabase(array $payload): self
    {
        return new self(
            $payload['id'],
            $payload['action'],
            $payload['user_id'],
            $payload['entity'],
            $payload['entity_id'],
            $payload['old_value'],
            $payload['new_value'],
            new DateTimeImmutable($payload['created_at']),
        );
    }

    public function getAuditLogId(): int
    {
        return $this->auditLogId;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function getEntityId(): int
    {
        return $this->entityId;
    }

    public function getOldValue(): string
    {
        return $this->oldValue;
    }

    public function getNewValue(): string
    {
        return $this->newValue;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
