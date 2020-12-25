<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment\Template;

use Involix\Messenger\Exception\InvalidClassException;
use Involix\Messenger\Model\Message\Attachment\AbstractTemplate;
use Involix\Messenger\Model\Message\Attachment\Template\Element\MediaElement;

class MediaTemplate extends AbstractTemplate
{
    /**
     * @var \Involix\Messenger\Model\Message\Attachment\Template\Element\MediaElement[]
     */
    protected $elements;

    /**
     * MediaTemplate constructor.
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(array $elements)
    {
        parent::__construct();

        $this->isValidElements($elements);

        $this->elements = $elements;
    }

    /**
     *@throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\MediaTemplate
     */
    public static function create(array $elements): self
    {
        return new self($elements);
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidElements(array $elements): void
    {
        $this->isValidArray($elements, 1, 1);
        foreach ($elements as $element) {
            if (!$element instanceof MediaElement) {
                throw new InvalidClassException(sprintf('Array can only contain instance of %s.', MediaElement::class));
            }
        }
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => AbstractTemplate::TYPE_MEDIA,
                'elements' => $this->elements,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
