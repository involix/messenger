<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment;

use Involix\Messenger\Model\Message\AbstractAttachment;

class File extends AbstractAttachment
{
    /**
     * @var string|null
     */
    protected $url;

    /**
     * @var bool|null
     */
    protected $reusable;

    /**
     * @var string|null
     */
    protected $attachmentId;

    /**
     * File constructor.
     *
     * @param string $type
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(string $url, ?bool $reusable = null, $type = AbstractAttachment::TYPE_FILE)
    {
        parent::__construct($type);

        if ($this->isAttachmentId($url)) {
            $this->attachmentId = $url;
        } else {
            $this->isValidUrl($url);
            $this->url = $url;
        }

        $this->reusable = $reusable;
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\File
     */
    public static function create(string $url, ?bool $reusable = null): self
    {
        return new self($url, $reusable);
    }

    private function isAttachmentId(string $value): bool
    {
        return (bool) preg_match('/^[\d]+$/', $value);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'payload' => [
                'url' => $this->url,
                'is_reusable' => $this->reusable,
                'attachment_id' => $this->attachmentId,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
