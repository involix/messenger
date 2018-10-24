<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Exception\InvalidOptionException;
use Kerox\Messenger\Helper\ValidatorTrait;
use Kerox\Messenger\Model\Message\Attachment;
use Kerox\Messenger\Request\SendRequest;
use Kerox\Messenger\Response\SendResponse;
use Kerox\Messenger\SendInterface;

class Send extends AbstractApi implements SendInterface
{
    use ValidatorTrait;

    /**
     * @param string                                $recipient
     * @param \Kerox\Messenger\Model\Message|string $message
     * @param array                                 $options
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Response\SendResponse
     */
    public function message(string $recipient, $message, array $options = []): SendResponse
    {
        $message = $this->isValidMessage($message);
        $options = $this->isValidOptions($options, $message);

        $request = new SendRequest('me/messages', $message, $recipient, $options);
        $response = $this->client->sendRequest($request->build());

        return new SendResponse($response);
    }

    /**
     * @param string $recipient
     * @param string $action
     * @param array  $options
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Messenger\Response\SendResponse
     */
    public function action(string $recipient, string $action, array $options = []): SendResponse
    {
        $this->isValidSenderAction($action);
        $options = $this->isValidOptions($options, $action);

        $request = new SendRequest('me/messages', $action, $recipient, $options, SendRequest::REQUEST_TYPE_ACTION);
        $response = $this->client->sendRequest($request->build());

        return new SendResponse($response);
    }

    /**
     * @param \Kerox\Messenger\Model\Message\Attachment $attachment
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return \Kerox\Messenger\Response\SendResponse
     */
    public function attachment(Attachment $attachment): SendResponse
    {
        $message = $this->isValidMessage($attachment);

        $request = new SendRequest('me/message_attachments', $message);
        $response = $this->client->sendRequest($request->build());

        return new SendResponse($response);
    }

    /**
     * @param array $options
     * @param       $message
     *
     * @throws \Kerox\Messenger\Exception\MessengerException
     *
     * @return array
     */
    private function isValidOptions(array $options, $message): array
    {
        $allowedOptionsKeys = $this->getAllowedOptionsKeys();
        foreach ($options as $key => $value) {
            if (!\in_array($key, $allowedOptionsKeys, true)) {
                throw new InvalidOptionException(sprintf(
                    'Only "%s" are allowed keys for options.',
                    implode(', ', $allowedOptionsKeys)
                ));
            }

            if ($key === self::OPTION_MESSAGING_TYPE) {
                $this->isValidMessagingType($value);
            } elseif ($key === self::OPTION_NOTIFICATION_TYPE) {
                $this->isValidNotificationType($value);
            } elseif ($key === self::OPTION_TAG) {
                $this->isValidTag($value, $message);
            }
        }

        return $options;
    }

    /**
     * @return array
     */
    private function getAllowedOptionsKeys(): array
    {
        return [
            self::OPTION_MESSAGING_TYPE,
            self::OPTION_NOTIFICATION_TYPE,
            self::OPTION_TAG,
            self::OPTION_PERSONA_ID,
        ];
    }
}
