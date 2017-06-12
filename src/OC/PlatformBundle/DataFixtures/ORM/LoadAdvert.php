<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadAdvert.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Application;

class LoadAdvert implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Adverts sans application
    $listFixture = array(
      // advert pas assez vieille
      array('date' => new \DateTime('2017-06-10'),
            'title' => 'Recherche de pigeon n°1',
            'author' => 'Basam badum',
            'content' => "My money's in that office, right?",
            'applications' => array()
            ),
      // advert assez vieille et sans application
      array('date' => new \DateTime('2017-06-01'),
            'title' => 'Recherche de pigeon n°2',
            'author' => 'Basam badum bidum',
            'content' => "Now that we know who you are, I know who I am. I'm not a mistake! It all makes sense! ",
            'applications' => array()
            )
      );

    foreach ($listFixture as $fixture) {
      // On crée l'advert
      $advert = new Advert();
      $advert->setDate($fixture['date']);
      $advert->setTitle($fixture['title']);
      $advert->setAuthor($fixture['author']);
      $advert->setContent($fixture['content']);

      // On la persiste
      $manager->persist($advert);
    }
    // On déclenche l'enregistrement de toutes les adverts
    $manager->flush();

    // Advert vieille mais avec application
    $apply = new Application();
    $apply->setDate(new \DateTime('2017-06-05'));
    $apply->setAuthor('Toto');
    $apply->setContent('Moi trop fort toi prendre moi');

    $advert = new Advert();
    $advert->setDate(new \DateTime('2017-06-02'));
    $advert->setTitle('Recherche de pigeon n°3');
    $advert->setAuthor('Basam badum bidum tudam');
    $advert->setContent("The path of the righteous man is beset on all sides by the iniquities of the selfish and the tyranny of evil men. ");
    $advert->addApplication($apply);

    $manager->persist($apply);
    $manager->persist($advert);

    // On déclenche l'enregistrement de toutes les adverts
    $manager->flush();
  }
}
