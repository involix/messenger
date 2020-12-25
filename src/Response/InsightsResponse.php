<?php

declare(strict_types=1);

namespace Involix\Messenger\Response;

use Involix\Messenger\Model\Data;

class InsightsResponse extends AbstractResponse
{
    private const DATA = 'data';

    /**
     * @var \Involix\Messenger\Model\Data[]
     */
    protected $data = [];

    protected function parseResponse(array $response): void
    {
        $this->setData($response);
    }

    /**
     * @return \Involix\Messenger\Model\Data[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    private function setData(array $response): void
    {
        if (isset($response[self::DATA]) && !empty($response[self::DATA])) {
            foreach ($response[self::DATA] as $data) {
                $this->data[] = Data::create($data);
            }
        }
    }
}
