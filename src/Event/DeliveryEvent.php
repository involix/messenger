<?php

declare(strict_types=1);

namespace Involix\Messenger\Event;

use Involix\Messenger\Model\Callback\Delivery;

class DeliveryEvent extends AbstractEvent
{
    public const NAME = 'delivery';

    /**
     * @var \Involix\Messenger\Model\Callback\Delivery
     */
    protected $delivery;

    /**
     * DeliveryEvent constructor.
     */
    public function __construct(string $senderId, string $recipientId, Delivery $delivery)
    {
        parent::__construct($senderId, $recipientId);

        $this->delivery = $delivery;
    }

    public function getDelivery(): Delivery
    {
        return $this->delivery;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Involix\Messenger\Event\DeliveryEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $delivery = Delivery::create($payload['delivery']);

        return new static($senderId, $recipientId, $delivery);
    }
}
