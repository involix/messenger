<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Callback;

use Involix\Messenger\Model\Callback\Payment\RequestedUserInfo;
use Involix\Messenger\Model\Common\Address;

class PreCheckout
{
    /**
     * @var string
     */
    protected $payload;

    /**
     * @var \Involix\Messenger\Model\Callback\Payment\RequestedUserInfo
     */
    protected $requestedUserInfo;

    /**
     * @var array
     */
    protected $amount;

    /**
     * PreCheckout constructor.
     */
    public function __construct(string $payload, RequestedUserInfo $requestedUserInfo, array $amount)
    {
        $this->payload = $payload;
        $this->requestedUserInfo = $requestedUserInfo;
        $this->amount = $amount;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function getRequestedUserInfo(): RequestedUserInfo
    {
        return $this->requestedUserInfo;
    }

    public function getShippingAddress(): Address
    {
        return $this->requestedUserInfo->getShippingAddress();
    }

    public function getCurrency(): ?string
    {
        return $this->amount['currency'] ?? null;
    }

    public function getAmount(): ?string
    {
        return $this->amount['amount'] ?? null;
    }

    /**
     * @return \Involix\Messenger\Model\Callback\PreCheckout
     */
    public static function create(array $callbackData): self
    {
        $requestedUserInfo = RequestedUserInfo::create($callbackData['requested_user_info']);

        return new self($callbackData['payload'], $requestedUserInfo, $callbackData['amount']);
    }
}
