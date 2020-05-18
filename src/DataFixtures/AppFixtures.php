<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tag;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Skill;
use App\Entity\Follow;
use App\Entity\Statut;
use App\Entity\Techno;
use App\Entity\Comment;
use App\Entity\Project;
use App\Helpers\Sluggifier;
use App\Entity\Collaboration;
use App\DataFixtures\Provider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    // Permet d'encoder les mots de passe en BDD
    private $encoder;
    private $sluggifier;

    public function __construct(UserPasswordEncoderInterface $encoder, Sluggifier $sluggifier)
    {
        $this->encoder = $encoder;
        $this->sluggifier = $sluggifier;
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
            ->setPassword($this->encoder->encodePassword($admin, $admin->getUsername()))
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
        for ($i = 0; $i < 20; $i++) {
            $users[$i] = new User();
            $users[$i]->setFirstName($generator->firstName())
                ->setLastname($generator->lastName())
                ->setUsername($this->sluggifier->sluggify($users[$i]->getFirstname()) . '-' . $this->sluggifier->sluggify($users[$i]->getLastname()))
                ->setMail($users[$i]->getUsername() . '@gmail.com')
                ->setPassword($this->encoder->encodePassword($users[$i], $users[$i]->getUsername()))
                ->setJobTitle($generator->unique(true)->jobTitle())
                ->setScore($generator->numberBetween($min = 1, $max = 5))
                ->setCity($generator->city())
                ->setPhoto($generator->imageUrl($width = 460, $height = 460, 'people'))
                ->setDescription($generator->realText($maxNbChars = 200, $indexSize = 2))
                ->setUrlFacebook('https://fr-fr.facebook.com/' . $this->sluggifier->sluggify($users[$i]->getUsername(), '.'))
                ->setUrlTwitter('https://twitter.com/' . $this->sluggifier->sluggify($users[$i]->getUsername(), '_'))
                ->setUrlLinkedin('https://fr.linkedin.com/in/' . $this->sluggifier->sluggify($users[$i]->getUsername()))
                ->setUrlGithub('https://github.com/' . $this->sluggifier->sluggify($users[$i]->getUsername()))
                ->setRole($utilisateur);
            $manager->persist($users[$i]);
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
        for ($i = 0; $i < 10; $i++) {
            $projects[$i] = new Project();
            $projects[$i]->setTitle($generator->unique()->projectTitle())
                ->setDescription($generator->realText($maxNbChars = 100, $indexSize = 2))
                ->setContent($generator->realText($maxNbChars = 1000, $indexSize = 2))
                ->setImage($generator->imageUrl($width = 600, $height = 600, 'business'))
                ->setNbCollaborators($generator->numberBetween($min = 1, $max = 10))
                ->setCreatedAt($generator->dateTimeBetween('-6 months'))
                ->setUrlFacebook('https://fr-fr.facebook.com/' . $this->sluggifier->sluggify($projects[$i]->getTitle()))
                ->setUrlGithub('https://github.com/' . $this->sluggifier->sluggify($generator->userName()) . '/' . $this->sluggifier->sluggify($projects[$i]->getTitle()))
                ->setUrlTwitter('https://twitter.com/' . $this->sluggifier->sluggify($projects[$i]->getTitle()))
                ->setUrlTipeee('https://fr.tipeee.com/' . $this->sluggifier->sluggify($projects[$i]->getTitle()));
            // nous récupèrons un statut et un créateur au hasard
            $randomStatut = $status[mt_rand(0, (count($status) - 1))];
            $randomUser = $users[mt_rand(0, (count($users) - 1))];
            // puis nous les ajoutons au projet
            $projects[$i]->setStatut($randomStatut);
            $projects[$i]->setOwner($randomUser);
            $manager->persist($projects[$i]);
        }

        // table "Tag"
        $tags = [];
        for ($i = 0; $i < 10; $i++) {
            $tags[$i] = new Tag();
            $tags[$i]->setName($generator->unique()->TagName());
            $manager->persist($tags[$i]);
        }

        // table "Techno"
        $technos = [];
        for ($i = 0; $i < 16; $i++) {
            $technos[$i] = new Techno();
            $technos[$i]->setName($generator->unique()->technoName());
            $manager->persist($technos[$i]);
        }

        // table "Skill"
        $skills = [];
        for ($i = 0; $i < 10; $i++) {
            $skills[$i] = new Skill();
            $skills[$i]->setName($generator->unique()->skillName());
            $manager->persist($skills[$i]);
        }

        // table "Comment"
        $comments = [];
        for ($i = 0; $i < 50; $i++) {
            $comments[$i] = new Comment();
            // nous récupèrons un projet et un utilisateur au hasard
            $randomProject = $projects[mt_rand(0, (count($projects) - 1))];
            $randomUser = $users[mt_rand(0, (count($users) - 1))];
            // puis nous les ajoutons au commentaire
            $comments[$i]->setProject($randomProject);
            $comments[$i]->setUser($randomUser);
            // stocke le nombre de jours entre la date de création du projet et la date actuelle
            $days = (new \Datetime())->diff($randomProject->getCreatedAt())->days;
            $comments[$i]->setContent($generator->realText($maxNbChars = 100, $indexSize = 2))
                ->setCreatedAt($generator->dateTimeBetween('-' . $days . ' days'));
            $manager->persist($comments[$i]);
        }

        // table "Follow"
        foreach ($projects as $project) {
            $nbLikes = 0;
            shuffle($users);
            $userCount = mt_rand(0, (count($users) - 1));
            for ($i = 0; $i <= $userCount; $i++) {
                $follow = new Follow;
                $follow->setIsFollowed(true);
                $follow->setProject($project);
                $follow->setUser($users[$i]);
                $manager->persist($follow);
                // nous mettons à jour le champ nbLikes du projet
                $nbLikes++;
                $project->setNbLikes($nbLikes);
            }
        }

        // REMPLIT LES TABLES DE RELATIONS "MANY TO MANY"

        // table "project_tag"
        foreach ($projects as $project) {
            shuffle($tags);
            $tagCount = mt_rand(1, 3);
            for ($i = 1; $i <= $tagCount; $i++) {
                $project->addTag($tags[$i]);
            }
            $manager->persist($project);
        }

        // table "project_techno"
        foreach ($projects as $project) {
            shuffle($technos);
            $technoCount = mt_rand(1, 5);
            for ($i = 1; $i <= $technoCount; $i++) {
                $project->addTechno($technos[$i]);
            }
            $manager->persist($project);
        }

        // table "project_skill"
        foreach ($projects as $project) {
            shuffle($skills);
            $skillCount = mt_rand(1, 5);
            for ($i = 1; $i <= $skillCount; $i++) {
                $project->addSkill($skills[$i]);
            }
            $manager->persist($project);
        }

        // table "user_skill"
        foreach ($users as $user) {
            shuffle($skills);
            $skillCount = mt_rand(1, 2);
            for ($i = 1; $i <= $skillCount; $i++) {
                $user->addSkill($skills[$i]);
            }
            $manager->persist($user);
        }

        // table "user_techno"
        foreach ($users as $user) {
            shuffle($technos);
            $technoCount = mt_rand(1, 5);
            for ($i = 1; $i <= $technoCount; $i++) {
                $user->addTechno($technos[$i]);
            }
            $manager->persist($user);
        }

        // table "Collaboration"
        foreach ($projects as $project) {
            shuffle($users);
            $userCount = mt_rand(0, 5);
            for ($i = 0; $i <= $userCount; $i++) {
                $collaboration = new Collaboration;
                $collaboration->setUser($users[$i]);
                $collaboration->setProject($project);
                // stocke le nombre de jours entre la date de création du projet et la date actuelle
                $days = (new \Datetime())->diff($project->getCreatedAt())->days;
                $collaboration->setjoinedAt($generator->dateTimeBetween('-' . $days . ' days'));
                $manager->persist($collaboration);
            }
        }

        $manager->flush();
    }
}
