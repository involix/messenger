<?php

declare(strict_types=1);

namespace Involix\Messenger\Tests\TestCase\Model\Common\Button;

use Involix\Messenger\Exception\MessengerException;
use Involix\Messenger\Model\Common\Button\WebUrl;
use PHPUnit\Framework\TestCase;

class WebUrlTest extends TestCase
{
    public function testButtonWebUrlWithIncorrectWebviewHeightRatio(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('webviewHeightRatio must be either "compact, tall, full".');

        WebUrl::create('Select Criteria', 'https://petersfancyapparel.com/criteria_selector')
            ->setWebviewHeightRatio('tail');
    }
}
