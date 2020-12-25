<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Common\Button;

class Postback extends AbstractButton
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $payload;

    /**
     * Postback constructor.
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(string $title, string $payload)
    {
        parent::__construct(self::TYPE_POSTBACK);

        $this->isValidString($title, 20);
        $this->isValidString($payload, 1000);

        $this->title = $title;
        $this->payload = $payload;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Common\Button\Postback
     */
    public static function create(string $title, string $payload): self
    {
        return new self($title, $payload);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'title' => $this->title,
            'payload' => $this->payload,
        ];

        return $array;
    }
}
