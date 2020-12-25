<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Common\Button;

use Involix\Messenger\Helper\ValidatorTrait;

abstract class AbstractButton implements \JsonSerializable
{
    use ValidatorTrait;

    public const TYPE_POSTBACK = 'postback';
    public const TYPE_PHONE_NUMBER = 'phone_number';
    public const TYPE_WEB_URL = 'web_url';
    public const TYPE_PAYMENT = 'payment';
    public const TYPE_ACCOUNT_LINK = 'account_link';
    public const TYPE_ACCOUNT_UNLINK = 'account_unlink';

    /** @deprecated Since version 3.3.1 and will be removed in version 4.0.0. */
    public const TYPE_SHARE = 'element_share';

    /** @deprecated Since version 3.3.1 and will be removed in version 4.0.0. */
    public const TYPE_NESTED = 'nested';

    /**
     * @var string
     */
    private $type;

    /**
     * AbstractButton constructor.
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
