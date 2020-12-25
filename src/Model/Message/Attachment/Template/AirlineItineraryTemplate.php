<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment\Template;

use Involix\Messenger\Model\Message\Attachment\AbstractTemplate;

class AirlineItineraryTemplate extends AbstractAirlineTemplate
{
    /**
     * @var string
     */
    protected $introMessage;

    /**
     * @var string
     */
    protected $pnrNumber;

    /**
     * @var \Involix\Messenger\Model\Message\Attachment\Template\Airline\PassengerInfo[]
     */
    protected $passengerInfo;

    /**
     * @var \Involix\Messenger\Model\Message\Attachment\Template\Airline\ExtendedFlightInfo[]
     */
    protected $flightInfo;

    /**
     * @var \Involix\Messenger\Model\Message\Attachment\Template\Airline\PassengerSegmentInfo[]
     */
    protected $passengerSegmentInfo;

    /**
     * @var array
     */
    protected $priceInfo = [];

    /**
     * @var string|null
     */
    protected $basePrice;

    /**
     * @var string|null
     */
    protected $tax;

    /**
     * @var string
     */
    protected $totalPrice;

    /**
     * @var string
     */
    protected $currency;

    /**
     * AirlineItinerary constructor.
     *
     * @param \Involix\Messenger\Model\Message\Attachment\Template\Airline\PassengerInfo[]        $passengerInfo
     * @param \Involix\Messenger\Model\Message\Attachment\Template\Airline\ExtendedFlightInfo[]   $flightInfo
     * @param \Involix\Messenger\Model\Message\Attachment\Template\Airline\PassengerSegmentInfo[] $passengerSegmentInfo
     */
    public function __construct(
        string $introMessage,
        string $locale,
        string $pnrNumber,
        array $passengerInfo,
        array $flightInfo,
        array $passengerSegmentInfo,
        string $totalPrice,
        string $currency
    ) {
        parent::__construct($locale);

        $this->introMessage = $introMessage;
        $this->pnrNumber = $pnrNumber;
        $this->passengerInfo = $passengerInfo;
        $this->flightInfo = $flightInfo;
        $this->passengerSegmentInfo = $passengerSegmentInfo;
        $this->totalPrice = $totalPrice;
        $this->currency = $currency;
    }

    /**
     * @return \Involix\Messenger\Model\Message\Attachment\Template\AirlineItineraryTemplate
     */
    public static function create(
        string $introMessage,
        string $locale,
        string $pnrNumber,
        array $passengerInfo,
        array $flightInfo,
        array $passengerSegmentInfo,
        string $totalPrice,
        string $currency
    ): self {
        return new self(
            $introMessage,
            $locale,
            $pnrNumber,
            $passengerInfo,
            $flightInfo,
            $passengerSegmentInfo,
            $totalPrice,
            $currency
        );
    }

    /**
     * @param string $currency
     *
     *@throws \Involix\Messenger\Exception\MessengerException
     *
     *@return \Involix\Messenger\Model\Message\Attachment\Template\AirlineItineraryTemplate
     */
    public function addPriceInfo(string $title, string $amount, ?string $currency = null): self
    {
        if ($currency !== null) {
            $this->isValidCurrency($currency);
        }

        $priceInfo = [
            'title' => $title,
            'amount' => $amount,
            'currency' => $currency,
        ];

        $this->isValidArray($this->priceInfo, 4);

        $this->priceInfo[] = array_filter($priceInfo);

        return $this;
    }

    /**
     * @return \Involix\Messenger\Model\Message\Attachment\Template\AirlineItineraryTemplate
     */
    public function setBasePrice(string $basePrice): self
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    /**
     * @return \Involix\Messenger\Model\Message\Attachment\Template\AirlineItineraryTemplate
     */
    public function setTax(string $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => AbstractTemplate::TYPE_AIRLINE_ITINERARY,
                'intro_message' => $this->introMessage,
                'locale' => $this->locale,
                'theme_color' => $this->themeColor,
                'pnr_number' => $this->pnrNumber,
                'passenger_info' => $this->passengerInfo,
                'flight_info' => $this->flightInfo,
                'passenger_segment_info' => $this->passengerSegmentInfo,
                'price_info' => $this->priceInfo,
                'base_price' => $this->basePrice,
                'tax' => $this->tax,
                'total_price' => $this->totalPrice,
                'currency' => $this->currency,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
