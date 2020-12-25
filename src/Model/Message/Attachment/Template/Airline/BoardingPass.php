<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment\Template\Airline;

use Involix\Messenger\Exception\InvalidKeyException;
use Involix\Messenger\Helper\ValidatorTrait;

class BoardingPass implements \JsonSerializable, TravelClassInterface
{
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $passengerName;

    /**
     * @var string
     */
    protected $pnrNumber;

    /**
     * @var string|null
     */
    protected $travelClass;

    /**
     * @var string|null
     */
    protected $seat;

    /**
     * @var array
     */
    protected $auxiliaryFields = [];

    /**
     * @var array
     */
    protected $secondaryFields = [];

    /**
     * @var string
     */
    protected $logoImageUrl;

    /**
     * @var string|null
     */
    protected $headerImageUrl;

    /**
     * @var string|null
     */
    protected $headerTextField;

    /**
     * @var string|null
     */
    protected $qrCode;

    /**
     * @var string|null
     */
    protected $barcodeImageUrl;

    /**
     * @var string
     */
    protected $aboveBarcodeImageUrl;

    /**
     * @var FlightInfo;
     */
    protected $flightInfo;

    /**
     * BoardingPass constructor.
     *
     * @param \Involix\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo $flightInfo
     */
    public function __construct(
        string $passengerName,
        string $pnrNumber,
        string $logoImageUrl,
        string $code,
        string $aboveBarcodeImageUrl,
        FlightInfo $flightInfo
    ) {
        $this->passengerName = $passengerName;
        $this->pnrNumber = $pnrNumber;
        $this->logoImageUrl = $logoImageUrl;
        $this->aboveBarcodeImageUrl = $aboveBarcodeImageUrl;
        $this->flightInfo = $flightInfo;

        $this->setCode($code);
    }

    /**
     * @param \Involix\Messenger\Model\Message\Attachment\Template\Airline\FlightInfo $flightInfo
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public static function create(
        string $passengerName,
        string $pnrNumber,
        string $logoImageUrl,
        string $code,
        string $aboveBarcodeImageUrl,
        FlightInfo $flightInfo
    ): self {
        return new self($passengerName, $pnrNumber, $logoImageUrl, $code, $aboveBarcodeImageUrl, $flightInfo);
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public function setTravelClass(string $travelClass): self
    {
        $this->isValidTravelClass($travelClass);

        $this->travelClass = $travelClass;

        return $this;
    }

    /**
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public function setSeat(string $seat): self
    {
        $this->seat = $seat;

        return $this;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public function addAuxiliaryFields(string $label, string $value): self
    {
        $this->auxiliaryFields[] = $this->setLabelValue($label, $value);

        $this->isValidArray($this->auxiliaryFields, 5);

        return $this;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public function addSecondaryFields(string $label, string $value): self
    {
        $this->secondaryFields[] = $this->setLabelValue($label, $value);

        $this->isValidArray($this->secondaryFields, 5);

        return $this;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public function setHeaderImageUrl(string $headerImageUrl): self
    {
        $this->isValidUrl($headerImageUrl);

        $this->headerImageUrl = $headerImageUrl;

        return $this;
    }

    /**
     * @return \Involix\Messenger\Model\Message\Attachment\Template\Airline\BoardingPass
     */
    public function setHeaderTextField(string $headerTextField): self
    {
        $this->headerTextField = $headerTextField;

        return $this;
    }

    private function setLabelValue(string $label, string $value): array
    {
        return [
            'label' => $label,
            'value' => $value,
        ];
    }

    private function setCode(string $code): void
    {
        if (filter_var($code, FILTER_VALIDATE_URL)) {
            $this->barcodeImageUrl = $code;

            return;
        }
        $this->qrCode = $code;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function isValidTravelClass(string $travelClass): void
    {
        $allowedTravelClass = $this->getAllowedTravelClass();
        if (!\in_array($travelClass, $allowedTravelClass, true)) {
            throw new InvalidKeyException(sprintf('travelClass must be either "%s".', implode(', ', $allowedTravelClass)));
        }
    }

    public function getAllowedTravelClass(): array
    {
        return [
            self::ECONOMY,
            self::BUSINESS,
            self::FIRST_CLASS,
        ];
    }

    public function toArray(): array
    {
        $array = [
            'passenger_name' => $this->passengerName,
            'pnr_number' => $this->pnrNumber,
            'travel_class' => $this->travelClass,
            'seat' => $this->seat,
            'auxiliary_fields' => $this->auxiliaryFields,
            'secondary_fields' => $this->secondaryFields,
            'logo_image_url' => $this->logoImageUrl,
            'header_image_url' => $this->headerImageUrl,
            'header_text_field' => $this->headerTextField,
            'qr_code' => $this->qrCode,
            'barcode_image_url' => $this->barcodeImageUrl,
            'above_bar_code_image_url' => $this->aboveBarcodeImageUrl,
            'flight_info' => $this->flightInfo,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
