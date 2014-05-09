<?php

/*
 * This file is part of the MailCatcher package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace spec\Kibao\MailCatcher\Transformer;

use Kibao\MailCatcher\Address\AddressInterface;
use Kibao\MailCatcher\Transformer\ArrayToAddressTransformer;
use PhpSpec\ObjectBehavior;

class ArrayToMessageTransformerSpec extends ObjectBehavior
{
    function let(ArrayToAddressTransformer $addressTransformer)
    {
        $this->beConstructedWith($addressTransformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kibao\MailCatcher\Transformer\ArrayToMessageTransformer');
    }

    function it_should_transform_sender(ArrayToAddressTransformer $addressTransformer, $sender, AddressInterface $address)
    {
        $addressTransformer->transform($sender)->willReturn($address);

        $message = $this->transform(array('sender' => $sender));

        $message->shouldHaveType('Kibao\MailCatcher\Message\Message');
        $message->getSender()->shouldReturn($address);
    }

    function it_should_transform_recipients(ArrayToAddressTransformer $addressTransformer, $recipient1, $recipient2,
                                            AddressInterface $address1, AddressInterface $address2)
    {
        $addressTransformer->transform($recipient1)->willReturn($address1);
        $addressTransformer->transform($recipient2)->willReturn($address2);

        $message = $this->transform(array('recipients' => array($recipient1, $recipient2)));

        $message->shouldHaveType('Kibao\MailCatcher\Message\Message');
        $message->getRecipients()->shouldReturn(array($address1, $address2));
    }

    function it_should_transform_created_at()
    {
        $message = $this->transform(array('created_at' => '2014-05-09T08:00:00+00:00'));

        $message->shouldHaveType('Kibao\MailCatcher\Message\Message');
        $message->getCreatedAt()->shouldHaveType('\DateTime');
    }
}
