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

        $names = [
            'beer super',
            'beer cool',
            'beer strange',
            'beer very bad trip',
            'beer super strange',
            'beer very sweet',
            'beer hyper cool',
            'beer without alcool',
            'beer simple',
            'beer very simple',
        ];

        for ($i = 0; $i < 20; $i++) {
            $beer = new Beer();
            $beer->setName($names[random_int(0, count($names) - 1)]);
            // si vous n'avez pas la version de PHP 8 ceci marchera 
            $beer->setDescription($faker->paragraph($nbSentences = 3, $variableNbSentences = true));

            $manager->persist($beer);
        }

        $manager->flush();
    }
}
