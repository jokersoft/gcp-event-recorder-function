<?php

declare(strict_types=1);

namespace AllMyHomes\CloudFunction\Service\Request;

use Psr\Http\Message\ServerRequestInterface;

interface RequestValidator
{
    public function getValidationErrors(ServerRequestInterface $request): array;
}
