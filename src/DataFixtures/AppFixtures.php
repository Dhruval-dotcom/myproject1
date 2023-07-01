<?php

namespace App\DataFixtures;

use App\Entity\TableTwo;
use App\Entity\Tag;
use App\Entity\VinylMix;
use App\Factory\MixTagFactory;
use App\Factory\TableTwoFactory;
use App\Factory\TagFactory;
use App\Factory\VinylMixFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // $mix = new VinylMix();
        // $ans = new TableTwo();

        // $manager->persist($mix);
        // $manager->persist($ans);


        $tags = TagFactory::createMany(100);
        MixTagFactory::createMany(20);


        $mix = VinylMixFactory::createMany(25, function() {
            return [
                'mixTags' => MixTagFactory::new(function() {
                    return [
                        'tag' => TagFactory::random(),
                    ];
                })->many(1, 5)
            ];
        });
        $manager->flush();

        TableTwoFactory::createMany(100, function() use ($mix){
            return [
                'question' => $mix[array_rand($mix)]
            ];
        });
        TableTwoFactory::new(function() use ($mix){
            return [
                'question' => $mix[array_rand($mix)]
            ];
        })->needsApproval()->many(20)->create();

        $mix = VinylMixFactory::createOne()->object();
  
        $manager->flush();
    }
}
