<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment\Template;

use Involix\Messenger\Exception\InvalidTypeException;
use Involix\Messenger\Model\Message\Attachment\AbstractTemplate;
use Involix\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo;

class AirlineUpdateTemplate extends AbstractAirlineTemplate
{
    public const UPDATE_TYPE_DELAY = 'delay';
    public const UPDATE_TYPE_GATE_CHANGE = 'gate_change';
    public const UPDATE_TYPE_CANCELLATION = 'cancellation';

    /**
     * @var string|null
     */
    protected $introMessage;

    /**
     * @var string
     */
    protected $updateType;

    /**
     * @var string
     */
    protected $pnrNumber;

    /**
     * @var \Involix\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo
     */
    protected $updateFlightInfo;

    /**
     * AirlineUpdate constructor.
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(string $updateType, string $locale, string $pnrNumber, FlightInfo $updateFlightInfo)
    {
        parent::__construct($locale);

        $this->isValidUpdateType($updateType);

        $this->updateType = $updateType;
        $this->pnrNumber = $pnrNumber;
        $this->updateFlightInfo = $updateFlightInfo;
    }

    /**
     *@throws \Involix\Messenger\Exception\MessengerException
     *
     *@return \Involix\Messenger\Model\Message\Attachment\Template\AirlineUpdateTemplate
     */
    public static function create(
        string $updateType,
        string $locale,
        string $pnrNumber,
        FlightInfo $updateFlightInfo
    ): self {
        return new self($updateType, $locale, $pnrNumber, $updateFlightInfo);
    }

    /**
     * @return \Involix\Messenger\Model\Message\Attachment\Template\AirlineUpdateTemplate
     */
    public function setIntroMessage(string $introMessage): self
    {
        $this->introMessage = $introMessage;

        return $this;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidUpdateType(string $updateType): void
    {
        $allowedUpdateType = $this->getAllowedUpdateType();
        if (!\in_array($updateType, $allowedUpdateType, true)) {
            throw new InvalidTypeException(sprintf('updateType must be either "%s".', implode(', ', $allowedUpdateType)));
        }
    }

    private function getAllowedUpdateType(): array
    {
        return [
            self::UPDATE_TYPE_DELAY,
            self::UPDATE_TYPE_GATE_CHANGE,
            self::UPDATE_TYPE_CANCELLATION,
        ];
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => AbstractTemplate::TYPE_AIRLINE_UPDATE,
                'intro_message' => $this->introMessage,
                'update_type' => $this->updateType,
                'locale' => $this->locale,
                'pnr_number' => $this->pnrNumber,
                'update_flight_info' => $this->updateFlightInfo,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
