<?php

declare(strict_types=1);

namespace Involix\Messenger\Event;

use Involix\Messenger\Model\Callback\CheckoutUpdate;

class CheckoutUpdateEvent extends AbstractEvent
{
    public const NAME = 'checkout_update';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Involix\Messenger\Model\Callback\CheckoutUpdate
     */
    protected $checkoutUpdate;

    /**
     * CheckoutUpdateEvent constructor.
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, CheckoutUpdate $checkoutUpdate)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->checkoutUpdate = $checkoutUpdate;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getCheckoutUpdate(): CheckoutUpdate
    {
        return $this->checkoutUpdate;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Involix\Messenger\Event\CheckoutUpdateEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $checkoutUpdate = CheckoutUpdate::create($payload['checkout_update']);

        return new static($senderId, $recipientId, $timestamp, $checkoutUpdate);
    }
}
