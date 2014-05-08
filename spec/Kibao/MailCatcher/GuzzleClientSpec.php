<?php

/*
 * This file is part of the MailCatcher package.
 *
 * (c) Przemysław Piechota <kibao.pl@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace spec\Kibao\MailCatcher;

use Guzzle\Http\ClientInterface as Guzzle;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Kibao\MailCatcher\Message\MessageInterface;
use Kibao\MailCatcher\Transformer\ArrayToMessageTransformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prophecy\Prophet;

class GuzzleClientSpec extends ObjectBehavior
{
    function let(ArrayToMessageTransformer $messageTransformer, Guzzle $guzzle)
    {
        $this->beConstructedWith($messageTransformer, $guzzle);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kibao\MailCatcher\GuzzleClient');
    }

    function it_should_be_mailcatcher_client()
    {
        $this->shouldImplement('Kibao\MailCatcher\ClientInterface');
    }

    function it_should_purges_messages(Guzzle $guzzle, RequestInterface $request)
    {
        $guzzle->delete('/messages')->willReturn($request);
        $request->send()->shouldBeCalled();

        $this->purge();
    }

    function it_should_count_messages_properly(Guzzle $guzzle, RequestInterface $request, Response $response)
    {
        $guzzle->get('/messages')->willReturn($request);
        $request->send()->willReturn($response);
        $response->json()->willReturn(array(
            array("id" => 1),
            array("id" => 2),
            array("id" => 3),
            array("id" => 4),
        ));

        $this->count()->shouldReturn(4);
    }

    function it_should_return_messages(Guzzle $guzzle, RequestInterface $request, Response $response, ArrayToMessageTransformer $messageTransformer)
    {
        $guzzle->get('/messages')->willReturn($request);
        $request->send()->willReturn($response);
        $response->json()->willReturn(array(
            array("id" => 1),
            array("id" => 2),
            array("id" => 3),
            array("id" => 4),
        ));
        $prophet = new Prophet();
        $messageTransformer->transform(Argument::any())->willReturn($prophet->prophesize('Kibao\MailCatcher\Message\MessageInterface'));

        $messages = $this->getMessages();
        $messages->shouldHaveCount(4);
        $messages->shouldBeMessagesArray();
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
