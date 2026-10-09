<?php

namespace Wexample\SymfonyCartDemo\Service;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Wexample\SymfonyCart\Entity\Product;
use Wexample\SymfonyCart\Entity\ProductAvailability;
use Wexample\SymfonyCart\Entity\ProductVariation;
use Wexample\SymfonyCart\Entity\Schedule;
use Wexample\SymfonyCart\Enum\VariationPriceAction;
use Wexample\SymfonyCart\Repository\ProductRepository;

/**
 * The demo's catalogue, written once on the first visit: a thing shipped, a
 * workshop with roles and dates of a few seats each — the last date of one
 * seat only, to see it sold out —, and a donation of the amount chosen.
 * Prices in euro cents, VAT in basis points.
 */
class DemoCatalogueService
{
    final public const string TSHIRT = 'design-system-t-shirt';

    final public const string WORKSHOP = 'design-system-workshop';

    final public const string DONATION = 'donation';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProductRepository $products,
    ) {
    }

    public function ensure(): void
    {
        if ($this->products->findOneBySlug(self::TSHIRT)) {
            return;
        }

        $this->entityManager->persist(
            $this->product(self::TSHIRT, 'Design system T-shirt', 2000, 'An organic cotton T-shirt with the design system printed on its back. Shipped.')
                ->setHasShipping(true)
                ->setMaxPerCart(5)
        );

        $workshop = $this->product(self::WORKSHOP, 'Design system workshop', 15000, 'A day building screens with the design system. Present a project of yours for the price of a lunch, or come and listen.', 'ticket');
        $presenter = (new ProductVariation())->setName('Role')->setValue('Presenter')->setPriceAction(VariationPriceAction::PriceFinal, 2000);
        $listener = (new ProductVariation())->setName('Role')->setValue('Listener');
        $workshop->addVariation($presenter)->addVariation($listener);

        foreach ([['+2 weeks', 3], ['+6 weeks', 3], ['+10 weeks', 1]] as [$when, $seats]) {
            $date = new DateTimeImmutable($when.' 09:00');
            $schedule = (new Schedule())->setDateStart($date)->setDateEnd($date->modify('+8 hours'))->setLabel($date->format('l j F Y'));
            $this->entityManager->persist($schedule);
            $workshop->addAvailability((new ProductAvailability())->setSchedule($schedule)->setQuantity($seats));
        }

        $this->entityManager->persist($workshop);
        $this->entityManager->persist(
            $this->product(self::DONATION, 'Donation', 0, 'Support the design system with the amount you choose.', 'donation')
                ->setFreeAmount(true)
                ->setPriceVat(0)
        );

        $this->entityManager->flush();
    }

    private function product(
        string $slug,
        string $title,
        int $priceRaw,
        string $description,
        string $type = 'default',
    ): Product {
        return (new Product())
            ->setSlug($slug)
            ->setTitle($title)
            ->setDescription($description)
            ->setType($type)
            ->setPriceRaw($priceRaw)
            ->setPriceVat(2000);
    }
}
