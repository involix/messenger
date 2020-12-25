<?php

declare(strict_types=1);

namespace Involix\Messenger\Api;

use Involix\Messenger\Exception\InvalidKeyException;
use Involix\Messenger\Model\ProfileSettings;
use Involix\Messenger\ProfileInterface;
use Involix\Messenger\Request\ProfileRequest;
use Involix\Messenger\Response\ProfileResponse;

class Profile extends AbstractApi implements ProfileInterface
{
    public function add(ProfileSettings $profileSettings): ProfileResponse
    {
        $request = new ProfileRequest($this->pageToken, $profileSettings);
        $response = $this->client->post('me/messenger_profile', $request->build());

        return new ProfileResponse($response);
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function get(array $profileSettings): ProfileResponse
    {
        $this->isValidFields($profileSettings);

        $profileSettings = implode(',', $profileSettings);

        $request = new ProfileRequest($this->pageToken, $profileSettings);
        $response = $this->client->get('me/messenger_profile', $request->build());

        return new ProfileResponse($response);
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function delete(array $profileSettings): ProfileResponse
    {
        $this->isValidFields($profileSettings);

        $request = new ProfileRequest($this->pageToken, $profileSettings);
        $response = $this->client->delete('me/messenger_profile', $request->build());

        return new ProfileResponse($response);
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidFields(array $fields): void
    {
        $allowedFields = $this->getAllowedFields();
        foreach ($fields as $field) {
            if (!\in_array($field, $allowedFields, true)) {
                throw new InvalidKeyException(sprintf('%s is not a valid value. fields must only contain "%s".', $field, implode(', ', $allowedFields)));
            }
        }
    }

    private function getAllowedFields(): array
    {
        return [
            self::GET_STARTED,
            self::GREETING,
            self::ICE_BREAKERS,
            self::PERSISTENT_MENU,
            self::DOMAIN_WHITELISTING,
            self::ACCOUNT_LINKING_URL,
            self::PAYMENT_SETTINGS,
            self::HOME_URL,
            self::TARGET_AUDIENCE,
        ];
    }
}
