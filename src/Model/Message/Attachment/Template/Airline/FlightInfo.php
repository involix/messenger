<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment\Template\Airline;

class FlightInfo extends AbstractFlightInfo
{
    /**
     * @param \Involix\Messenger\Model\Message\Attachment\Template\Airline\Airport        $departureAirport
     * @param \Involix\Messenger\Model\Message\Attachment\Template\Airline\Airport        $arrivalAirport
     * @param \Involix\Messenger\Model\Message\Attachment\Template\Airline\FlightSchedule $flightSchedule
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo
     */
    public static function create(
        string $flightNumber,
        Airport $departureAirport,
        Airport $arrivalAirport,
        FlightSchedule $flightSchedule
    ): self {
        return new self($flightNumber, $departureAirport, $arrivalAirport, $flightSchedule);
    }
}
