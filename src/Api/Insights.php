<?php

declare(strict_types=1);

namespace Involix\Messenger\Api;

use Involix\Messenger\Exception\InvalidKeyException;
use Involix\Messenger\InsightsInterface;
use Involix\Messenger\Request\InsightsRequest;
use Involix\Messenger\Response\InsightsResponse;

class Insights extends AbstractApi implements InsightsInterface
{
    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function get(array $metrics = [], ?int $since = null, ?int $until = null): InsightsResponse
    {
        $metrics = $this->isValidMetrics($metrics);

        $request = new InsightsRequest($this->pageToken, $metrics, $since, $until);
        $response = $this->client->get('me/insights', $request->build());

        return new InsightsResponse($response);
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidMetrics(array $metrics): array
    {
        $allowedMetrics = $this->getAllowedMetrics();

        $metrics = empty($metrics) ? $allowedMetrics : $metrics;
        if ($metrics !== $allowedMetrics) {
            array_map(function ($metric) use ($allowedMetrics): void {
                if (!\in_array($metric, $allowedMetrics, true)) {
                    throw new InvalidKeyException(sprintf('%s is not a valid value. Metrics must only contain "%s".', $metric, implode(', ', $allowedMetrics)));
                }
            }, $metrics);
        }

        return $metrics;
    }

    private function getAllowedMetrics(): array
    {
        return [
            self::ACTIVE_THREAD_UNIQUE,
            self::BLOCKED_CONVERSATIONS_UNIQUE,
            self::REPORTED_CONVERSATIONS_UNIQUE,
            self::REPORTED_CONVERSATIONS_BY_REPORT_TYPE_UNIQUE,
            self::FEEDBACK_BY_ACTION_UNIQUE,
        ];
    }
}
