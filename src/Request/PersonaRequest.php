<?php

declare(strict_types=1);

namespace Involix\Messenger\Request;

use Involix\Messenger\Model\PersonaSettings;

class PersonaRequest extends AbstractRequest
{
    /**
     * @var \Involix\Messenger\Model\PersonaSettings|null
     */
    protected $personaSettings;

    /**
     * ProfileRequest constructor.
     */
    public function __construct(string $pageToken, PersonaSettings $personaSettings = null)
    {
        parent::__construct($pageToken);

        $this->personaSettings = $personaSettings;
    }

    protected function buildHeaders(): ?array
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        return $this->personaSettings instanceof PersonaSettings ? $headers : null;
    }

    /**
     * @return \Involix\Messenger\Model\PersonaSettings|mixed|null
     */
    protected function buildBody()
    {
        if ($this->personaSettings instanceof PersonaSettings) {
            return $this->personaSettings;
        }
    }
}
