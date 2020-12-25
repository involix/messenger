<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment\Template;

use Involix\Messenger\Model\Message\Attachment\AbstractTemplate;

class GenericTemplate extends AbstractTemplate
{
    public const IMAGE_RATIO_HORIZONTAL = 'horizontal';
    public const IMAGE_RATIO_SQUARE = 'square';

    /**
     * @var \Involix\Messenger\Model\Message\Attachment\Template\Element\GenericElement[]
     */
    protected $elements;

    /**
     * @var string
     */
    protected $imageRatio;

    /**
     * Generic constructor.
     *
     * @param \Involix\Messenger\Model\Message\Attachment\Template\Element\GenericElement[] $elements
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(array $elements, string $imageRatio = self::IMAGE_RATIO_HORIZONTAL)
    {
        parent::__construct();

        $this->isValidArray($elements, 10);

        $this->elements = $elements;
        $this->imageRatio = $imageRatio;
    }

    /**
     *@throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\GenericTemplate
     */
    public static function create(array $elements, string $imageRatio = self::IMAGE_RATIO_HORIZONTAL): self
    {
        return new self($elements, $imageRatio);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => AbstractTemplate::TYPE_GENERIC,
                'elements' => $this->elements,
                'image_aspect_ratio' => $this->imageRatio,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
