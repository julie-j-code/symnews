<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\News;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture

{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $generator = Faker\Factory::create("fr_FR");

        for ($i = 0; $i < 20; $i++) {
            $user = new User;
            $password = $this->encoder->encodePassword($user, 'password');
            $user
                ->setFirstname($generator->firstName)
                ->setLastname($generator->lastName)
                ->setEmail($generator->email)
                ->setPassword($password);

            $manager->persist($user);

            for ($j = 0; $j < rand(10, 50); $j++) {
                $news = new News();
                $news
                    ->setTitle($generator->sentence)
                    ->setContent($generator->text())
                    ->setCreatedAt($generator->dateTimeBetween('-1 year', 'now'))
                    ->setUser($user)
                    ->setStatus($generator->randomElement(['Draft', 'Published', 'Deleted']));

                $manager->persist($news);
            }
        }

        $manager->flush();
    }
}
