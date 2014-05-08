<?php

/*
 * This file is part of the MailCatcher package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Kibao\MailCatcher\Message;

use Kibao\MailCatcher\Address\AddressInterface;

/**
 * MailCatcher Message interface.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
interface MessageInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @return AddressInterface
     */
    public function getSender();

    /**
     * @return AddressInterface[]
     */
    public function getRecipients();

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @return string
     */
    public function getSource();

    /**
     * @return integer
     */
    public function getSize();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return array
     */
    public function getFormats();

    /**
     * @param $format
     * @return boolean
     */
    public function hasFormat($format);
}
