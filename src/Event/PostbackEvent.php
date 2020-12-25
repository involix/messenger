<?php

declare(strict_types=1);

namespace Involix\Messenger\Event;

use Involix\Messenger\Model\Callback\Postback;

class PostbackEvent extends AbstractEvent
{
    public const NAME = 'postback';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Involix\Messenger\Model\Callback\Postback
     */
    protected $postback;

    /**
     * PostbackEvent constructor.
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Postback $postback)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->postback = $postback;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getPostback(): Postback
    {
        return $this->postback;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Involix\Messenger\Event\PostbackEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $postback = Postback::create($payload['postback']);

        return new static($senderId, $recipientId, $timestamp, $postback);
    }
}
