<?php

namespace App\DataFixtures;

use Faker;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Beer;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        // create 20 beers! Bam!
        for ($i = 0; $i < 20; $i++) {
            $beer = new Beer();
            $beer->setName('product '.$i);
           
            $manager->persist($beer);
        }

        $manager->flush();
    }
}
