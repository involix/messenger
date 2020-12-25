<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment\Template;

use Involix\Messenger\Model\Message\Attachment\AbstractTemplate;

class ButtonTemplate extends AbstractTemplate
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @var \Involix\Messenger\Model\Common\Button\AbstractButton[]
     */
    protected $buttons;

    /**
     * @var bool
     */
    protected $sharable;

    /**
     * Buttons constructor.
     *
     * @param \Involix\Messenger\Model\Common\Button\AbstractButton[] $buttons
     */
    public function __construct(string $text, array $buttons, bool $sharable = false)
    {
        parent::__construct();

        $this->isValidString($text, 640);
        $this->isValidArray($buttons, 3);

        $this->text = $text;
        $this->buttons = $buttons;
        $this->sharable = $sharable;
    }

    /**
     * @return \Involix\Messenger\Model\Message\Attachment\Template\ButtonTemplate
     */
    public static function create(string $text, array $buttons, bool $sharable = false): self
    {
        return new self($text, $buttons, $sharable);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => AbstractTemplate::TYPE_BUTTON,
                'text' => $this->text,
                'buttons' => $this->buttons,
                'sharable' => $this->sharable,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
