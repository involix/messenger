<?php

declare(strict_types=1);

namespace Involix\Messenger;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Involix\Messenger\Api\Broadcast;
use Involix\Messenger\Api\Code;
use Involix\Messenger\Api\Insights;
use Involix\Messenger\Api\Nlp;
use Involix\Messenger\Api\Persona;
use Involix\Messenger\Api\Profile;
use Involix\Messenger\Api\Send;
use Involix\Messenger\Api\Tag;
use Involix\Messenger\Api\Thread;
use Involix\Messenger\Api\User;
use Involix\Messenger\Api\Webhook;
use Psr\Http\Message\ServerRequestInterface;

class Messenger
{
    public const API_URL = 'https://graph.facebook.com/';
    public const API_VERSION = 'v5.0';

    /**
     * @var string
     */
    protected $appSecret;

    /**
     * @var string
     */
    protected $verifyToken;

    /**
     * @var string
     */
    protected $pageToken;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Messenger constructor.
     */
    public function __construct(
        string $appSecret,
        string $verifyToken,
        string $pageToken,
        string $apiVersion = self::API_VERSION,
        ?ClientInterface $client = null
    ) {
        $this->appSecret = $appSecret;
        $this->verifyToken = $verifyToken;
        $this->pageToken = $pageToken;

        if ($client === null) {
            $client = new Client([
                'base_uri' => self::API_URL . $apiVersion . '/',
            ]);
        }
        $this->client = $client;
    }

    public function send(): Send
    {
        return new Send($this->pageToken, $this->client);
    }

    public function webhook(?ServerRequestInterface $request = null): Webhook
    {
        return new Webhook($this->appSecret, $this->verifyToken, $this->pageToken, $this->client, $request);
    }

    public function user(): User
    {
        return new User($this->pageToken, $this->client);
    }

    public function profile(): Profile
    {
        return new Profile($this->pageToken, $this->client);
    }

    public function code(): Code
    {
        return new Code($this->pageToken, $this->client);
    }

    public function insights(): Insights
    {
        return new Insights($this->pageToken, $this->client);
    }

    public function tag(): Tag
    {
        return new Tag($this->pageToken, $this->client);
    }

    public function thread(): Thread
    {
        return new Thread($this->pageToken, $this->client);
    }

    public function nlp(): Nlp
    {
        return new Nlp($this->pageToken, $this->client);
    }

    public function broadcast(): Broadcast
    {
        return new Broadcast($this->pageToken, $this->client);
    }

    public function persona(): Persona
    {
        return new Persona($this->pageToken, $this->client);
    }
}
