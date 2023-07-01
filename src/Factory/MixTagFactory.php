<?php

namespace App\Factory;

use App\Entity\MixTag;
use App\Repository\MixTagRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<MixTag>
 *
 * @method        MixTag|Proxy create(array|callable $attributes = [])
 * @method static MixTag|Proxy createOne(array $attributes = [])
 * @method static MixTag|Proxy find(object|array|mixed $criteria)
 * @method static MixTag|Proxy findOrCreate(array $attributes)
 * @method static MixTag|Proxy first(string $sortedField = 'id')
 * @method static MixTag|Proxy last(string $sortedField = 'id')
 * @method static MixTag|Proxy random(array $attributes = [])
 * @method static MixTag|Proxy randomOrCreate(array $attributes = [])
 * @method static MixTagRepository|RepositoryProxy repository()
 * @method static MixTag[]|Proxy[] all()
 * @method static MixTag[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static MixTag[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static MixTag[]|Proxy[] findBy(array $attributes)
 * @method static MixTag[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static MixTag[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class MixTagFactory extends ModelFactory
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

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'mix' => VinylMixFactory::new(),
            'tag' => TagFactory::new(),
            'taggedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(MixTag $mixTag): void {})
        ;
    }

    protected static function getClass(): string
    {
        return MixTag::class;
    }
}
