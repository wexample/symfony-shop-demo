<?php

namespace Wexample\SymfonyShopDemo\Traits;

use Wexample\SymfonyHelpers\Traits\BundleClassTrait;
use Wexample\SymfonyShopDemo\WexampleSymfonyShopDemoBundle;

trait SymfonyShopDemoBundleClassTrait
{
    use BundleClassTrait;

    public static function getBundleClassName(): string
    {
        return WexampleSymfonyShopDemoBundle::class;
    }
}
