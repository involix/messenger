<?php

declare(strict_types=1);

namespace Involix\Messenger\Event;

use Involix\Messenger\Model\Callback\TakeThreadControl;

class TakeThreadControlEvent extends AbstractEvent
{
    public const NAME = 'take_thread_control';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Involix\Messenger\Model\Callback\TakeThreadControl
     */
    protected $takeThreadControl;

    /**
     * TakeThreadControlEvent constructor.
     */
    public function __construct(
        string $senderId,
        string $recipientId,
        int $timestamp,
        TakeThreadControl $takeThreadControl
    ) {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->takeThreadControl = $takeThreadControl;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getTakeThreadControl(): TakeThreadControl
    {
        return $this->takeThreadControl;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Involix\Messenger\Event\TakeThreadControlEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $takeThreadControl = TakeThreadControl::create($payload['take_thread_control']);

        return new static($senderId, $recipientId, $timestamp, $takeThreadControl);
    }
}
