<?php

namespace Smartdato\InPost\Connectors;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AcceptsJson;
use Smartdato\InPost\Auth\InPostAuthenticator;
use Smartdato\InPost\Exceptions\InPostApiException;
use Smartdato\InPost\Exceptions\InPostNotFoundException;
use Smartdato\InPost\Exceptions\InPostValidationException;

abstract class InPostConnector extends Connector
{
    use AcceptsJson;

    public function __construct(
        protected InPostAuthenticator $inPostAuthenticator,
        protected ?string $baseUrl = null,
    ) {}

    protected function defaultAuth(): ?Authenticator
    {
        return $this->inPostAuthenticator;
    }

    public function getRequestException(Response $response, ?\Throwable $senderException): ?\Throwable
    {
        return match (true) {
            $response->status() === 400 => InPostValidationException::fromResponse($response),
            $response->status() === 404 => InPostNotFoundException::fromResponse($response),
            $response->clientError(), $response->serverError() => InPostApiException::fromResponse($response),
            default => null,
        };
    }
}
