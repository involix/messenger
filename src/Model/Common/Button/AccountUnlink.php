<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Common\Button;

class AccountUnlink extends AbstractButton
{
    /**
     * AccountUnlink constructor.
     */
    public function __construct()
    {
        parent::__construct(self::TYPE_ACCOUNT_UNLINK);
    }

    /**
     * @return \Involix\Messenger\Model\Common\Button\AccountUnlink
     */
    public static function create(): self
    {
        return new self();
    }
}
