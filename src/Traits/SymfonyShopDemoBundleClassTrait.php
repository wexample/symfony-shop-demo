<?php

namespace Wexample\SymfonyShopDemo\Traits;

use Wexample\SymfonyShopDemo\WexampleSymfonyShopDemoBundle;
use Wexample\SymfonyHelpers\Traits\BundleClassTrait;

trait SymfonyShopDemoBundleClassTrait
{
    use BundleClassTrait;

    public static function getBundleClassName(): string
    {
        return WexampleSymfonyShopDemoBundle::class;
    }
}
