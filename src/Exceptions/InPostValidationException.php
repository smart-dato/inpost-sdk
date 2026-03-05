<?php

namespace Smartdato\InPost\Exceptions;

use Saloon\Http\Response;

class InPostValidationException extends InPostApiException
{
    /** @var array<string, list<string>> */
    public array $errors;

    public static function fromResponse(Response $response): self
    {
        $body = $response->json();

        $instance = new self(
            response: $response,
            type: $body['type'] ?? null,
            title: $body['title'] ?? null,
            detail: $body['detail'] ?? null,
        );

        $instance->errors = $body['errors'] ?? [];

        return $instance;
    }
}
