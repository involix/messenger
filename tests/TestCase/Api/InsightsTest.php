<?php

declare(strict_types=1);

namespace Involix\Messenger\Tests\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Involix\Messenger\Api\Insights;
use Involix\Messenger\Exception\MessengerException;
use Involix\Messenger\Model\Data;
use PHPUnit\Framework\TestCase;

class InsightsTest extends TestCase
{
    /**
     * @var \Involix\Messenger\Api\Insights
     */
    protected $insightsApi;

    public function setUp(): void
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Insights/insights.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $this->insightsApi = new Insights('abcd1234', $client);
    }

    public function testGetInsights(): void
    {
        $response = $this->insightsApi->get();

        self::assertContainsOnlyInstancesOf(Data::class, $response->getData());
    }

    public function testGetInsightsWithInvalidMetric(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('page_fan_adds_unique is not a valid value. Metrics must only contain "page_messages_active_threads_unique, page_messages_blocked_conversations_unique, page_messages_reported_conversations_unique, page_messages_reported_conversations_by_report_type_unique, page_messages_feedback_by_action_unique".');
        $this->insightsApi->get(['page_fan_adds_unique']);
    }
}
