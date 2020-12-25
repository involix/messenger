<?php

declare(strict_types=1);

namespace Involix\Messenger\Event;

use Involix\Messenger\Model\Callback\PolicyEnforcement;

class PolicyEnforcementEvent extends AbstractEvent
{
    public const NAME = 'policy_enforcement';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Involix\Messenger\Model\Callback\PolicyEnforcement
     */
    protected $policyEnforcement;

    /**
     * ReadEvent constructor.
     */
    public function __construct(
        string $senderId,
        string $recipientId,
        int $timestamp,
        PolicyEnforcement $policyEnforcement
    ) {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->policyEnforcement = $policyEnforcement;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getPolicyEnforcement(): PolicyEnforcement
    {
        return $this->policyEnforcement;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Involix\Messenger\Event\PolicyEnforcementEvent
     */
    public static function create(array $payload): self
    {
        $senderId = isset($payload['sender']) ? $payload['sender']['id'] : '';
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $policyEnforcement = PolicyEnforcement::create($payload['policy-enforcement']);

        return new static($senderId, $recipientId, $timestamp, $policyEnforcement);
    }
}
