<?php

declare(strict_types=1);

namespace Involix\Messenger\Event;

use Involix\Messenger\Model\Callback\Referral;

class ReferralEvent extends AbstractEvent
{
    public const NAME = 'referral';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Involix\Messenger\Model\Callback\Referral
     */
    protected $referral;

    /**
     * ReferralEvent constructor.
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, Referral $referral)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->referral = $referral;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getReferral(): Referral
    {
        return $this->referral;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Involix\Messenger\Event\ReferralEvent
     */
    public static function create(array $payload): self
    {
        $senderId = $payload['sender']['id'];
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $referral = Referral::create($payload['referral']);

        return new static($senderId, $recipientId, $timestamp, $referral);
    }
}
