<?php
/**
 * Created by PhpStorm.
 * Client: sacha
 * Date: 24/11/2019
 * Time: 01:14
 */

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\baseFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator;

class taskFixture extends baseFixture
{

    private static $title = [
        'Appeler les prospect',
        'Faire Les comptes',
        'Paiement des employés',
        'Envoi de facture',
        'Relevé de compte',
        'Lancement appel offre',
        'marketing web',
        'faire la charte graphique',
        'Redessiner le logo',
        'distribuer des prospectus',
        'Creer des cartes de visites',
    ];

    private static $contentTask = [
        'passer un appel',
        'Noter au propre',
        'Verifier le travail',
        'Definir le travail',
        'Appeler le freelancer',
    ];

    public function loadData(ObjectManager $manager)
    {
        for ($i = 1; $i <= 2; $i++) {
            $task = new Task();
            $task->setTitle($this->faker->randomElement(self::$title));
            $task->setContent($this->faker->randomElement(self::$contentTask));
            $task->toggle(true);
            //$task->setCreatedAt(new \DateTime($this->faker->randomElement(self::$date)));
            //$task->setUser(new \DateTime($this->faker->randomElement(self::$date)));

            $manager->persist($task);
        }
        ;
        $manager->flush();
    }


}