<?php

declare(strict_types=1);

namespace AuditLog\Controller;

use AuditLog\CommandHandler\ProcessAuditLogLoopCommandHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessAuditLogLoopController extends Command
{
    public const COMMAND_NAME = 'process-audit-log-loop';

    public function __construct(
        private readonly ProcessAuditLogLoopCommandHandler $commandHandler,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandHandler->processNextAuditLogs();

        return Command::SUCCESS;
    }
}
