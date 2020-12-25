<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Message\Attachment;

use Involix\Messenger\Model\Message\AbstractAttachment;

class Image extends File
{
    protected const ALLOWED_EXTENSIONS = ['jpg', 'png', 'gif'];

    /**
     * Image constructor.
     *
     * @throws \Involix\Messenger\Exception\MessengerException
     */
    public function __construct(string $url, ?bool $reusable = null)
    {
        $this->isValidExtension($url, $this->getAllowedExtensions());

        parent::__construct($url, $reusable, AbstractAttachment::TYPE_IMAGE);
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

    protected function getAllowedExtensions(): array
    {
        return self::ALLOWED_EXTENSIONS;
    }
}
