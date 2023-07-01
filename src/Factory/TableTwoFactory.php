<?php

namespace App\Factory;

use App\Entity\TableTwo;
use App\Repository\TableTwoRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<TableTwo>
 *
 * @method        TableTwo|Proxy create(array|callable $attributes = [])
 * @method static TableTwo|Proxy createOne(array $attributes = [])
 * @method static TableTwo|Proxy find(object|array|mixed $criteria)
 * @method static TableTwo|Proxy findOrCreate(array $attributes)
 * @method static TableTwo|Proxy first(string $sortedField = 'id')
 * @method static TableTwo|Proxy last(string $sortedField = 'id')
 * @method static TableTwo|Proxy random(array $attributes = [])
 * @method static TableTwo|Proxy randomOrCreate(array $attributes = [])
 * @method static TableTwoRepository|RepositoryProxy repository()
 * @method static TableTwo[]|Proxy[] all()
 * @method static TableTwo[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static TableTwo[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static TableTwo[]|Proxy[] findBy(array $attributes)
 * @method static TableTwo[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TableTwo[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class TableTwoFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function needsApproval(): self
    {
        return $this->addState(['status' => TableTwo::STATUS_NEEDS_APPROVAL]);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'Description' => self::faker()->text(),
            'question' => VinylMixFactory::random(),
            'status' => TableTwo::STATUS_APPROVED,
            'createdAt' => self::faker()->dateTimeBetween('-1 year'),
            'votes' => self::faker()->numberBetween(-20, 50)
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(TableTwo $tableTwo): void {})
        ;
    }

    protected static function getClass(): string
    {
        return TableTwo::class;
    }
}
