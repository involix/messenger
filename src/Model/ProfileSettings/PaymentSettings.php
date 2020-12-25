<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\ProfileSettings;

use Involix\Messenger\Helper\ValidatorTrait;

/**
 * @deprecated Since version 3.3.0 and will be removed in version 4.0.0.
 */
class PaymentSettings implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var string|null
     */
    protected $privacyUrl;

    /**
     * @var string|null
     */
    protected $publicKey;

    /**
     * @var array
     */
    protected $testUsers = [];

    /**
     * @return \Involix\Messenger\Model\ProfileSettings\PaymentSettings
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\ProfileSettings\PaymentSettings
     */
    public function setPrivacyUrl(string $privacyUrl): self
    {
        $this->isValidUrl($privacyUrl);
        $this->privacyUrl = $privacyUrl;

        return $this;
    }

    /**
     * @return \Involix\Messenger\Model\ProfileSettings\PaymentSettings
     */
    public function setPublicKey(string $publicKey): self
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * @return \Involix\Messenger\Model\ProfileSettings\PaymentSettings
     */
    public function addTestUser(int $testUser): self
    {
        $this->testUsers[] = $testUser;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'privacy_url' => $this->privacyUrl,
            'public_key' => $this->publicKey,
            'test_users' => $this->testUsers,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
