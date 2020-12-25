<?php

declare(strict_types=1);

namespace Involix\Messenger\Request;

use Involix\Messenger\Model\ThreadControl;

class ThreadRequest extends AbstractRequest
{
    /**
     * @var \Involix\Messenger\Model\ThreadControl
     */
    protected $threadControl;

    /**
     * TagRequest constructor.
     */
    public function __construct(string $pageToken, ThreadControl $threadControl)
    {
        parent::__construct($pageToken);

        $this->threadControl = $threadControl;
    }

    protected function buildHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }

    protected function buildBody(): ThreadControl
    {
        return $this->threadControl;
    }
}
