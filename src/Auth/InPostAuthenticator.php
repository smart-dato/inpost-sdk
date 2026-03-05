<?php

namespace Smartdato\InPost\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;

class InPostAuthenticator implements Authenticator
{
    public function __construct(
        protected string $clientId,
        protected string $clientSecret,
        protected string $tokenUrl,
        protected string $scope,
    ) {}

    public function set(PendingRequest $pendingRequest): void
    {
        $pendingRequest->headers()->add('Authorization', 'Bearer '.$this->getToken());
    }

    protected function getToken(): string
    {
        $cacheKey = 'inpost_oauth_token_'.md5($this->clientId.'|'.$this->tokenUrl.'|'.$this->scope);

        return Cache::remember($cacheKey, $this->getTokenTtl(), function () {
            return $this->fetchToken();
        });
    }

    protected function fetchToken(): string
    {
        $response = Http::asForm()->post($this->tokenUrl, [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'scope' => $this->scope,
        ]);

        $response->throw();

        return $response->json('access_token');
    }

    protected function getTokenTtl(): int
    {
        return 3300; // 55 minutes (token typically valid for 60 min)
    }
}
