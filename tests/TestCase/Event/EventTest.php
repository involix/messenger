<?php

declare(strict_types=1);

namespace Involix\Messenger\Tests\TestCase\Event;

use Involix\Messenger\Event\AccountLinkingEvent;
use Involix\Messenger\Event\AppRolesEvent;
use Involix\Messenger\Event\CheckoutUpdateEvent;
use Involix\Messenger\Event\DeliveryEvent;
use Involix\Messenger\Event\GamePlayEvent;
use Involix\Messenger\Event\MessageEchoEvent;
use Involix\Messenger\Event\MessageEvent;
use Involix\Messenger\Event\OptinEvent;
use Involix\Messenger\Event\PassThreadControlEvent;
use Involix\Messenger\Event\PaymentEvent;
use Involix\Messenger\Event\PolicyEnforcementEvent;
use Involix\Messenger\Event\PostbackEvent;
use Involix\Messenger\Event\PreCheckoutEvent;
use Involix\Messenger\Event\RawEvent;
use Involix\Messenger\Event\ReactionEvent;
use Involix\Messenger\Event\ReadEvent;
use Involix\Messenger\Event\ReferralEvent;
use Involix\Messenger\Event\RequestThreadControlEvent;
use Involix\Messenger\Event\TakeThreadControlEvent;
use Involix\Messenger\Model\Callback\AccountLinking;
use Involix\Messenger\Model\Callback\AppRoles;
use Involix\Messenger\Model\Callback\CheckoutUpdate;
use Involix\Messenger\Model\Callback\Delivery;
use Involix\Messenger\Model\Callback\GamePlay;
use Involix\Messenger\Model\Callback\Message;
use Involix\Messenger\Model\Callback\MessageEcho;
use Involix\Messenger\Model\Callback\Optin;
use Involix\Messenger\Model\Callback\PassThreadControl;
use Involix\Messenger\Model\Callback\Payment;
use Involix\Messenger\Model\Callback\PolicyEnforcement;
use Involix\Messenger\Model\Callback\Postback;
use Involix\Messenger\Model\Callback\PreCheckout;
use Involix\Messenger\Model\Callback\Reaction;
use Involix\Messenger\Model\Callback\Read;
use Involix\Messenger\Model\Callback\Referral;
use Involix\Messenger\Model\Callback\RequestThreadControl;
use Involix\Messenger\Model\Callback\TakeThreadControl;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function testMessageEvent(): void
    {
        $mockedMessage = $this->createMock(Message::class);
        $event = new MessageEvent('sender_id', 'recipient_id', 123456, $mockedMessage);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedMessage, $event->getMessage());
        self::assertSame('message', $event->getName());
        self::assertFalse($event->isQuickReply());
    }

    public function testMessageEchoEvent(): void
    {
        $mockedMessageEcho = $this->createMock(MessageEcho::class);
        $event = new MessageEchoEvent('sender_id', 'recipient_id', 123456, $mockedMessageEcho);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedMessageEcho, $event->getMessageEcho());
        self::assertSame('message_echo', $event->getName());
    }

    public function testReadEvent(): void
    {
        $mockedRead = $this->createMock(Read::class);
        $event = new ReadEvent('sender_id', 'recipient_id', 123456, $mockedRead);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedRead, $event->getRead());
        self::assertSame('read', $event->getName());
    }

    public function testDeliveryEvent(): void
    {
        $mockedDelivery = $this->createMock(Delivery::class);
        $event = new DeliveryEvent('sender_id', 'recipient_id', $mockedDelivery);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame($mockedDelivery, $event->getDelivery());
        self::assertSame('delivery', $event->getName());
    }

    public function testPostbackEvent(): void
    {
        $mockedPostback = $this->createMock(Postback::class);
        $event = new PostbackEvent('sender_id', 'recipient_id', 123456, $mockedPostback);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedPostback, $event->getPostback());
        self::assertSame('postback', $event->getName());
    }

    public function testOptinEvent(): void
    {
        $mockedOptin = $this->createMock(Optin::class);
        $event = new OptinEvent('sender_id', 'recipient_id', 123456, $mockedOptin);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedOptin, $event->getOptin());
        self::assertSame('optin', $event->getName());
    }

    public function testAccountLinkingEvent(): void
    {
        $mockedAccountLinking = $this->createMock(AccountLinking::class);
        $event = new AccountLinkingEvent('sender_id', 'recipient_id', 123456, $mockedAccountLinking);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedAccountLinking, $event->getAccountLinking());
        self::assertSame('account_linking', $event->getName());
    }

    public function testPaymentEvent(): void
    {
        $mockedPayment = $this->createMock(Payment::class);
        $event = new PaymentEvent('sender_id', 'recipient_id', 123456, $mockedPayment);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedPayment, $event->getPayment());
        self::assertSame('payment', $event->getName());
    }

    public function testCheckoutUpdate(): void
    {
        $mockedCheckoutUpdate = $this->createMock(CheckoutUpdate::class);
        $event = new CheckoutUpdateEvent('sender_id', 'recipient_id', 123456, $mockedCheckoutUpdate);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedCheckoutUpdate, $event->getCheckoutUpdate());
        self::assertSame('checkout_update', $event->getName());
    }

    public function testPreCheckout(): void
    {
        $mockedPreCheckout = $this->createMock(PreCheckout::class);
        $event = new PreCheckoutEvent('sender_id', 'recipient_id', 123456, $mockedPreCheckout);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedPreCheckout, $event->getPreCheckout());
        self::assertSame('pre_checkout', $event->getName());
    }

    public function testPassThreadControl(): void
    {
        $mockedPassThreadControl = $this->createMock(PassThreadControl::class);
        $event = new PassThreadControlEvent('sender_id', 'recipient_id', 123456, $mockedPassThreadControl);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedPassThreadControl, $event->getPassThreadControl());
        self::assertSame('pass_thread_control', $event->getName());
    }

    public function testRequestThreadControl(): void
    {
        $mockedRequestThreadControl = $this->createMock(RequestThreadControl::class);
        $event = new RequestThreadControlEvent('sender_id', 'recipient_id', 123456, $mockedRequestThreadControl);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedRequestThreadControl, $event->getRequestThreadControl());
        self::assertSame('request_thread_control', $event->getName());
    }

    public function testTakeThreadControl(): void
    {
        $mockedTakeThreadControl = $this->createMock(TakeThreadControl::class);
        $event = new TakeThreadControlEvent('sender_id', 'recipient_id', 123456, $mockedTakeThreadControl);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedTakeThreadControl, $event->getTakeThreadControl());
        self::assertSame('take_thread_control', $event->getName());
    }

    public function testPolicyEnforcement(): void
    {
        $mockedPolicyEnforcement = $this->createMock(PolicyEnforcement::class);
        $event = new PolicyEnforcementEvent('sender_id', 'recipient_id', 123456, $mockedPolicyEnforcement);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedPolicyEnforcement, $event->getPolicyEnforcement());
        self::assertSame('policy_enforcement', $event->getName());
    }

    public function testAppRoles(): void
    {
        $mockedAppRoles = $this->createMock(AppRoles::class);
        $event = new AppRolesEvent('sender_id', 'recipient_id', 123456, $mockedAppRoles);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedAppRoles, $event->getAppRoles());
        self::assertSame('app_roles', $event->getName());
    }

    public function testGamePlay(): void
    {
        $mockedGamePlay = $this->createMock(GamePlay::class);
        $event = new GamePlayEvent('sender_id', 'recipient_id', 123456, $mockedGamePlay);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedGamePlay, $event->getGamePlay());
        self::assertSame('game_play', $event->getName());
    }

    public function testRawEvent(): void
    {
        $event = new RawEvent('sender_id', 'recipient_id', ['payload' => 'PAYLOAD']);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(['payload' => 'PAYLOAD'], $event->getRaw());
        self::assertSame('raw', $event->getName());
    }

    public function testReferralEvent(): void
    {
        $mockedReferral = $this->createMock(Referral::class);
        $event = new ReferralEvent('sender_id', 'recipient_id', 123456, $mockedReferral);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedReferral, $event->getReferral());
        self::assertSame('referral', $event->getName());
    }

    public function testReactionEvent(): void
    {
        $mockedReaction = $this->createMock(Reaction::class);
        $event = new ReactionEvent('sender_id', 'recipient_id', 123456, $mockedReaction);

        self::assertSame('sender_id', $event->getSenderId());
        self::assertSame('recipient_id', $event->getRecipientId());
        self::assertSame(123456, $event->getTimestamp());
        self::assertSame($mockedReaction, $event->getReaction());
        self::assertSame('reaction', $event->getName());
    }
}
