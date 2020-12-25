<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Common\Button\Payment;

use Involix\Messenger\Exception\InvalidKeyException;
use Involix\Messenger\Exception\InvalidTypeException;

class PaymentSummary implements \JsonSerializable
{
    public const PAYMENT_TYPE_FIXED_AMOUNT = 'FIXED_AMOUNT';
    public const PAYMENT_TYPE_FLEXIBLE_AMOUNT = 'FLEXIBLE_AMOUNT';

    public const USER_INFO_SHIPPING_ADDRESS = 'shipping_address';
    public const USER_INFO_CONTACT_NAME = 'contact_name';
    public const USER_INFO_CONTACT_PHONE = 'contact_phone';
    public const USER_INFO_CONTACT_EMAIL = 'contact_email';

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var bool|null
     */
    protected $isTestPayment;

    /**
     * @var string
     */
    protected $paymentType;

    /**
     * @var string
     */
    protected $merchantName;

    /**
     * @var array
     */
    protected $requestedUserInfo = [];

    /**
     * @var array
     */
    protected $priceList = [];

    /**
     * PaymentSummary constructor.
     *
     * @param PriceList[] $priceList
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(
        string $currency,
        string $paymentType,
        string $merchantName,
        array $requestedUserInfo,
        array $priceList
    ) {
        $this->isValidPaymentType($paymentType);
        $this->isValidRequestedUserInfo($requestedUserInfo);

        $this->currency = $currency;
        $this->paymentType = $paymentType;
        $this->merchantName = $merchantName;
        $this->requestedUserInfo = $requestedUserInfo;
        $this->priceList = $priceList;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Common\Button\Payment\PaymentSummary
     */
    public static function create(
        string $currency,
        string $paymentType,
        string $merchantName,
        array $requestedUserInfo,
        array $priceList
    ): self {
        return new self($currency, $paymentType, $merchantName, $requestedUserInfo, $priceList);
    }

    /**
     * @return PaymentSummary
     */
    public function isTestPayment(bool $isTestPayment): self
    {
        $this->isTestPayment = $isTestPayment;

        return $this;
    }

    /**
     * @return PaymentSummary
     */
    public function addPriceList(string $label, string $amount): self
    {
        $this->priceList[] = new PriceList($label, $amount);

        return $this;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidPaymentType(string $paymentType): void
    {
        $allowedPaymentType = $this->getAllowedPaymentType();
        if (!\in_array($paymentType, $allowedPaymentType, true)) {
            throw new InvalidTypeException(sprintf('paymentType must be either "%s".', implode(', ', $allowedPaymentType)));
        }
    }

    private function getAllowedPaymentType(): array
    {
        return [
            self::PAYMENT_TYPE_FIXED_AMOUNT,
            self::PAYMENT_TYPE_FLEXIBLE_AMOUNT,
        ];
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidRequestedUserInfo(array $requestedUserInfo): void
    {
        $allowedUserInfo = $this->getAllowedUserInfo();
        foreach ($requestedUserInfo as $userInfo) {
            if (!\in_array($userInfo, $allowedUserInfo, true)) {
                throw new InvalidKeyException(sprintf('%s is not a valid value. Valid values are "%s".', $userInfo, implode(', ', $allowedUserInfo)));
            }
        }
    }

    private function getAllowedUserInfo(): array
    {
        return [
            self::USER_INFO_SHIPPING_ADDRESS,
            self::USER_INFO_CONTACT_NAME,
            self::USER_INFO_CONTACT_PHONE,
            self::USER_INFO_CONTACT_EMAIL,
        ];
    }

    public function toArray(): array
    {
        $array = [
            'currency' => $this->currency,
            'payment_type' => $this->paymentType,
            'is_test_payment' => $this->isTestPayment,
            'merchant_name' => $this->merchantName,
            'requested_user_info' => $this->requestedUserInfo,
            'price_list' => $this->priceList,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
