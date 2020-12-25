<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Common\Button;

/**
 * @deprecated Since version 3.2.0 and will be removed in version 4.0.0.
 */
class Nested extends AbstractButton
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var \Involix\Messenger\Model\Common\Button\AbstractButton[]
     */
    protected $buttons;

    /**
     * Nested constructor.
     *
     * @param \Involix\Messenger\Model\Common\Button\AbstractButton[] $buttons
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(string $title, array $buttons)
    {
        parent::__construct(self::TYPE_NESTED);

        $this->isValidString($title, 20);
        $this->isValidArray($buttons, 5);
        $this->isValidButtons($buttons, $this->getAllowedButtonsType());

        $this->title = $title;
        $this->buttons = $buttons;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Common\Button\Nested
     */
    public static function create(string $title, array $buttons): self
    {
        return new self($title, $buttons);
    }

    /**
     * @param \Involix\Messenger\Model\Common\Button\AbstractButton $button
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Common\Button\Nested
     */
    public function addButton(AbstractButton $button): self
    {
        $this->isValidButtons([$button], $this->getAllowedButtonsType());

        $this->buttons[] = $button;

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
        $array = parent::toArray();
        $array += [
            'title' => $this->title,
            'call_to_actions' => $this->buttons,
        ];

        return $array;
    }
}
