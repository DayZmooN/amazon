<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            ['email' => 'user1@example.com', 'password' => 'password1'],
            ['email' => 'user2@example.com', 'password' => 'password2'],
            ['email' => 'user3@example.com', 'password' => 'password3'],
            ['email' => 'user4@example.com', 'password' => 'password4'],
            ['email' => 'user5@example.com', 'password' => 'password5'],
        ];

        // foreach ($users as $userData) {
        //     $user = new User();
        //     $user->setEmail($userData['email']);
        //     $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
        //     $user->setPassword($hashedPassword);

        //     $manager->persist($user);
        // }

        $manager->flush();
    }
}
