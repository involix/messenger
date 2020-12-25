<?php

declare(strict_types=1);

namespace Involix\Messenger\Api;

use Involix\Messenger\Exception\InvalidStringException;
use Involix\Messenger\Exception\InvalidTypeException;
use Involix\Messenger\Exception\MessengerException;
use Involix\Messenger\Request\CodeRequest;
use Involix\Messenger\Response\CodeResponse;

/**
 * @deprecated Since version 3.2.0 and will be removed in version 4.0.0.
 */
class Code extends AbstractApi
{
    private const CODE_TYPE_STANDARD = 'standard';

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function request(
        int $imageSize = 1000,
        string $codeType = self::CODE_TYPE_STANDARD,
        ?string $ref = null
    ): CodeResponse {
        $this->isValidCodeImageSize($imageSize);
        $this->isValidCodeType($codeType);

        if ($ref !== null) {
            $this->isValidRef($ref);
        }

        $request = new CodeRequest($this->pageToken, $imageSize, $codeType, $ref);
        $response = $this->client->post('me/messenger_codes', $request->build());

        return new CodeResponse($response);
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidCodeImageSize(int $imageSize): void
    {
        if ($imageSize < 100 || $imageSize > 2000) {
            throw new MessengerException('imageSize must be between 100 and 2000.');
        }
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidCodeType(string $codeType): void
    {
        $allowedCodeType = $this->getAllowedCodeType();
        if (!\in_array($codeType, $allowedCodeType, true)) {
            throw new InvalidTypeException(sprintf('codeType must be either "%s".', implode(', ', $allowedCodeType)));
        }
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidRef(string $ref): void
    {
        if (!preg_match('/^[a-zA-Z0-9\+\/=\-.:_ ]{1,250}$/', $ref)) {
            throw new InvalidStringException('ref must be a string of max 250 characters. Valid characters are "a-z A-Z 0-9 +/=-.:_".');
        }
    }

    private function getAllowedCodeType(): array
    {
        return [
            self::CODE_TYPE_STANDARD,
        ];
    }
}
