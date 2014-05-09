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
 * MailCatcher Message object.
 *
 * @author Przemysław Piechota <kibao.pl@gmail.com>
 */
class Message implements MessageInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var AddressInterface
     */
    protected $sender;

    /**
     * @var AddressInterface[]
     */
    protected $recipients;

    /**
     * @var string
     */
    protected $subject;
    /**
     * @var string
     */
    protected $source;

    /**
     * @var integer
     */
    protected $size;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var array
     */
    protected $formats;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->sender = $data['sender'];
        $this->recipients = $data['recipients'];
        $this->subject = $data['subject'];
        $this->source = $data['source'];
        $this->size = $data['size'];
        $this->type = $data['type'];
        $this->createdAt = $data['created_at'];
        $this->formats = $data['formats'];
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormats()
    {
        return $this->formats;
    }

    /**
     * {@inheritdoc}
     */
    public function hasFormat($format)
    {
        return in_array($format, $this->formats, true);
    }

}
