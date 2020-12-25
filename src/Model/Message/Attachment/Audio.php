<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment;

use Involix\Messenger\Model\Message\AbstractAttachment;

class Audio extends File
{
    /**
     * Audio constructor.
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(string $url, ?bool $reusable = null)
    {
        parent::__construct($url, $reusable, AbstractAttachment::TYPE_AUDIO);
    }

    /**
     * @throws \Involix\Messenger\Exception\MessengerException
     *
     * @return \Involix\Messenger\Model\Message\Attachment\File
     */
    public static function create(string $url, ?bool $reusable = null): File
    {
        return new self($url, $reusable);
    }
}
