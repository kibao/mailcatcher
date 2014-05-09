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
use Kibao\MailCatcher\Message\MessageInterface;

/**
 * Client interface for MailCatcher.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
interface ClientInterface
{
    /**
     * @throws \Kibao\MailCatcher\Exception\ConnectionException
     * @return ClientInterface
     */
    public function purge();

    /**
     * Returns messages count
     *
     * @throws \Kibao\MailCatcher\Exception\ConnectionException
     * @return integer
     */
    public function count();

    /**
     * Returns messages
     *
     * @throws \Kibao\MailCatcher\Exception\ConnectionException
     * @return MessageInterface[]
     */
    public function getMessages();

    /**
     * Returns last message
     *
     * @throws \Kibao\MailCatcher\Exception\ConnectionException
     * @return MessageInterface
     */
    public function getLastMessage();
}
