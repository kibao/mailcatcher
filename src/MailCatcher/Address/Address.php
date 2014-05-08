<?php

/*
 * This file is part of the MailCatcher package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Kibao\MailCatcher\Address;

/**
 * MailCatcher Address object.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
class Address implements AddressInterface
{
    protected $email;
    protected $personal;

    public function __construct($email, $personal = null)
    {
        $this->email = $email;
        $this->personal = $personal;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function getPersonal()
    {
        return $this->personal;
    }
}
