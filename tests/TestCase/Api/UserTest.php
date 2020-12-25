<?php

declare(strict_types=1);

namespace Involix\Messenger\Tests\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Involix\Messenger\Api\User;
use Involix\Messenger\Exception\MessengerException;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @var \Involix\Messenger\Api\User
     */
    protected $userApi;

    public function setUp(): void
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/User/user.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $this->userApi = new User('abcd1234', $client);
    }

    public function testGetProfile(): void
    {
        $response = $this->userApi->profile('1234abcd');

        self::assertSame('Peter', $response->getFirstName());
        self::assertSame('Chang', $response->getLastName());
        self::assertSame('https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/p200x200/13055603_10105219398495383_8237637584159975445_n.jpg?oh=1d241d4b6d4dac50eaf9bb73288ea192&oe=57AF5C03&__gda__=1470213755_ab17c8c8e3a0a447fed3f272fa2179ce', $response->getProfilePic());
        self::assertSame('en_US', $response->getLocale());
        self::assertSame(-7., $response->getTimezone());
        self::assertSame('male', $response->getGender());
    }

    public function testGetProfileWithInvalidField(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('username is not a valid value. fields must only contain "first_name, last_name, profile_pic, locale, timezone, gender".');
        $this->userApi->profile('1234abcd', ['username']);
    }
}
