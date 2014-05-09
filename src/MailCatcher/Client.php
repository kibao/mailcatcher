<?php

/*
 * This file is part of the MailCatcher package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Kibao\MailCatcher;

use Kibao\MailCatcher\Connection\ConnectionInterface;
use Kibao\MailCatcher\Transformer\ArrayToMessageTransformer;

/**
 * Guzzle Client for MailCatcher.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
class Client implements ClientInterface
{
    /**
     * @var Transformer\ArrayToMessageTransformer
     */
    protected $messageTransformer;
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    public function __construct(ArrayToMessageTransformer $messageTransformer, ConnectionInterface $connection)
    {
        $this->messageTransformer = $messageTransformer;
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function purge()
    {
        $this->connection->deleteMessages();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $messages = $this->connection->getMessages();

        return count($messages);
    }

    /**
     * {@inheritdoc}
     */
    public function getMessages()
    {
        $messages = $this->connection->getMessages();

        return $this->parseMessages($messages);
    }

    /**
     * {@inheritdoc}
     */
    public function getLastMessage()
    {
        $messages = $this->connection->getMessages();
        $last = array_shift($messages);

        return $this->messageTransformer->transform($last);
    }

    private function parseMessages($data)
    {
        $messages = array();
        foreach ($data as $message) {
            $messages[] = $this->messageTransformer->transform($message);
        }

        return $messages;
    }

}
