<?php

namespace Smartdato\InPost\Connectors;

class ShippingConnector extends InPostConnector
{
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl ?? (string) config('inpost-sdk.base_urls.shipping');
    }
}
