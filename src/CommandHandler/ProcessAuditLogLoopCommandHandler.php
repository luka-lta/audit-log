<?php

declare(strict_types=1);

namespace AuditLog\CommandHandler;

use AuditLog\Queue\AuditLogQueue;
use Psr\Container\ContainerInterface;

class ProcessAuditLogLoopCommandHandler
{
    private AuditLogQueue $auditLogQueue;

    public function __construct(ContainerInterface $container)
    {
        $this->auditLogQueue = $container->get(AuditLogQueue::class);
    }

    public function processNextAuditLogs(): void
    {
        while (!$this->auditLogQueue->isEmpty()) {
            $this->auditLogQueue->processQueue();
        }
    }
}
