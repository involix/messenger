<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message;

use Involix\Messenger\Exception\InvalidTypeException;
use Involix\Messenger\Helper\ValidatorTrait;

class QuickReply implements \JsonSerializable
{
    use ValidatorTrait;

    public const CONTENT_TYPE_TEXT = 'text';
    public const CONTENT_TYPE_PHONE = 'user_phone_number';
    public const CONTENT_TYPE_EMAIL = 'user_email';

    /** @deprecated Since version 3.2.0 and will be removed in version 4.0.0. */
    public const CONTENT_TYPE_LOCATION = 'location';

    /**
     * @var string
     */
    protected $contentType;

    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var string|null
     */
    protected $payload;

    /**
     * @var string|null
     */
    protected $imageUrl;

    /**
     * QuickReply constructor.
     *
     * @throws \Exception
     */
    public function __construct(string $contentType = self::CONTENT_TYPE_TEXT)
    {
        $this->isValidContentType($contentType);

        $this->contentType = $contentType;
    }

    /**
     * @throws \Exception
     *
     * @return \Involix\Messenger\Model\Message\QuickReply
     */
    public static function create(string $contentType = self::CONTENT_TYPE_TEXT): self
    {
        return new self($contentType);
    }

    /**
     * @throws \Exception
     *
     * @return \Involix\Messenger\Model\Message\QuickReply
     */
    public function setTitle(string $title): self
    {
        $this->checkContentType();
        $this->isValidString($title, 20);

        $this->title = $title;

        return $this;
    }

    /**
     * @throws \Exception
     *
     * @return \Involix\Messenger\Model\Message\QuickReply
     */
    public function setPayload(string $payload): self
    {
        $this->checkContentType();
        $this->isValidString($payload, 1000);

        $this->payload = $payload;

        return $this;
    }

    /**
     * @throws \Exception
     *
     * @return \Involix\Messenger\Model\Message\QuickReply
     */
    public function setImageUrl(string $imageUrl): self
    {
        $this->checkContentType();
        $this->isValidUrl($imageUrl);
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @throws \Involix\Messenger\Exception\InvalidTypeException
     */
    private function isValidContentType(string $contentType): void
    {
        $allowedContentType = $this->getAllowedContentType();
        if (!\in_array($contentType, $allowedContentType, true)) {
            throw new InvalidTypeException('Invalid content type.');
        }
    }

    private function getAllowedContentType(): array
    {
        return [
            self::CONTENT_TYPE_TEXT,
            self::CONTENT_TYPE_LOCATION,
            self::CONTENT_TYPE_PHONE,
            self::CONTENT_TYPE_EMAIL,
        ];
    }

    /**
     * @throws \Involix\Messenger\Exception\InvalidTypeException
     */
    private function checkContentType(): void
    {
        if ($this->contentType !== self::CONTENT_TYPE_TEXT) {
            throw new InvalidTypeException('Content type must be set to text to use title, payload and image_url.');
        }
    }

    public function toArray(): array
    {
        $quickReply = [
            'content_type' => $this->contentType,
            'title' => $this->title,
            'payload' => $this->payload,
            'image_url' => $this->imageUrl,
        ];

        return array_filter($quickReply);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
