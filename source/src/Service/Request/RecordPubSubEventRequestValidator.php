<?php

declare(strict_types=1);

namespace AllMyHomes\CloudFunction\Service\Request;

use Psr\Http\Message\ServerRequestInterface;

class RecordPubSubEventRequestValidator implements RequestValidator
{
    public function getValidationErrors(ServerRequestInterface $request): array
    {
        $validationErrors = [];

        if ('POST' !== $request->getMethod()) {
            $validationErrors[] = sprintf('Method %s not allowed, POST only!', $request->getMethod());
        }

        //TODO: check array_keys exist: message, subscription

        return $validationErrors;
    }
}
