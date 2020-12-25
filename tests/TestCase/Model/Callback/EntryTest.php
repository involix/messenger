<?php

declare(strict_types=1);

namespace Involix\Messenger\Tests\TestCase\Model\Callback;

use Involix\Messenger\Event\MessageEvent;
use Involix\Messenger\Model\Callback\Entry;
use Involix\Messenger\Model\Callback\Message;
use PHPUnit\Framework\TestCase;

class EntryTest extends TestCase
{
    public function testEntryCallback(): void
    {
        $payload = [
            'id' => 'PAGE_ID',
            'time' => 1458692752478,
            'messaging' => [
                [
                    'sender' => [
                        'id' => 'USER_ID',
                    ],
                    'recipient' => [
                        'id' => 'PAGE_ID',
                    ],
                    'timestamp' => 1458692752478,
                    'message' => [
                        'mid' => 'mid.1457764197618:41d102a3e1ae206a38',
                        'text' => 'hello, world!',
                        'quick_reply' => [
                            'payload' => 'DEVELOPER_DEFINED_PAYLOAD',
                        ],
                    ],
                ],
            ],
        ];

        $messageEvent = new MessageEvent('USER_ID', 'PAGE_ID', 1458692752478, new Message('mid.1457764197618:41d102a3e1ae206a38', 'hello, world!', 'DEVELOPER_DEFINED_PAYLOAD'));
        $entry = Entry::create($payload);

        self::assertSame('PAGE_ID', $entry->getId());
        self::assertSame(1458692752478, $entry->getTime());
        self::assertEquals([$messageEvent], $entry->getEvents());
    }
}
