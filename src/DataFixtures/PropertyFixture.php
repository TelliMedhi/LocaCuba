<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Property;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        //Créer 100 property fakée
        for ($i = 1; $i < 100; $i++) {
            $property = new Property();
            $property->setTitle($faker->words(5, true))
                ->setDescription($faker->sentences(4, true))
                ->setSurface($faker->numberBetween(20, 400))
                ->setRooms($faker->numberBetween(2, 10))
                ->setBedrooms($faker->numberBetween(1, 6))
                ->setFloor($faker->numberBetween(0, 26))
                ->setPrice($faker->numberBetween(50, 800))
                ->setHeat($faker->numberBetween(0, count(Property::HEAT) -1))
                      ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPostaleCode($faker->postcode)
                ->setSold(false)
                 ->setCreatedAt($faker->dateTimeBetween('-6 months'));

            $manager->persist($property);
        }
        $manager->flush();
    }
}