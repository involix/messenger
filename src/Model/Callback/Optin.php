<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Callback;

class Optin
{
    /**
     * @var string
     */
    protected $ref;

    /**
     * Optin constructor.
     */
    public function __construct(string $ref)
    {
        $this->ref = $ref;
    }

    public function getRef(): string
    {
        return $this->ref;
    }

    /**
     * @return \Involix\Messenger\Model\Callback\Optin
     */
    public static function create(array $callbackData): self
    {
        return new self($callbackData['ref']);
    }
}
