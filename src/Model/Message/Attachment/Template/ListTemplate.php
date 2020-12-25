<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment\Template;

use Involix\Messenger\Exception\InvalidKeyException;
use Involix\Messenger\Model\Message\Attachment\AbstractTemplate;

/**
 * @deprecated Since version 3.2.0 and will be removed in version 4.0.0.
 */
class ListTemplate extends AbstractTemplate
{
    public const TOP_ELEMENT_STYLE_LARGE = 'large';
    public const TOP_ELEMENT_STYLE_COMPACT = 'compact';

    /**
     * @var string
     */
    protected $topElementStyle;

    /**
     * @var \Involix\Messenger\Model\Message\Attachment\Template\Element\ListElement[]
     */
    protected $elements = [];

    /**
     * @var \Involix\Messenger\Model\Common\Button\AbstractButton[]
     */
    protected $buttons = [];

    /**
     * Liste constructor.
     *
     * @param \Involix\Messenger\Model\Message\Attachment\Template\Element\ListElement[] $elements
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(array $elements)
    {
        parent::__construct();

        $this->isValidArray($elements, 4, 2);

        $this->elements = $elements;
    }

    /**
     *@throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\ListTemplate
     */
    public static function create(array $elements): self
    {
        return new self($elements);
    }

    /**
     *@throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\ListTemplate
     */
    public function setTopElementStyle(string $topElementStyle): self
    {
        $this->isValidTopElementStyle($topElementStyle);

        $this->topElementStyle = $topElementStyle;

        return $this;
    }

    /**
     * @param \Involix\Messenger\Model\Common\Button\AbstractButton[] $buttons
     *
     *@throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\ListTemplate
     */
    public function setButtons(array $buttons): self
    {
        $this->isValidArray($buttons, 1);

        $this->buttons = $buttons;

        return $this;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidTopElementStyle(string $topElementStyle): void
    {
        $allowedTopElementStyle = $this->getAllowedTopElementStyle();
        if (!\in_array($topElementStyle, $allowedTopElementStyle, true)) {
            throw new InvalidKeyException(sprintf('topElementStyle must be either "%s".', implode(', ', $allowedTopElementStyle)));
        }
    }

    private function getAllowedTopElementStyle(): array
    {
        return [
            self::TOP_ELEMENT_STYLE_LARGE,
            self::TOP_ELEMENT_STYLE_COMPACT,
        ];
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => AbstractTemplate::TYPE_LIST,
                'top_element_style' => $this->topElementStyle,
                'elements' => $this->elements,
                'buttons' => $this->buttons,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
