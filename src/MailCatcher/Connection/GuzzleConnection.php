<?php

/*
 * This file is part of the MailCatcher package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Kibao\MailCatcher\Connection;

use Guzzle\Common\Exception\GuzzleException;
use Guzzle\Http\ClientInterface as Guzzle;
use Kibao\MailCatcher\Exception\ConnectionException;

/**
 * MailCatcher Guzzle Connection
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
class GuzzleConnection implements ConnectionInterface
{
    /**
     * @var \Guzzle\Http\ClientInterface
     */
    protected $guzzle;

    public function __construct(Guzzle $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteMessages()
    {
        try {
            $this->guzzle->delete('/messages')->send();
        } catch (GuzzleException $e) {
            throw new ConnectionException("", 0, $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMessages()
    {
        try {
            return $this->guzzle->get('/messages')->send()->json();
        } catch (GuzzleException $e) {
            throw new ConnectionException("", 0, $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage($id)
    {
        try {
            return $this->guzzle->get('/messages/' . $id . '.json')->send()->json();
        } catch (GuzzleException $e) {
            throw new ConnectionException("", 0, $e);
        }
    }
}
