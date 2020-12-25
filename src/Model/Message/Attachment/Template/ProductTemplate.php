<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment\Template;

use Involix\Messenger\Model\Message\Attachment\AbstractTemplate;

class ProductTemplate extends AbstractTemplate
{
    /**
     * @var \Involix\Messenger\Model\Message\Attachment\Template\Element\ProductElement[]
     */
    private $elements;

    /**
     * @throws \Involix\Messenger\Exception\InvalidArrayException
     */
    public function __construct(array $elements)
    {
        parent::__construct();

        $this->isValidArray($elements, 10);

        $this->elements = $elements;
    }

    /**
     * @throws \Involix\Messenger\Exception\InvalidArrayException
     */
    public static function create(array $elements): self
    {
        return new self($elements);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => AbstractTemplate::TYPE_PRODUCT,
                'elements' => $this->elements,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
