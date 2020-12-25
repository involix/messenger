<?php

declare(strict_types=1);

namespace Involix\Messenger\Event;

use Involix\Messenger\Model\Callback\MessageEcho;

class MessageEchoEvent extends AbstractEvent
{
    public const NAME = 'message_echo';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Involix\Messenger\Model\Callback\MessageEcho
     */
    protected $messageEcho;

    /**
     * MessageEvent constructor.
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, MessageEcho $messageEcho)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->messageEcho = $messageEcho;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getMessageEcho(): MessageEcho
    {
        return $this->messageEcho;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Involix\Messenger\Event\MessageEchoEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $message = MessageEcho::create($payload['message']);

        return new static($senderId, $recipientId, $timestamp, $message);
    }
}
