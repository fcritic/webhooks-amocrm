<?php

declare(strict_types=1);

namespace App\config;

use Pheanstalk\Pheanstalk;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class BeanstalkConfig
{
    private ?Pheanstalk $connection;
    public function __construct(ContainerInterface $container)
    {
        try {
            $this->connection = Pheanstalk::create(
                $container->get('config')['beanstalk']['host'],
                $container->get('config')['beanstalk']['port'],
                $container->get('config')['beanstalk']['timeout']
            );
        } catch (NotFoundExceptionInterface | ContainerExceptionInterface $e) {
            exit('BeanstalkConfig ' . $e->getMessage());
        }
    }

    public function getConnection(): ?Pheanstalk
    {
        return $this->connection;
    }
}
