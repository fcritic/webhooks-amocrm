<?php

declare(strict_types=1);

namespace Sync\Console\Workers;

use Pheanstalk\Contract\PheanstalkInterface;
use Pheanstalk\Job;
use Pheanstalk\Pheanstalk;
use Symfony\Component\Console\Output\OutputInterface;
use Sync\config\BeanstalkConfig;
use Throwable;

use function json_decode;

use const JSON_THROW_ON_ERROR;
use const PHP_EOL;

abstract class AbstractWorker
{
    /** @var Pheanstalk Текущее подключение к серверу очередей */
    protected Pheanstalk $connection;

    /** @var string Просматриваемая очередь */
    protected string $queue = 'default';

    /** Constructor AbstractWorker */
    public function __construct(BeanstalkConfig $beanstalk)
    {
        $this->connection = $beanstalk->getConnection();
    }

    /**
     * Вызов через CLI
     *
     * Тут -> конектимся с сервером очередей
     * -> Просматриваем только текущею очередь
     * -> Игнорируем дефолтную очередь
     * -> Ожидаем задачи в очередь
     */
    public function execute(OutputInterface $output): void
    {
        while (
            $job = $this->connection
            ->watchOnly($this->queue)
            ->ignore(PheanstalkInterface::DEFAULT_TUBE)
            ->reserve()
        ) {
            try {
                    $this->process(json_decode(
                        $job->getData(),
                        true,
                        512,
                        JSON_THROW_ON_ERROR
                    ), $output);
            } catch (Throwable $e) {
                $this->handleException($e, $job);
            }
            $this->connection->delete($job);
        }
    }

    /** Вывод ошибок */
    private function handleException(Throwable $exception, Job $job): void
    {
        echo 'Error Unhandled exception' . $exception . PHP_EOL . $job->getData();
    }

    /** Обработка задачи */
    abstract public function process(mixed $data, OutputInterface $output): void;
}
