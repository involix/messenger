<?php

declare(strict_types=1);

namespace Involix\Messenger\Tests\TestCase\Model\ProfileSettings;

use Involix\Messenger\Exception\MessengerException;
use Involix\Messenger\Model\Common\Button\Nested;
use Involix\Messenger\Model\Common\Button\PhoneNumber;
use Involix\Messenger\Model\Common\Button\Postback;
use Involix\Messenger\Model\Common\Button\WebUrl;
use Involix\Messenger\Model\ProfileSettings\PersistentMenu;
use PHPUnit\Framework\TestCase;

class PersistentMenuTest extends TestCase
{
    public function testInvalidButton(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('Array can only contain instance of "Involix\Messenger\Model\Common\Button\AbstractButton".');

        PersistentMenu::create()->setComposerInputDisabled(true)->addButtons([
            'Phone Number' => [
                'payload' => 'PHONE_NUMBER_PAYLOAD',
            ],
        ]);
    }

    public function testInvalidButtonType(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('Buttons can only be an instance of "web_url, postback, nested".');

        PersistentMenu::create()->setComposerInputDisabled(true)->addButtons([
            PhoneNumber::create('Phone number', 'PHONE_NUMBER_PAYLOAD'),
            Nested::create('My Account', [
                Postback::create('Pay Bill', 'PAYBILL_PAYLOAD'),
                Postback::create('History', 'HISTORY_PAYLOAD'),
                Postback::create('Contact Info', 'CONTACT_INFO_PAYLOAD'),
            ]),
            WebUrl::create('Latest News', 'http://petershats.parseapp.com/hat-news')->setWebviewHeightRatio('full'),
        ]);
    }
}
