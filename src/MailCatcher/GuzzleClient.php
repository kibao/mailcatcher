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

use Guzzle\Http\ClientInterface as Guzzle;
use Kibao\MailCatcher\Transformer\ArrayToMessageTransformer;

/**
 * Guzzle Client for MailCatcher.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
class GuzzleClient implements ClientInterface
{
    /**
     * @var Transformer\ArrayToMessageTransformer
     */
    protected $messageTransformer;
    /**
     * @var \Guzzle\Http\ClientInterface
     */
    protected $guzzle;

    public function __construct(ArrayToMessageTransformer $messageTransformer, Guzzle $guzzle)
    {
        $this->messageTransformer = $messageTransformer;
        $this->guzzle = $guzzle;
    }

    /**
     * {@inheritdoc}
     */
    public function purge()
    {
        $this->guzzle->delete('/messages')->send();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $messages = $this->guzzle->get('/messages')->send()->json();

        return count($messages);
    }

    /**
     * {@inheritdoc}
     */
    public function getMessages()
    {
        $messages = $this->guzzle->get('/messages')->send()->json();

        return $this->parseMessages($messages);
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
