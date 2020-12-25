<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment\Template;

use Involix\Messenger\Model\Common\Address;
use Involix\Messenger\Model\Message\Attachment\AbstractTemplate;
use Involix\Messenger\Model\Message\Attachment\Template\Receipt\Summary;

class ReceiptTemplate extends AbstractTemplate
{
    /**
     * @var string
     */
    protected $recipientName;

    /**
     * @var string
     */
    protected $orderNumber;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $paymentMethod;

    /**
     * @var string
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $orderUrl;

    /**
     * @var \Involix\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement[]
     */
    protected $elements;

    /**
     * @var \Involix\Messenger\Model\Common\Address|null
     */
    protected $address;

    /**
     * @var \Involix\Messenger\Model\Message\Attachment\Template\Receipt\Summary
     */
    protected $summary;

    /**
     * @var \Involix\Messenger\Model\Message\Attachment\Template\Receipt\Adjustment[]|null
     */
    protected $adjustments;

    /**
     * Receipt constructor.
     *
     * @param \Involix\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement[] $elements
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(
        string $recipientName,
        string $orderNumber,
        string $currency,
        string $paymentMethod,
        array $elements,
        Summary $summary
    ) {
        parent::__construct();

        $this->isValidArray($elements, 100);

        $this->recipientName = $recipientName;
        $this->orderNumber = $orderNumber;
        $this->currency = $currency;
        $this->paymentMethod = $paymentMethod;
        $this->elements = $elements;
        $this->summary = $summary;
    }

    /**
     *@throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\ReceiptTemplate
     */
    public static function create(
        string $recipientName,
        string $orderNumber,
        string $currency,
        string $paymentMethod,
        array $elements,
        Summary $summary
    ): self {
        return new self($recipientName, $orderNumber, $currency, $paymentMethod, $elements, $summary);
    }

    /**
     * @return \Involix\Messenger\Model\Message\Attachment\Template\ReceiptTemplate
     */
    public function setTimestamp(string $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     *@throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\ReceiptTemplate
     */
    public function setOrderUrl(string $orderUrl): self
    {
        $this->isValidUrl($orderUrl);

        $this->orderUrl = $orderUrl;

        return $this;
    }

    /**
     * @return \Involix\Messenger\Model\Message\Attachment\Template\ReceiptTemplate
     */
    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @param \Involix\Messenger\Model\Message\Attachment\Template\Receipt\Adjustment[] $adjustments
     *
     * @return \Involix\Messenger\Model\Message\Attachment\Template\ReceiptTemplate
     */
    public function setAdjustments(array $adjustments): self
    {
        $this->adjustments = $adjustments;

        return $this;
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'template_type' => AbstractTemplate::TYPE_RECEIPT,
                'recipient_name' => $this->recipientName,
                'order_number' => $this->orderNumber,
                'currency' => $this->currency,
                'payment_method' => $this->paymentMethod,
                'order_url' => $this->orderUrl,
                'timestamp' => $this->timestamp,
                'elements' => $this->elements,
                'address' => $this->address,
                'summary' => $this->summary,
                'adjustments' => $this->adjustments,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
