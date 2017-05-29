<?php

namespace OC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

	$listAdverts = array(
      array(
        'title'   => 'Recherche développpeur Symfony',
        'id'      => 1,
        'author'  => 'Alexandre',
        'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
        'date'    => new \Datetime('2017-01-01')),
      array(
        'title'   => 'Mission de webmaster',
        'id'      => 2,
        'author'  => 'Hugo',
        'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
        'date'    => new \Datetime('2017-01-02')),
      array(
        'title'   => 'Offre de stage webdesigner',
        'id'      => 3,
        'author'  => 'Mathieu',
        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
        'date'    => new \Datetime('2017-01-03')),
      array(
        'title'   => 'Offre de d\'esclave tamagochi',
        'id'      => 4,
        'author'  => 'Momo',
        'content' => 'Si toi aussi tu as envie de nettoyer de la merde virtuelle...',
        'date'    => new \Datetime('2017-01-04'))
    );

	// Récupération dégueulasse des 3 dernières annonces au lieu d'un ORDER BY en SQL
	usort($listAdverts, function ($offer1, $offer2) {
	    return $offer2['date'] <=> $offer1['date'];
	});

	$last3Adverts = array($listAdverts[0],$listAdverts[1],$listAdverts[2]);

        return $this->render('OCCoreBundle:Core:last3.html.twig',['last3Adverts' => $last3Adverts]);
    }
}
