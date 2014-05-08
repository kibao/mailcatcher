<?php
/*
 * This file is part of the MailCatcher package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kibao\MailCatcher\Transformer;

use Kibao\MailCatcher\Address\Address;
use Kibao\MailCatcher\Address\AddressInterface;
use Kibao\MailCatcher\Exception\AddressException;

/**
 * Array to Address transformer.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
class ArrayToAddressTransformer
{
    /**
     * Transforms an string to a object (Address).
     *
     * @param $value
     * @throws \Kibao\MailCatcher\Exception\AddressException
     * @return AddressInterface
     */
    public function transform($value)
    {
        if (trim($value) == '')
            return null;

        if (preg_match('/^(?:(.+) )?<(.+)>$/', $value, $matches)) {
            return new Address($matches[2], $matches[1]);
        }

        throw new AddressException(sprintf('Unable to parse Address "%s".', $value));
    }
}
