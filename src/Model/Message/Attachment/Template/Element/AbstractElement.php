<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment\Template\Element;

use Involix\Messenger\Helper\ValidatorTrait;

abstract class AbstractElement implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string|null
     */
    protected $subtitle;

    /**
     * @var string|null
     */
    protected $imageUrl;

    /**
     * AbstractElement constructor.
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(string $title)
    {
        $this->isValidString($title, 80);

        $this->title = $title;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return mixed
     */
    public function setSubtitle(string $subtitle)
    {
        $this->isValidString($subtitle, 80);

        $this->subtitle = $subtitle;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return mixed
     */
    public function setImageUrl(string $imageUrl)
    {
        $this->isValidUrl($imageUrl);

        $this->imageUrl = $imageUrl;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
