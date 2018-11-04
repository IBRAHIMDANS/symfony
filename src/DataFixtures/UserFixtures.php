<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use  App\Entity\User;
use  Faker\Factory;




class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $faker = Factory::create();
        for ($i=1; $i < 10; $i++) {
          $user = new User();
          $user ->setLastName($faker -> lastName)
                ->setFirstname($faker -> firstname)
                ->setAge($faker -> year)
                ->setForget($faker -> address)
                ->setCreateAt(new \DateTime());

          $manager -> persist($user);
        }
        $manager->flush();
    }
}
