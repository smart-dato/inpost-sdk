<?php

namespace Smartdato\InPost\Exceptions;

use Saloon\Http\Response;

class InPostValidationException extends InPostApiException
{
    /**
     * @param  array<string, list<string>>  $errors
     */
    public function __construct(
        Response $response,
        ?string $type = null,
        ?string $title = null,
        ?string $detail = null,
        public readonly array $errors = [],
    ) {
        parent::__construct($response, $type, $title, $detail);
    }

    public static function fromResponse(Response $response): self
    {
        $body = $response->json();

        return new self(
            response: $response,
            type: $body['type'] ?? null,
            title: $body['title'] ?? null,
            detail: $body['detail'] ?? null,
            errors: $body['errors'] ?? [],
        );
    }
}
