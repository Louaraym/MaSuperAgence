<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 120; $i++) {
            $property = new Property();
            $property
                 ->setTitle($faker->words($nb = 3, $asText = true))
                 ->setSurface($faker->numberBetween(20,350))
                 ->setPrice($faker->numberBetween(100000,1000000))
                 ->setRooms($faker->numberBetween(2,10))
                 ->setBedrooms($faker->numberBetween(1,9))
                 ->setHeat($faker->numberBetween(0, count(Property::HEAT) - 1))
                 ->setFloor($faker->numberBetween(0,15))
                 ->setAddress($faker->address)
                 ->setCity($faker->city)
                 ->setPostalCode($faker->postcode)
                 ->setDescription($faker->sentences($nb = 5, $asText = true))
                 ->setSold(false)
            ;

            $manager->persist($property);
        }

        $manager->flush();
    }
}
