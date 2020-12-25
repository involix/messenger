<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Data;

class Value
{
    /**
     * @var int|array
     */
    protected $value;

    /**
     * @var string
     */
    protected $endTime;

    /**
     * Value constructor.
     *
     * @param int|array $value
     */
    public function __construct($value, string $endTime)
    {
        $this->value = $value;
        $this->endTime = $endTime;
    }

    /**
     * @param int|array $value
     *
     * @return \Involix\Messenger\Model\Data\Value
     */
    public static function create($value, string $endTime): self
    {
        return new self($value, $endTime);
    }

    /**
     * @return int|array
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return \DateTime|string
     */
    public function getEndTime(bool $asDateTime = true)
    {
        $endTime = \DateTime::createFromFormat(\DateTime::ATOM, $this->endTime);
        if ($asDateTime && $endTime instanceof \DateTime) {
            return $endTime;
        }

        return $this->endTime;
    }
}
