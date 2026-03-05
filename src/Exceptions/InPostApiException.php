<?php

namespace Smartdato\InPost\Exceptions;

use Exception;
use Saloon\Http\Response;

class InPostApiException extends Exception
{
    public function __construct(
        public readonly Response $response,
        public readonly ?string $type = null,
        public readonly ?string $title = null,
        public readonly ?string $detail = null,
    ) {
        $message = $title ?? 'InPost API error';

        if ($detail) {
            $message .= ': '.$detail;
        }

        parent::__construct($message, $response->status());
    }

    public static function fromResponse(Response $response): self
    {
        $body = $response->json();

        return new self(
            response: $response,
            type: $body['type'] ?? null,
            title: $body['title'] ?? null,
            detail: $body['detail'] ?? null,
        );
    }
}
