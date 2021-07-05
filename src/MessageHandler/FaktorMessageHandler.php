<?php

/**
 * @file
 * Handle faktor messages from queue system.
 */

namespace App\MessageHandler;

use App\Message\FaktorMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class CoverStoreProcessor.
 */
class FaktorMessageHandler implements MessageHandlerInterface
{
    private $bus;
    private $logger;

    /**
     * CoverStoreProcessor constructor.
     *
     * @param MessageBusInterface $bus
     * @param LoggerInterface $informationLogger
     */
    public function __construct(MessageBusInterface $bus, LoggerInterface $informationLogger)
    {
        $this->bus = $bus;
        $this->logger = $informationLogger;
    }

    /**
     * @param FaktorMessage $message
     *
     * @return mixed
     */
    public function __invoke(FaktorMessage $message)
    {
        // @TODO: Do something with the message
    }
}
