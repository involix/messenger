<?php

declare(strict_types=1);

namespace Involix\Messenger\Tests\TestCase\Model\Message\Attachment\Template\Airline;

use Involix\Messenger\Exception\MessengerException;
use Involix\Messenger\Model\Message\Attachment\Template\Airline\Airport;
use Involix\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo;
use Involix\Messenger\Model\Message\Attachment\Template\Airline\FlightSchedule;
use Involix\Messenger\Model\Message\Attachment\Template\AirlineUpdateTemplate;
use PHPUnit\Framework\TestCase;

class AirlineUpdateTest extends TestCase
{
    public function testInvalidUpdateType(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('updateType must be either "delay, gate_change, cancellation".');

        $departureAirport = Airport::create('SFO', 'San Francisco')->setTerminal('T4')->setGate('G8');
        $arrivalAirport = Airport::create('AMS', 'Amsterdam')->setTerminal('T4')->setGate('G8');
        $flightSchedule = FlightSchedule::create('2015-12-26T11:30')->setArrivalTime('2015-12-27T07:30')->setBoardingTime('2015-12-26T10:30');

        $updateFlightInfo = FlightInfo::create('KL123', $departureAirport, $arrivalAirport, $flightSchedule);

        AirlineUpdateTemplate::create('departure', 'en_US', 'CF23G2', $updateFlightInfo);
    }
}
