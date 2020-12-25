<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Common\Button;

use Involix\Messenger\Model\Common\Button\Payment\PaymentSummary;

class Payment extends AbstractButton
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $payload;

    /**
     * @var \Involix\Messenger\Model\Common\Button\Payment\PaymentSummary
     */
    protected $paymentSummary;

    /**
     * Payment constructor.
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(string $payload, PaymentSummary $paymentSummary)
    {
        parent::__construct(self::TYPE_PAYMENT);

        $this->isValidString($payload, 1000);

        $this->title = 'buy';
        $this->payload = $payload;
        $this->paymentSummary = $paymentSummary;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Common\Button\Payment
     */
    public static function create(string $payload, PaymentSummary $paymentSummary): self
    {
        return new self($payload, $paymentSummary);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'title' => $this->title,
            'payload' => $this->payload,
            'payment_summary' => $this->paymentSummary,
        ];

        return $array;
    }
}
