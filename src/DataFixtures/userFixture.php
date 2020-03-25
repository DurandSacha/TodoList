<?php
/**
 * Created by PhpStorm.
 * Client: sacha
 * Date: 24/11/2019
 * Time: 01:14
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\baseFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator;

class userFixture extends baseFixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    private static $name = [
        'Jean',
        'Yohann',
        'Gerard',
        'Marie',
        'Francois',
        'George',
        'Louis',
        'Marion',
        'Constance',
        'Julie',
        'Emilie',
        'Léa',
        'Alexandre',
    ];

    private static $email = [
        'jean01@gmail.com',
        'jean02@gmail.com',
        'jean03@gmail.com',
        'jean04@gmail.com',
        'jean05@gmail.com',
        'jean06@gmail.com',
        'jean07@gmail.com',
        'jean08@gmail.com',
        'jean09@gmail.com',
        'jean10@gmail.com',
        'jean11@gmail.com',
        'jean12@gmail.com',
        'jean13@gmail.com',
        'jean14@gmail.com',
    ];

    public function loadData(ObjectManager $manager)
    {
        //ADMIN USER
        $user = new User();
        $user->setUsername('sacha');
        $user->setPassword($this->passwordEncoder->encodePassword($user, '000000'));
        $user->setEmail('sacha6623@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setUsername($this->faker->randomElement(self::$name));
            $user->setPassword($this->passwordEncoder->encodePassword($user, '000000'));
            $user->setEmail($this->faker->randomElement(self::$email));
            $user->setRoles(['ROLE_USER']);

            $manager->persist($user);
        }
        ;
        $manager->flush();
    }

}