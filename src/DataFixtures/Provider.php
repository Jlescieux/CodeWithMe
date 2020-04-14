<?php

namespace App\DataFixtures;

use Faker\Provider\Base;

class Provider extends Base
{

    // Permet de générer dans l'ordre du tableau
    private static $nextKey = -1;

    protected static $statutName = [
        'Concept',
        'En cours',
        'Terminé'
    ];

    protected static $projectTitle = [
        'E-rencontre',
        'Tartare-de-thon.fr',
        'Création d\'un CMS',
        'Site de vente de voitures',
        'Infos-dev.fr',
        'NosAmisLesRats',
        'Plateforme d\'apprentisssage en ligne',
        'Blog sur le développement personnel',
        'Wikimusique',
        'Service de traduction en ligne'
    ];

    protected static $jobTitle = [
        'Designeur',
        'Intégrateur',
        'Développeur full stack',
        'Développeur front-end',
        'Développeur back-end',
        'Project manager',
        'Product Owner',
        'Community manager',
        'Commercial',
        'Traffic manager',
        'Développeur multimédia',
        'Web designer',
        'Rédacteur web'
    ];

    protected static $tagName = [
        'Jeux vidéos',
        'E-commerce',
        'Service web',
        'Blog',
        'Nouvelles technlogies',
        'Voyage',
        'Site vitrine',
        'Musique',
        'Art',
        'Formation'
    ];

    protected static $technoName = [
        'HTML',
        'CSS',
        'Bootstrap',
        'Javascript',
        'Angular',
        'Bulma',
        'React',
        'jQuery',
        'Java',
        'Node JS',
        'Python',
        'PHP',
        'Symfony',
        'Ruby',
        'C++',
        'Laravel',
    ];

    protected static $skillName = [
        'Gestion de projet',
        'Webmarketing',
        'UX',
        'Référencement',
        'Base de données',
        'Business Development',
        'Montage vidéo',
        'Administration système',
        'Graphisme',
        'Big Data'
    ];


    public static function statutName(){
        static::$nextKey++;
        return static::$statutName[static::$nextKey];
    }

    public static function projectTitle(){
        return static::randomElement(static::$projectTitle);
    }   
    
    public static function jobTitle(){
        return static::randomElement(static::$jobTitle);
    }

    public static function tagName(){
        return static::randomElement(static::$tagName);
    }

    public static function technoName(){
        return static::randomElement(static::$technoName);
    }
    
    public static function skillName(){
        return static::randomElement(static::$skillName);
    }
}