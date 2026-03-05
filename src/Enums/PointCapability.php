<?php

namespace Smartdato\InPost\Enums;

enum PointCapability: string
{
    case PARCEL_SEND = 'parcel_send';
    case PARCEL_COLLECT = 'parcel_collect';
    case PARCEL_SEND_AND_COLLECT = 'parcel_send_collect';
}
