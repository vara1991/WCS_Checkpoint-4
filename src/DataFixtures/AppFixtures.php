<?php

namespace App\DataFixtures;

use App\Entity\Performer;
use App\Entity\Show;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $user = new User();
        $user->setEmail('varaponegaire@gmail.com');
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($this->encoder->encodePassword($user,'123456'));
        $manager->persist($user);

        $performerArray = [];
        for ($i=0; $i<6; $i++) {
            $performer = new Performer();
            $performer->setFirstname($faker->firstName);
            $performer->setLastname($faker->lastName);
            $performer->setUpdatedAt(new \DateTime('now'));
            $performer->setBiography($faker->text);
            $manager->persist($performer);
            $performerArray = $performer;
        }

        $showArray = [];
        for ($i=0; $i<6; $i++) {
            $show = new Show();
            $show->setName($faker->word);
            $show->setSummary($faker->text);
            $show->setUpdatedAt(new \DateTime('now'));
            $manager->persist($show);
            $showArray = $show;
        }

        $manager->flush();
    }
}
