<?php

declare(strict_types=1);

namespace Involix\Messenger\Api;

use Involix\Messenger\Model\PersonaSettings;
use Involix\Messenger\Request\PersonaRequest;
use Involix\Messenger\Response\PersonaResponse;

class Persona extends AbstractApi
{
    public function add(PersonaSettings $persona): PersonaResponse
    {
        $request = new PersonaRequest($this->pageToken, $persona);
        $response = $this->client->post('me/personas', $request->build());

        return new PersonaResponse($response);
    }

    public function get(string $personaId): PersonaResponse
    {
        $request = new PersonaRequest($this->pageToken);
        $response = $this->client->get($personaId, $request->build());

        return new PersonaResponse($response);
    }

    public function getAll(): PersonaResponse
    {
        $request = new PersonaRequest($this->pageToken);
        $response = $this->client->get('me/personas', $request->build());

        return new PersonaResponse($response);
    }

    public function delete(string $personaId): PersonaResponse
    {
        $request = new PersonaRequest($this->pageToken);
        $response = $this->client->delete($personaId, $request->build());

        return new PersonaResponse($response);
    }
}
