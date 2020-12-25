<?php

declare(strict_types=1);

namespace Involix\Messenger\Tests\TestCase\Model;

use Involix\Messenger\Model\Common\Button\Nested;
use Involix\Messenger\Model\Common\Button\Postback;
use Involix\Messenger\Model\Common\Button\WebUrl;
use Involix\Messenger\Model\ProfileSettings;
use Involix\Messenger\Model\ProfileSettings\Greeting;
use Involix\Messenger\Model\ProfileSettings\HomeUrl;
use Involix\Messenger\Model\ProfileSettings\IceBreakers;
use Involix\Messenger\Model\ProfileSettings\PaymentSettings;
use Involix\Messenger\Model\ProfileSettings\PersistentMenu;
use Involix\Messenger\Model\ProfileSettings\TargetAudience;
use PHPUnit\Framework\TestCase;

class ProfileSettingsTest extends TestCase
{
    /**
     * @var ProfileSettings
     */
    protected $profileSettings;

    public function setUp(): void
    {
        $this->profileSettings = ProfileSettings::create();
    }

    public function testPersistentMenu(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/persistent_menu.json');
        $persistentMenus = $this->profileSettings->addPersistentMenus([
            PersistentMenu::create()
                ->setComposerInputDisabled(true)
                ->addButtons([
                    Nested::create('My Account', [
                        Postback::create('Pay Bill', 'PAYBILL_PAYLOAD'),
                        Postback::create('History', 'HISTORY_PAYLOAD'),
                        Postback::create('Contact Info', 'CONTACT_INFO_PAYLOAD'),
                    ]),
                    WebUrl::create('Latest News', 'http://petershats.parseapp.com/hat-news')
                        ->setWebviewHeightRatio('full'),
                ]),
            PersistentMenu::create('zh_CN'),
        ]);

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($persistentMenus));
    }

    public function testStartButton(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/get_started.json');
        $startButton = $this->profileSettings->addStartButton('GET_STARTED_PAYLOAD');

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($startButton));
    }

    public function testGreeting(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/greeting.json');
        $greetings = $this->profileSettings->addGreetings([
            Greeting::create('Hello!'),
            Greeting::create('Timeless apparel for the masses.', 'en_US'),
        ]);

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($greetings));
    }

    public function testIceBreakers(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/ice_breakers.json');
        $iceBreakers = $this->profileSettings->addIceBreakers([
            IceBreakers::create('Where are you located?', 'LOCATION_POSTBACK_PAYLOAD'),
            IceBreakers::create('What are your hours?', 'HOURS_POSTBACK_PAYLOAD'),
            IceBreakers::create('Can you tell me more about your business?', 'MORE_POSTBACK_PAYLOAD'),
            IceBreakers::create('What services do you offer?', 'SERVICES_POSTBACK_PAYLOAD'),
        ]);

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($iceBreakers));
    }

    public function testWhitelistedDomains(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/whitelisted_domains.json');
        $whitelistedDomains = $this->profileSettings->addWhitelistedDomains([
            'https://petersfancyapparel.com',
        ]);

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($whitelistedDomains));
    }

    public function testAccountLinkingUrl(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/account_linking_url.json');
        $accountLinkingUrl = $this->profileSettings->addAccountLinkingUrl('https://www.example.com/oauth?response_type=code&client_id=1234567890&scope=basic');

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($accountLinkingUrl));
    }

    public function testPaymentSettings(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/payment_settings.json');
        $paymentSettings = $this->profileSettings->addPaymentSettings(
            PaymentSettings::create()
                ->setPrivacyUrl('http://www.facebook.com')
                ->setPublicKey('YOUR_PUBLIC_KEY')
                ->addTestUser(12345678)
        );

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($paymentSettings));
    }

    public function testHomeUrl(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/home_url.json');
        $homeUrl = $this->profileSettings->addHomeUrl(HomeUrl::create(
            'https://chat.example.com',
            'tall',
            'show'
        ));

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($homeUrl));
    }

    public function testTargetAudience(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/ProfileSettings/target_audience.json');
        $targetAudience = $this->profileSettings->addTargetAudience(
            TargetAudience::create('custom', ['US'], ['FR'])
                ->addWhitelistCountry('CA')
                ->addBlacklistCountry('IT')
        );

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($targetAudience));
    }

    public function tearDown(): void
    {
        unset($this->profileSettings);
    }
}
