<?php

namespace Wexample\SymfonyCartDemo\Controller\Pages;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Wexample\SymfonyCartDemo\Service\DemoCatalogueService;
use Wexample\SymfonyCartDemo\Traits\SymfonyCartDemoBundleClassTrait;
use Wexample\SymfonyHelpers\Helper\VariableHelper;
use Wexample\SymfonyLoader\Controller\AbstractPagesController;

/**
 * The cart of symfony-cart-ds tried on a catalogue of the demo's: what to
 * buy, and what to try — a purchase through, a date sold out, a payment
 * failed then taken up again, a cart left to expire.
 */
#[Route(path: '/cart-demo/', name: 'cart_demo_')]
final class CartDemoController extends AbstractPagesController
{
    use SymfonyCartDemoBundleClassTrait;

    final public const string ROUTE_INDEX = VariableHelper::INDEX;

    #[Route(path: '', name: self::ROUTE_INDEX)]
    public function index(DemoCatalogueService $catalogue): Response
    {
        $catalogue->ensure();

        return $this->renderPage(self::ROUTE_INDEX);
    }
}
