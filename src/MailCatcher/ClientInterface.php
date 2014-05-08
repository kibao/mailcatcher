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

/**
 * Client interface for MailCatcher.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
interface ClientInterface
{
    /**
     * @return ClientInterface
     */
    public function purge();

    /**
     * Returns messages count
     *
     * @return integer
     */
    public function count();

    /**
     * Returns messages
     *
     * @return MessageInterface[]
     */
    public function getMessages();
}
