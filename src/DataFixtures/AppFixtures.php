<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Statut;
use App\Entity\Comment;
use App\Entity\Project;
use App\DataFixtures\Provider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
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

        // RAZ des ID de toutes les tables
        $manager->getConnection()->exec('ALTER TABLE collaboration AUTO_INCREMENT = 1');
        $manager->getConnection()->exec('ALTER TABLE comment AUTO_INCREMENT = 1');
        $manager->getConnection()->exec('ALTER TABLE follow AUTO_INCREMENT = 1');
        $manager->getConnection()->exec('ALTER TABLE project AUTO_INCREMENT = 1');
        $manager->getConnection()->exec('ALTER TABLE request AUTO_INCREMENT = 1');
        $manager->getConnection()->exec('ALTER TABLE role AUTO_INCREMENT = 1');
        $manager->getConnection()->exec('ALTER TABLE skill AUTO_INCREMENT = 1');
        $manager->getConnection()->exec('ALTER TABLE statut AUTO_INCREMENT = 1');
        $manager->getConnection()->exec('ALTER TABLE tag AUTO_INCREMENT = 1');
        $manager->getConnection()->exec('ALTER TABLE techno AUTO_INCREMENT = 1');
        $manager->getConnection()->exec('ALTER TABLE user AUTO_INCREMENT = 1');

        $generator = Factory::create('fr_FR');

        // Ajout du provider perso
        $generator->addProvider(new Provider($generator));

        // REMPLIT LES TABLES SIMPLES

        // table "Role"
        $utilisateur = new Role();
        $utilisateur->setName('Utilisateur');
        $manager->persist($utilisateur);   
        $Moderateur = new Role();
        $Moderateur->setName('Modérateur');
        $manager->persist($Moderateur);        
        $administrateur = new Role();
        $administrateur->setName('Administrateur');
        $manager->persist($administrateur);

        // utilisateur "Administrateur" du site
        $admin = new User();
        $admin->setFirstName('Julien')
            ->setLastname('Lescieux')
            ->setUsername('julien.lescieux')
            ->setPassword('julien.lescieux')
            ->setMail('julien.lescieux@outlook.com')
            ->setJobTitle("Développeur web")
            ->setScore(5)
            ->setCity('Moulle')
            ->setPhoto('https://avatars0.githubusercontent.com/u/49444363?s=460&u=2a512098d4488f1b1f8879185a67220f76549eea&v=4')
            ->setDescription("Bonjour, je suis le créateur et l'administrateur de ce site !")
            ->setUrlFacebook('https://fr-fr.facebook.com/julien.lescieux')
            ->setUrlTwitter('https://twitter.com/julien.lescieux')
            ->setUrlLinkedin('https://fr.linkedin.com/in/jlescieux')
            ->setUrlGithub('https://github.com/Jlescieux')
            ->setRole($administrateur);
        $manager->persist($admin);    
        
        // table "User"
        $users = [];
        for ($j = 0; $j < 20; $j++) {
            $users[$j] = new User();
            $users[$j]->setFirstName($generator->firstName())
                ->setLastname($generator->lastName())
                ->setUsername($users[$j]->getFirstname() . '-' . $users[$j]->getLastname())
                ->setPassword($users[$j]->getUsername())
                ->setMail($users[$j]->getUsername() . '@gmail.com')
                ->setJobTitle($generator->unique(true)->jobTitle())
                ->setScore($generator->numberBetween($min = 1, $max = 5))
                ->setCity($generator->city())
                ->setPhoto($generator->imageUrl($width = 460, $height = 460, 'people'))
                ->setDescription($generator->realText($maxNbChars = 200, $indexSize = 2))
                ->setUrlFacebook('https://fr-fr.facebook.com/' . $users[$j]->getUsername())
                ->setUrlTwitter('https://twitter.com/' . $users[$j]->getUsername())
                ->setUrlLinkedin('https://fr.linkedin.com/in/' . $users[$j]->getUsername())
                ->setUrlGithub('https://github.com/' . $users[$j]->getUsername())
                ->setRole($utilisateur);
            $manager->persist($users[$j]);
        }

        // table "Statut"
        $status = [];
        for ($i = 0; $i < 3; $i++) {
            $status[$i] = new Statut();
            $status[$i]->setName($generator->unique()->statutName());
            $manager->persist($status[$i]);
        }

        // table "Project"    
        $projects = [];
        for ($j = 0; $j < 10; $j++) {
            $projects[$j] = new Project();
            $projects[$j]->setTitle($generator->unique(true)->projectTitle())
                ->setDescription($generator->realText($maxNbChars = 100, $indexSize = 2))
                ->setContent($generator->realText($maxNbChars = 1000, $indexSize = 2))
                ->setImage($generator->imageUrl($width = 600, $height = 600, 'business'))
                ->setNbCollaborators($generator->numberBetween($min = 1, $max = 10))
                ->setCreatedAt($generator->datetime('now', 'Europe/Paris'))
                ->setUrlFacebook('https://fr-fr.facebook.com/' . $projects[$j]->getTitle())
                ->setUrlGithub('https://github.com/' . $generator->userName() . '/' . $projects[$j]->getTitle())
                ->setUrlTwitter('https://twitter.com/' . $projects[$j]->getTitle())
                ->setUrlTipeee('https://fr.tipeee.com/' . $projects[$j]->getTitle());
            // on récupère un statut et un créateur au hasard
            $randomStatut = $status[rand(0, (count($status) - 1))];
            $randomUser = $users[rand(0, (count($users) - 1))];
            // puis on les ajoutes au projet
            $projects[$j]->setStatut($randomStatut);
            $projects[$j]->setOwner($randomUser);
            $manager->persist($projects[$j]);
        }

        // // table "Comment"
        // $comments = [];
        // for ($k = 0; $k < 30; $k++) {
        //     $comments[$k] = new Comment();
        //     $comments[$k]->setContent($generator->realText($maxNbChars = 100, $indexSize = 2))
        //         ->setCreatedAt($generator->datetime('now', 'Europe/Paris'))
        //         ->setCreatedAt($generator->datetime('now', 'Europe/Paris'));
        //     $manager->persist($comments[$k]);
        // }

        $manager->flush();
    }
}
