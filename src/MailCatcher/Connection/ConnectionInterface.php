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

/**
 * MailCatcher Connection Interface
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
interface ConnectionInterface
{
    /**
     * Deletes all messages in MailCatcher
     *
     * @throws \Kibao\MailCatcher\Exception\ConnectionException
     */
    public function deleteMessages();

    /**
     * Returns messages from MailCatcher
     *
     * @throws \Kibao\MailCatcher\Exception\ConnectionException
     * @return array
     */
    public function getMessages();
}
