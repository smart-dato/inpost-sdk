<?php

use Smartdato\InPost\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function fixtureJson(string $name): array
{
    $path = __DIR__.'/Fixtures/'.$name.'.json';

    return json_decode(file_get_contents($path), true);
}
