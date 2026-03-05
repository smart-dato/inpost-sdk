<?php

namespace Smartdato\InPost\Connectors;

class PickupsConnector extends InPostConnector
{
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl ?? (string) config('inpost-sdk.base_urls.pickups');
    }
}
