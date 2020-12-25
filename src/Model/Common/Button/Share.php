<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\Common\Button;

use Involix\Messenger\Helper\UtilityTrait;
use Involix\Messenger\Model\Message\Attachment\Template\GenericTemplate;

/**
 * @deprecated Since version 3.2.0 and will be removed in version 4.0.0.
 */
class Share extends AbstractButton
{
    use UtilityTrait;

    /**
     * @var \Involix\Messenger\Model\Message\Attachment\Template\GenericTemplate|null
     */
    protected $content;

    /**
     * Share constructor.
     */
    public function __construct(?GenericTemplate $content = null)
    {
        parent::__construct(self::TYPE_SHARE);

        $this->content = $content;
    }

    /**
     * @return \Involix\Messenger\Model\Common\Button\Share
     */
    public static function create(?GenericTemplate $content = null): self
    {
        return new self($content);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array += [
            'share_contents' => [
                'attachment' => $this->content,
            ],
        ];

        return $this->arrayFilter($array);
    }
}
