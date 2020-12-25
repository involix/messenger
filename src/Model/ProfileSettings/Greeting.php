<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\ProfileSettings;

use Involix\Messenger\Helper\ValidatorTrait;

class Greeting implements ProfileSettingsInterface, \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $locale;

    /**
     * Greeting constructor.
     *
     * @throws \Exception
     */
    public function __construct(string $text, string $locale = self::DEFAULT_LOCALE)
    {
        $this->isValidString($text, 160);

        if ($locale !== self::DEFAULT_LOCALE) {
            $this->isValidLocale($locale);
        }

        $this->text = $text;
        $this->locale = $locale;
    }

    /**
     * @throws \Exception
     *
     * @return \Involix\Messenger\Model\ProfileSettings\Greeting
     */
    public static function create(string $text, string $locale = self::DEFAULT_LOCALE): self
    {
        return new self($text, $locale);
    }

    public function toArray(): array
    {
        $array = [
            'locale' => $this->locale,
            'text' => $this->text,
        ];

        return $array;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
