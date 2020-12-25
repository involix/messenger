<?php

declare(strict_types=1);

namespace Involix\Messenger\Tests\TestCase;

use Involix\Messenger\Api\Broadcast;
use Involix\Messenger\Api\Code;
use Involix\Messenger\Api\Insights;
use Involix\Messenger\Api\Nlp;
use Involix\Messenger\Api\Persona;
use Involix\Messenger\Api\Profile;
use Involix\Messenger\Api\Send;
use Involix\Messenger\Api\Tag;
use Involix\Messenger\Api\Thread;
use Involix\Messenger\Api\User;
use Involix\Messenger\Api\Webhook;
use Involix\Messenger\Messenger;
use PHPUnit\Framework\TestCase;

class MessengerTest extends TestCase
{
    /**
     * @var Messenger
     */
    protected $messenger;

    public function setUp(): void
    {
        $this->messenger = new Messenger('4321dcba', 'abcd1234', '1234abcd');
    }

    public function testGetInstanceOfApi(): void
    {
        self::assertInstanceOf(Send::class, $this->messenger->send());
        self::assertInstanceOf(User::class, $this->messenger->user());
        self::assertInstanceOf(Webhook::class, $this->messenger->webhook());
        self::assertInstanceOf(Code::class, $this->messenger->code());
        self::assertInstanceOf(Insights::class, $this->messenger->insights());
        self::assertInstanceOf(Profile::class, $this->messenger->profile());
        self::assertInstanceOf(Tag::class, $this->messenger->tag());
        self::assertInstanceOf(Thread::class, $this->messenger->thread());
        self::assertInstanceOf(Nlp::class, $this->messenger->nlp());
        self::assertInstanceOf(Broadcast::class, $this->messenger->broadcast());
        self::assertInstanceOf(Persona::class, $this->messenger->persona());
    }

    public function tearDown(): void
    {
        unset($this->messenger);
    }
}
