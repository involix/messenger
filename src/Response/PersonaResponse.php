<?php

declare(strict_types=1);

namespace Involix\Messenger\Response;

use Involix\Messenger\Model\Data;

class PersonaResponse extends AbstractResponse
{
    private const ID = 'id';
    private const NAME = 'name';
    private const PROFILE_PICTURE_URL = 'profile_picture_url';
    private const SUCCESS = 'success';
    private const DATA = 'data';
    private const PAGING = 'paging';

    /**
     * @var string|null
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $profilePictureUrl;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array|null
     */
    protected $paging;

    /**
     * @var bool
     */
    protected $success;

    protected function parseResponse(array $response): void
    {
        $this->id = $response[self::ID] ?? null;
        $this->name = $response[self::NAME] ?? null;
        $this->profilePictureUrl = $response[self::PROFILE_PICTURE_URL] ?? null;
        $this->success = $response[self::SUCCESS] ?? null;
        $this->paging = $response[self::PAGING] ?? null;

        $this->setData($response);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getProfilePictureUrl(): ?string
    {
        return $this->profilePictureUrl;
    }

    /**
     * @return \Involix\Messenger\Model\Data[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function isSuccess(): bool
    {
        return $this->success === true;
    }

    private function setData(array $response): void
    {
        if (isset($response[self::DATA]) && !empty($response[self::DATA])) {
            foreach ($response[self::DATA] as $data) {
                $this->data[] = Data::create($data);
            }
        }
    }
}
