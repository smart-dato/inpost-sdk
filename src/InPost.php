<?php

namespace Smartdato\InPost;

use Smartdato\InPost\Auth\InPostAuthenticator;
use Smartdato\InPost\Connectors\InPostConnector;
use Smartdato\InPost\Resources\PickupsResource;
use Smartdato\InPost\Resources\PointsResource;
use Smartdato\InPost\Resources\ReturnsResource;
use Smartdato\InPost\Resources\ShippingResource;
use Smartdato\InPost\Resources\TrackingResource;

class InPost
{
    public const SCOPE_MAIN = 'api:shipments:read api:shipments:write api:points:read api:tracking:read api:returns:read api:returns:write';

    public const SCOPE_PICKUPS = 'api:one-time-pickups:read api:one-time-pickups:write';

    public const DEFAULT_TOKEN_URL = 'https://api.inpost-group.com/oauth2/token';

    public const DEFAULT_PICKUPS_TOKEN_URL = 'https://account.inpost-group.com/oauth2/token';

    private ?ShippingResource $shippingResource = null;

    private ?PointsResource $pointsResource = null;

    private ?TrackingResource $trackingResource = null;

    private ?ReturnsResource $returnsResource = null;

    private ?PickupsResource $pickupsResource = null;

    public function __construct(
        protected InPostConnector $shippingConnector,
        protected InPostConnector $pointsConnector,
        protected InPostConnector $trackingConnector,
        protected InPostConnector $returnsConnector,
        protected InPostConnector $pickupsConnector,
        protected string $organizationId,
    ) {}

    /**
     * Build an instance manually without the service container.
     *
     * @param  array{
     *     client_id: string,
     *     client_secret: string,
     *     organization_id: string,
     *     token_url?: string,
     *     pickups_token_url?: string,
     *     shipping_url?: string,
     *     points_url?: string,
     *     tracking_url?: string,
     *     returns_url?: string,
     *     pickups_url?: string,
     * }  $config
     */
    public static function make(array $config): self
    {
        $tokenUrl = $config['token_url'] ?? self::DEFAULT_TOKEN_URL;
        $pickupsTokenUrl = $config['pickups_token_url'] ?? self::DEFAULT_PICKUPS_TOKEN_URL;

        $mainAuth = new InPostAuthenticator(
            clientId: $config['client_id'],
            clientSecret: $config['client_secret'],
            tokenUrl: $tokenUrl,
            scope: self::SCOPE_MAIN,
        );

        $pickupsAuth = new InPostAuthenticator(
            clientId: $config['client_id'],
            clientSecret: $config['client_secret'],
            tokenUrl: $pickupsTokenUrl,
            scope: self::SCOPE_PICKUPS,
        );

        return new self(
            shippingConnector: new InPostConnector($mainAuth, $config['shipping_url'] ?? null, 'shipping'),
            pointsConnector: new InPostConnector($mainAuth, $config['points_url'] ?? null, 'points'),
            trackingConnector: new InPostConnector($mainAuth, $config['tracking_url'] ?? null, 'tracking'),
            returnsConnector: new InPostConnector($mainAuth, $config['returns_url'] ?? null, 'returns'),
            pickupsConnector: new InPostConnector($pickupsAuth, $config['pickups_url'] ?? null, 'pickups'),
            organizationId: $config['organization_id'],
        );
    }

    public function shipping(): ShippingResource
    {
        return $this->shippingResource ??= new ShippingResource($this->shippingConnector, $this->organizationId);
    }

    public function points(): PointsResource
    {
        return $this->pointsResource ??= new PointsResource($this->pointsConnector);
    }

    public function tracking(): TrackingResource
    {
        return $this->trackingResource ??= new TrackingResource($this->trackingConnector);
    }

    public function returns(): ReturnsResource
    {
        return $this->returnsResource ??= new ReturnsResource($this->returnsConnector, $this->organizationId);
    }

    public function pickups(): PickupsResource
    {
        return $this->pickupsResource ??= new PickupsResource($this->pickupsConnector, $this->organizationId);
    }
}
