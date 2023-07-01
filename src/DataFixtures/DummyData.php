<?php

namespace App\DataFixtures;

use App\Factory\TableTwoFactory;
use App\Factory\VinylMixFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DummyData extends Fixture
{
    public function __construct(private int $No_of_Songs = 0,private int $No_of_Comment = 0){

    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        VinylMixFactory::createMany($this->No_of_Songs);
        TableTwoFactory::createMany($this->No_of_Comment);

        $manager->flush();
    }
}
