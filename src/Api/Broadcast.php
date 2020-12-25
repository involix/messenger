<?php

declare(strict_types=1);

namespace Involix\Messenger\Api;

use Involix\Messenger\Exception\InvalidOptionException;
use Involix\Messenger\Helper\ValidatorTrait;
use Involix\Messenger\Request\BroadcastRequest;
use Involix\Messenger\Response\BroadcastResponse;
use Involix\Messenger\SendInterface;

/**
 * @deprecated Since version 3.2.0 and will be removed in version 4.0.0.
 */
class Broadcast extends AbstractApi implements SendInterface
{
    use ValidatorTrait;

    /**
     * @param string|\Involix\Messenger\Model\Message $message
     *
     * @throws \Exception
     */
    public function create($message): BroadcastResponse
    {
        $message = $this->isValidMessage($message);

        $request = new BroadcastRequest($this->pageToken, $message);
        $response = $this->client->post('me/message_creatives', $request->build());

        return new BroadcastResponse($response);
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function send(string $messageCreativeId, array $options = []): BroadcastResponse
    {
        $this->isValidOptions($options);

        $request = new BroadcastRequest($this->pageToken, null, $messageCreativeId, $options);
        $response = $this->client->post('me/broadcast_messages', $request->build());

        return new BroadcastResponse($response);
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidOptions(array $options): void
    {
        $allowedOptionsKeys = $this->getAllowedOptionsKeys();
        foreach ($options as $key => $value) {
            if (!\in_array($key, $allowedOptionsKeys, true)) {
                throw new InvalidOptionException(sprintf('Only "%s" are allowed keys for options.', implode(', ', $allowedOptionsKeys)));
            }

            if ($key === self::OPTION_NOTIFICATION_TYPE) {
                $this->isValidNotificationType($value);
            } elseif ($key === self::OPTION_TAG) {
                $this->isValidTag($value);
            }
        }
    }

    private function getAllowedOptionsKeys(): array
    {
        return [
            self::OPTION_NOTIFICATION_TYPE,
            self::OPTION_TAG,
        ];
    }
}
