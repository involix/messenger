<?php

declare(strict_types=1);

namespace Involix\Messenger\Event;

use Involix\Messenger\Model\Callback\AppRoles;

class AppRolesEvent extends AbstractEvent
{
    public const NAME = 'app_roles';

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var \Involix\Messenger\Model\Callback\AppRoles
     */
    protected $appRoles;

    /**
     * ReadEvent constructor.
     */
    public function __construct(string $senderId, string $recipientId, int $timestamp, AppRoles $appRoles)
    {
        parent::__construct($senderId, $recipientId);

        $this->timestamp = $timestamp;
        $this->appRoles = $appRoles;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getAppRoles(): AppRoles
    {
        return $this->appRoles;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @return \Involix\Messenger\Event\AppRolesEvent
     */
    public static function create(array $payload): self
    {
        $senderId = isset($payload['sender']) ? $payload['sender']['id'] : '';
        $recipientId = $payload['recipient']['id'];
        $timestamp = $payload['timestamp'];
        $appRoles = AppRoles::create($payload['app_roles']);

        return new static($senderId, $recipientId, $timestamp, $appRoles);
    }
}
