<?php

namespace Wexample\SymfonyCartDemo\Traits;

use Wexample\SymfonyCartDemo\WexampleSymfonyCartDemoBundle;
use Wexample\SymfonyHelpers\Traits\BundleClassTrait;

trait SymfonyCartDemoBundleClassTrait
{
    use BundleClassTrait;

    public static function getBundleClassName(): string
    {
        return WexampleSymfonyCartDemoBundle::class;
    }
}
