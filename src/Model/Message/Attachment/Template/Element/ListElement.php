<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment\Template\Element;

use Involix\Messenger\Model\Common\Button\WebUrl;

class ListElement extends AbstractElement
{
    /**
     * @var \Involix\Messenger\Model\Common\Button\WebUrl
     */
    protected $defaultAction;

    /**
     * @var \Involix\Messenger\Model\Common\Button\AbstractButton[]
     */
    protected $buttons = [];

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Element\ListElement
     */
    public static function create(string $title): self
    {
        return new self($title);
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Element\ListElement
     */
    public function setSubtitle(string $subtitle): self
    {
        parent::setSubtitle($subtitle);

        return $this;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Element\ListElement
     */
    public function setImageUrl(string $imageUrl): self
    {
        parent::setImageUrl($imageUrl);

        return $this;
    }

    /**
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Element\ListElement
     */
    public function setDefaultAction(WebUrl $defaultAction): self
    {
        $this->defaultAction = $defaultAction;

        return $this;
    }

    /**
     * @param \Involix\Messenger\Model\Common\Button\AbstractButton[] $buttons
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Element\ListElement
     */
    public function setButtons(array $buttons): self
    {
        $this->isValidArray($buttons, 1);

        $this->buttons = $buttons;

        return $this;
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'subtitle' => $this->subtitle,
            'image_url' => $this->imageUrl,
            'default_action' => $this->defaultAction,
            'buttons' => $this->buttons,
        ];

        return array_filter($array);
    }
}
