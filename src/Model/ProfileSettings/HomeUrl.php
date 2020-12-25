<?php

declare(strict_types=1);

namespace Involix\Messenger\Model\ProfileSettings;

use Involix\Messenger\Helper\ValidatorTrait;
use Involix\Messenger\Model\Common\Button\WebUrl;

class HomeUrl implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $webviewHeightRation;

    /**
     * @var string
     */
    protected $webviewShareButton;

    /**
     * @var bool
     */
    protected $inTest;

    /**
     * HomeUrl constructor.
     *
     * @throws \Involix\Messenger\Exception\InvalidUrlException
     */
    public function __construct(
        string $url,
        string $webviewHeightRation = WebUrl::RATIO_TYPE_TALL,
        string $webviewShareButton = 'hide',
        bool $inTest = true
    ) {
        $this->isValidUrl($url);

        $this->url = $url;
        $this->webviewHeightRation = $webviewHeightRation;
        $this->webviewShareButton = $webviewShareButton;
        $this->inTest = $inTest;
    }

    /**
     * @throws \Involix\Messenger\Exception\InvalidUrlException
     *
     * @return \Involix\Messenger\Model\ProfileSettings\HomeUrl
     */
    public static function create(
        string $url,
        string $webviewHeightRation = WebUrl::RATIO_TYPE_TALL,
        string $webviewShareButton = 'hide',
        bool $inTest = true
    ): self {
        return new self($url, $webviewHeightRation, $webviewShareButton, $inTest);
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'webview_height_ration' => $this->webviewHeightRation,
            'webview_share_button' => $this->webviewShareButton,
            'in_test' => $this->inTest,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
