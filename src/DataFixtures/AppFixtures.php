<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
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
        $this->makeUsers($manager);

    }


    private function makeUsers(ObjectManager $manager)
    {
        $users_params = [

            [
                'login' => 'first_user',
                'password' => '111222555',
                'email' => 'firstuser@somemail.com',
                'first_name' => 'John',
                'last_name' => 'Malcovich',

            ],

            [

                'login' => 'second_user',
                'password' => '555222111',
                'email' => 'seconduser@somemail.com',
                'first_name' => 'Marcus',
                'last_name' => 'Miller',
            ],

        ];

        foreach ($users_params as $user_params) {
            $user = new User();

            $login = $user_params['login'];
            $email = $user_params['email'];
            $first_name = $user_params['first_name'];
            $last_name = $user_params['last_name'];

            $hashed_password = $this->passwordHasher->hashPassword($user, $user_params['password']);

            $user->setLogin($login)
                    ->setEmail($email)
                    ->setPassword($hashed_password)
                    ->setFirstName($first_name)
                    ->setLastName($last_name);

            $manager->persist($user);
        
        }


        $manager->flush();
    }


}
