<?php

/*
 * This file is part of the MailCatcher package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace spec\Kibao\MailCatcher;

use Kibao\MailCatcher\Connection\ConnectionInterface;
use Kibao\MailCatcher\Message\MessageInterface;
use Kibao\MailCatcher\Transformer\ArrayToMessageTransformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prophecy\Prophet;

class ClientSpec extends ObjectBehavior
{
    function let(ArrayToMessageTransformer $messageTransformer, ConnectionInterface $connection)
    {
        $this->beConstructedWith($messageTransformer, $connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kibao\MailCatcher\Client');
    }

    function it_should_be_mailcatcher_client()
    {
        $this->shouldImplement('Kibao\MailCatcher\ClientInterface');
    }

    function it_should_purges_messages(ConnectionInterface $connection)
    {
        $connection->deleteMessages()->shouldBeCalled();

        $this->purge();
    }

    function it_should_count_messages_properly(ConnectionInterface $connection)
    {
        $connection->getMessages()->willReturn(array(
            array('id' => 4),
            array('id' => 3),
            array('id' => 2),
            array('id' => 1),
        ));

        $this->count()->shouldReturn(4);
    }

    function it_should_return_messages(ConnectionInterface $connection, ArrayToMessageTransformer $messageTransformer)
    {
        $connection->getMessages()->willReturn(array(
            array('id' => 4),
            array('id' => 3),
            array('id' => 2),
            array('id' => 1),
        ));
        $prophet = new Prophet();
        $messageTransformer->transform(Argument::any())->willReturn($prophet->prophesize('Kibao\MailCatcher\Message\MessageInterface'));

        $messages = $this->getMessages();
        $messages->shouldHaveCount(4);
        $messages->shouldBeMessagesArray();
    }

    function it_should_return_last_message(ConnectionInterface $connection, ArrayToMessageTransformer $messageTransformer, MessageInterface $message)
    {
        $connection->getMessages()->willReturn(array(
            array('id' => 4),
            array('id' => 3),
            array('id' => 2),
            array('id' => 1),
        ));

        $messageTransformer->transform(array('id' => 4))->willReturn($message);

        $this->getLastMessage()->shouldReturn($message);
    }

    function it_should_return_null_if_there_is_no_last_message(ConnectionInterface $connection)
    {
        $connection->getMessages()->willReturn(array());

        $this->getLastMessage()->shouldReturn(null);
    }


    function it_should_return_messages_to_given_recipient(ConnectionInterface $connection, ArrayToMessageTransformer $messageTransformer)
    {
        $rawMessages = array(
            array('id' => 4, 'recipients' => array('john.doe@example.com')),
            array('id' => 2, 'recipients' => array('demo@example.com', 'john.doe@example.com'),),
            array('id' => 1, 'recipients' => array('john@example.com')),
        );
        $prophet = new Prophet();
        $mockMessages = array(
            $prophet->prophesize('Kibao\MailCatcher\Message\MessageInterface'),
            $prophet->prophesize('Kibao\MailCatcher\Message\MessageInterface'),
            $prophet->prophesize('Kibao\MailCatcher\Message\MessageInterface'),
        );

        for ($i = 0; $i < 3; $i++) {
            $rawMessage = $rawMessages[$i];
            $recipients = array();
            foreach ($rawMessage['recipients'] as $email) {
                $recipient = $prophet->prophesize('Kibao\MailCatcher\Address\AddressInterface');
                $recipient->getEmail()->willReturn($email);
                $recipients[] = $recipient;
            }
            $mockMessages[$i]->getRecipients()->willReturn($recipients);

            $messageTransformer->transform($rawMessage)->willReturn($mockMessages[$i]);
        }

        $connection->getMessages()->willReturn($rawMessages);

        $this->getMessagesTo('john.doe@example.com')->shouldReturn(array(
            $mockMessages[0],
            $mockMessages[1],
        ));
        $prophet->checkPredictions();
    }

    public function getMatchers()
    {
        return array(
            'beMessagesArray' => function ($array) {
                    foreach ($array as $value) {
                        if (!$value instanceof MessageInterface) {
                            return false;
                        }
                    }
                    return true;
                }
        );
    }
}
