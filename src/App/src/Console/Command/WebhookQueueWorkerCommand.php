<?php

declare(strict_types=1);

namespace App\Console\Command;

use App\Console\Workers\WebhookQueueWorker;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use const PHP_EOL;

class WebhookQueueWorkerCommand extends Command
{
    /** @var string  */
    protected static $defaultName = 'app:webhook-queue-worker';

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     * Задает параметры команды
     */
    protected function configure(): void
    {
        $this->setName(self::$defaultName);
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);

        $io->title('Starting Webhook Queue Worker');

        try {
            /** @var WebhookQueueWorker $worker */
            $worker = $this->container->get(WebhookQueueWorker::class);
            $worker->execute(new ConsoleOutput());
        } catch (Exception | NotFoundExceptionInterface | ContainerExceptionInterface $e) {
            $io->error('Error starting the Webhook Queue Worker: ' . PHP_EOL . $e->getTraceAsString());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
