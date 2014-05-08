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
 * MailCatcher Address interface.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
interface AddressInterface
{
    /**
     * Returns the email address.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Returns the personal name.
     *
     * @return mixed
     */
    public function getPersonal();
}
