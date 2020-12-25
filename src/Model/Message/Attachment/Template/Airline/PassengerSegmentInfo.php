<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment\Template\Airline;

use Involix\Messenger\Helper\ValidatorTrait;

class PassengerSegmentInfo implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $segmentId;

    /**
     * @var string
     */
    protected $passengerId;

    /**
     * @var string
     */
    protected $seat;

    /**
     * @var string
     */
    protected $seatType;

    /**
     * @var array
     */
    protected $productInfo = [];

    /**
     * PassengerSegmentInfo constructor.
     */
    public function __construct(string $segmentId, string $passengerId, string $seat, string $seatType)
    {
        $this->segmentId = $segmentId;
        $this->passengerId = $passengerId;
        $this->seat = $seat;
        $this->seatType = $seatType;
    }

    /**
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Airline\PassengerSegmentInfo
     */
    public static function create(string $segmentId, string $passengerId, string $seat, string $seatType): self
    {
        return new self($segmentId, $passengerId, $seat, $seatType);
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Airline\PassengerSegmentInfo
     */
    public function addProductInfo(string $title, string $value): self
    {
        $this->isValidArray($this->productInfo, 4);

        $this->productInfo[] = [
            'title' => $title,
            'value' => $value,
        ];

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'segment_id' => $this->segmentId,
            'passenger_id' => $this->passengerId,
            'seat' => $this->seat,
            'seat_type' => $this->seatType,
            'product_info' => $this->productInfo,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
