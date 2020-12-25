<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\ProfileSettings;

use Involix\Messenger\Exception\InvalidTypeException;
use Involix\Messenger\Helper\UtilityTrait;
use Involix\Messenger\Helper\ValidatorTrait;

/**
 * @deprecated Since version 3.3.0 and will be removed in version 4.0.0.
 */
class TargetAudience implements \JsonSerializable
{
    use UtilityTrait;
    use ValidatorTrait;

    private const AUDIENCE_TYPE_ALL = 'all';
    private const AUDIENCE_TYPE_CUSTOM = 'custom';
    private const AUDIENCE_TYPE_NONE = 'none';

    /**
     * @var string
     */
    protected $audienceType;

    /**
     * @var array
     */
    protected $whitelistCountries;

    /**
     * @var array
     */
    protected $blacklistCountries;

    /**
     * TargetAudience constructor.
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(
        string $audienceType = self::AUDIENCE_TYPE_ALL,
        array $whitelistCountries = [],
        array $blacklistCountries = []
    ) {
        $this->isValidAudienceType($audienceType);
        $this->isValidCountries($whitelistCountries);
        $this->isValidCountries($blacklistCountries);

        $this->audienceType = $audienceType;
        $this->whitelistCountries = $whitelistCountries;
        $this->blacklistCountries = $blacklistCountries;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\ProfileSettings\TargetAudience
     */
    public static function create(
        string $audienceType = self::AUDIENCE_TYPE_ALL,
        array $whitelistCountries = [],
        array $blacklistCountries = []
    ): self {
        return new self($audienceType, $whitelistCountries, $blacklistCountries);
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\ProfileSettings\TargetAudience
     */
    public function addWhitelistCountry(string $country): self
    {
        $this->isValidCountry($country);

        $this->whitelistCountries[] = $country;

        return $this;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\ProfileSettings\TargetAudience
     */
    public function addBlacklistCountry(string $country): self
    {
        $this->isValidCountry($country);

        $this->blacklistCountries[] = $country;

        return $this;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidCountries(array $countries): void
    {
        if (!empty($countries)) {
            foreach ($countries as $country) {
                $this->isValidCountry($country);
            }
        }
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidAudienceType(string $audienceType): void
    {
        $allowedAudienceType = $this->getAllowedAudienceType();
        if (!\in_array($audienceType, $allowedAudienceType, true)) {
            throw new InvalidTypeException(sprintf('audienceType must be either "%s".', implode(', ', $allowedAudienceType)));
        }
    }

    private function getAllowedAudienceType(): array
    {
        return [
            self::AUDIENCE_TYPE_ALL,
            self::AUDIENCE_TYPE_CUSTOM,
            self::AUDIENCE_TYPE_NONE,
        ];
    }

    public function toArray(): array
    {
        $array = [
            'audience_type' => $this->audienceType,
            'countries' => [
                'whitelist' => $this->whitelistCountries,
                'blacklist' => $this->blacklistCountries,
            ],
        ];

        return $this->arrayFilter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
