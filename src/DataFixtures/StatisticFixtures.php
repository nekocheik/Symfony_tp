<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


use App\Entity\Beer;
use App\Entity\Client;
use App\Entity\Statistic;
use App\Entity\Category;

class StatisticFixtures extends Fixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
      return 2; // number in which order to load fixtures
    }

  public function load(ObjectManager $manager)
  {
    $maxClient = rand(45,200);
    for ($i = 0; $i < $maxClient; $i++) {
        
      $faker = \Faker\Factory::create();
      $client = new Client();

      $client->setName(rand(0,1) == 1 ? $faker->firstNameMale : $faker->firstNameFemale)
             ->setEmail($faker->safeEmail)
             ->setNumberBeer(rand(5, 8))
             ->setWeight(rand(50, 180) . "." . rand(0,9));

      $manager->flush();
      $manager->persist($client);
    };
    
    $repoBeers = $manager->getRepository(Beer::class);
    $repoClients = $manager->getRepository(Client::class);
    $clients = $repoClients->findAll();


    foreach ($clients as $client) {
      $beers = $repoBeers->findAll();
      $catRepo = $manager->getRepository(Category::class);

      $statisticNumber = rand(0, count($beers));
      shuffle($beers);

      for ($i = 0; $i < $statisticNumber; $i++){
        $statistic = New Statistic();
        $beer = $beers[$i];

        $categories = $beer->getCategories()->getValues();

        $statistic->setCategoryId($categories[0]->getId())
                  ->setClientId($client)
                  ->setScore(rand(2,14))
                  ->setBeerId($beer);

        $manager->flush();
        $manager->persist($statistic);
      };

    }



  }
}
