<?php

namespace Wexample\SymfonyShopDemo\Controller\Pages;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Wexample\SymfonyHelpers\Helper\VariableHelper;
use Wexample\SymfonyLoader\Controller\AbstractPagesController;
use Wexample\SymfonyShopDemo\Service\DemoCatalogueService;
use Wexample\SymfonyShopDemo\Traits\SymfonyShopDemoBundleClassTrait;

/**
 * The cart of symfony-shop-ds tried on a catalogue of the demo's: what to
 * buy, and what to try — a purchase through, a date sold out, a payment
 * failed then taken up again, a cart left to expire.
 */
#[Route(path: '/shop-demo/', name: 'shop_demo_')]
final class ShopDemoController extends AbstractPagesController
{
    use SymfonyShopDemoBundleClassTrait;

    final public const string ROUTE_INDEX = VariableHelper::INDEX;

    #[Route(path: '', name: self::ROUTE_INDEX)]
    public function index(DemoCatalogueService $catalogue): Response
    {
        $catalogue->ensure();

        return $this->renderPage(self::ROUTE_INDEX);
    }
}
