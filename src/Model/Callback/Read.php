<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Callback;

class Read
{
    /**
     * @var int
     */
    protected $watermark;

    /**
     * Read constructor.
     */
    public function __construct(int $watermark)
    {
        $this->watermark = $watermark;
    }

    public function getWatermark(): int
    {
        return $this->watermark;
    }

    /**
     * @return \Involix\Messenger\Model\Callback\Read
     */
    public static function create(array $callbackData): self
    {
        return new self($callbackData['watermark']);
    }
}
