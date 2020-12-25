<?php

declare(strict_types=1);

namespace Involix\Messenger\Tests\TestCase\Model\Message\Attachment\Template;

use Involix\Messenger\Exception\MessengerException;
use Involix\Messenger\Model\Common\Button\Postback;
use Involix\Messenger\Model\Common\Button\WebUrl;
use Involix\Messenger\Model\Message\Attachment\Template\Element\ListElement;
use Involix\Messenger\Model\Message\Attachment\Template\ListTemplate;
use PHPUnit\Framework\TestCase;

class ListTemplateTest extends TestCase
{
    public function testInvalidTopElementStyle(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('topElementStyle must be either "large, compact".');

        $element1 = ListElement::create('Classic White T-Shirt')
            ->setImageUrl('https://peterssendreceiveapp.ngrok.io/img/white-t-shirt.png')
            ->setSubtitle('100% Cotton, 200% Comfortable')
            ->setDefaultAction(
                WebUrl::create('', 'https://peterssendreceiveapp.ngrok.io/view?item=100')
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            )
            ->setButtons([
                WebUrl::create('Buy', 'https://peterssendreceiveapp.ngrok.io/shop?item=100')
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/'),
            ]);

        $element2 = ListElement::create('Classic Blue T-Shirt')
            ->setImageUrl('https://peterssendreceiveapp.ngrok.io/img/blue-t-shirt.png')
            ->setSubtitle('100% Cotton, 200% Comfortable')
            ->setDefaultAction(
                WebUrl::create('', 'https://peterssendreceiveapp.ngrok.io/view?item=101')
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            )
            ->setButtons([
                WebUrl::create('Buy', 'https://peterssendreceiveapp.ngrok.io/shop?item=101')
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/'),
            ]);

        ListTemplate::create([$element1, $element2])
            ->setTopElementStyle('x-large')
            ->setButtons([
                Postback::create('View More', 'payload'),
            ]);
    }
}
