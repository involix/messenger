<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\ProfileSettings;

use Involix\Messenger\Helper\ValidatorTrait;
use Involix\Messenger\Model\Common\Button\AbstractButton;

class PersistentMenu implements ProfileSettingsInterface, \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var bool
     */
    protected $composerInputDisabled = false;

    /**
     * @var \Involix\Messenger\Model\Common\Button\AbstractButton[]
     */
    protected $buttons = [];

    /**
     * PersistentMenu constructor.
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(string $locale = self::DEFAULT_LOCALE)
    {
        if ($locale !== self::DEFAULT_LOCALE) {
            $this->isValidLocale($locale);
        }

        $this->locale = $locale;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\ProfileSettings\PersistentMenu
     */
    public static function create(string $locale = self::DEFAULT_LOCALE): self
    {
        return new self($locale);
    }

    /**
     * @return \Involix\Messenger\Model\ProfileSettings\PersistentMenu
     */
    public function setComposerInputDisabled(bool $composerInputDisabled): self
    {
        $this->composerInputDisabled = $composerInputDisabled;

        return $this;
    }

    /**
     * @param \Involix\Messenger\Model\Common\Button\AbstractButton[] $buttons
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\ProfileSettings\PersistentMenu
     */
    public function addButtons(array $buttons): self
    {
        $this->isValidArray($buttons, 5);
        $this->isValidButtons($buttons, $this->getAllowedButtonsType());

        $this->buttons = $buttons;

        return $this;
    }

    protected function getAllowedButtonsType(): array
    {
        return [
            AbstractButton::TYPE_WEB_URL,
            AbstractButton::TYPE_POSTBACK,
            AbstractButton::TYPE_NESTED,
        ];
    }

    public function toArray(): array
    {
        $array = [
            'locale' => $this->locale,
            'composer_input_disabled' => $this->composerInputDisabled,
            'call_to_actions' => $this->buttons,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
