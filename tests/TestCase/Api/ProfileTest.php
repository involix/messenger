<?php

declare(strict_types=1);

namespace Involix\Messenger\Tests\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Involix\Messenger\Api\Profile;
use Involix\Messenger\Exception\MessengerException;
use Involix\Messenger\Model\ProfileSettings;
use Involix\Messenger\Model\ProfileSettings\Greeting;
use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
    /**
     * @var \Involix\Messenger\Api\Profile
     */
    protected $profileApi;

    public function setUp(): void
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Profile/add.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $this->profileApi = new Profile('abcd1234', $client);
    }

    public function testAddSetting(): void
    {
        $profileSettings = new ProfileSettings();
        $profileSettings->addGreetings([
            new Greeting('Hello!'),
        ]);

        $response = $this->profileApi->add($profileSettings);

        self::assertSame('success', $response->getResult());
    }

    public function testGetSettings(): void
    {
        $response = $this->profileApi->get(['greeting', 'get_started']);

        self::assertSame('success', $response->getResult());
    }

    public function testDeleteSetting(): void
    {
        $response = $this->profileApi->delete(['greeting', 'get_started']);

        self::assertSame('success', $response->getResult());
    }

    public function testInvalidField(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('menu is not a valid value. fields must only contain "get_started, greeting, ice_breakers, persistent_menu, whitelisted_domains, account_linking_url, payment_settings, home_url, target_audience".');
        $this->profileApi->delete(['menu']);
    }

    public function tearDown(): void
    {
        unset($this->profileApi);
    }
}
