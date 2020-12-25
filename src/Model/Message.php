<?php

declare(strict_types=1);

namespace Involix\Messenger\Model;

use Involix\Messenger\Exception\InvalidClassException;
use Involix\Messenger\Exception\MessengerException;
use Involix\Messenger\Helper\ValidatorTrait;
use Involix\Messenger\Model\Message\AbstractAttachment;
use Involix\Messenger\Model\Message\QuickReply;

class Message implements \JsonSerializable
{
    use ValidatorTrait;

    private const TYPE_TEXT = 'text';
    private const TYPE_ATTACHMENT = 'attachment';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var \Involix\Messenger\Model\Message\AbstractAttachment|string
     */
    protected $message;

    /**
     * @var \Involix\Messenger\Model\Message\QuickReply[]
     */
    protected $quickReplies = [];

    /**
     * @var string
     */
    protected $metadata;

    /**
     * Message constructor.
     *
     * @param \Involix\Messenger\Model\Message\AbstractAttachment|string $message
     *
     * @throws \Exception
     */
    public function __construct($message)
    {
        if (\is_string($message)) {
            $this->isValidString($message, 640);
            $this->type = self::TYPE_TEXT;
        } elseif ($message instanceof AbstractAttachment) {
            $this->type = self::TYPE_ATTACHMENT;
        } else {
            throw new MessengerException(sprintf('message must be a string or an instance of %s.', AbstractAttachment::class));
        }

        $this->message = $message;
    }

    /**
     * @param \Involix\Messenger\Model\Message\AbstractAttachment|string $message
     *
     * @throws \Exception
     *
     * @return \Involix\Messenger\Model\Message
     */
    public static function create($message): self
    {
        return new self($message);
    }

    /**
     * @param \Involix\Messenger\Model\Message\QuickReply[] $quickReplies
     *
     * @throws \Exception
     *
     * @return \Involix\Messenger\Model\Message
     */
    public function setQuickReplies(array $quickReplies): self
    {
        $this->isValidQuickReplies($quickReplies);

        $this->quickReplies = $quickReplies;

        return $this;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message
     */
    public function addQuickReply(QuickReply $quickReply): self
    {
        $this->isValidArray($this->quickReplies, 11);

        $this->quickReplies[] = $quickReply;

        return $this;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return Message
     */
    public function setMetadata(string $metadata): self
    {
        $this->isValidString($metadata, 1000);

        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    private function isValidQuickReplies(array $quickReplies): void
    {
        $this->isValidArray($quickReplies, 12, 1);
        foreach ($quickReplies as $quickReply) {
            if (!$quickReply instanceof QuickReply) {
                throw new InvalidClassException(sprintf('Array can only contain instance of %s.', QuickReply::class));
            }
        }
    }

    public function toArray(): array
    {
        $array = [
            $this->type => $this->message,
            'quick_replies' => $this->quickReplies,
            'metadata' => $this->metadata,
        ];

        return array_filter($array);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
