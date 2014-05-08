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

use Kibao\MailCatcher\Message\Message;
use Kibao\MailCatcher\Message\MessageInterface;

/**
 * Array to Message transformer.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
class ArrayToMessageTransformer
{
    protected $addressTransformer;

    /**
     * @param ArrayToAddressTransformer $addressTransformer
     */
    public function __construct(ArrayToAddressTransformer $addressTransformer)
    {
        $this->addressTransformer = $addressTransformer;
    }

    /**
     * Transforms an array to a object (message).
     *
     * @param  array            $data
     * @return MessageInterface
     */
    public function transform($data)
    {
        if (empty($data))
            return null;

        $data = array_merge(array(
            'id' => null,
            "sender" => null,
            "recipients" => array(),
            "subject" => null,
            "source" => null,
            "size" => null,
            "type" => null,
            "created_at" => null,
            "formats" => array()
        ), $data);

        $data['sender'] = $this->addressTransformer->transform($data['sender']);

        $recipients = array();
        foreach ($data['recipients'] as $recipient) {
            $recipients[] = $this->addressTransformer->transform($recipient);
        }
        $data['recipients'] = $recipients;

        return new Message($data);
    }
}
