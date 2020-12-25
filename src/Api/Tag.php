<?php

declare(strict_types=1);

namespace Involix\Messenger\Api;

use Involix\Messenger\Request\TagRequest;
use Involix\Messenger\Response\TagResponse;

class Tag extends AbstractApi
{
    public function get(): TagResponse
    {
        $request = new TagRequest($this->pageToken);
        $response = $this->client->get('page_message_tags', $request->build());

        return new TagResponse($response);
    }
}
