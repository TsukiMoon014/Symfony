<?php
namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OC\PlatformBundle\Entity\Advert;

class AdvertController extends Controller
{

  public function indexAction($page){

  	if($page < 1){
  		throw new NotFoundHttpException("Page".$page."does not exists");
  	}


  	$listAdverts = array(
      array(
        'title'   => 'Recherche développpeur Symfony',
        'id'      => 1,
        'author'  => 'Alexandre',
        'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Mission de webmaster',
        'id'      => 2,
        'author'  => 'Hugo',
        'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Offre de stage webdesigner',
        'id'      => 3,
        'author'  => 'Mathieu',
        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Offre de d\'esclave tamagochi',
        'id'      => 4,
        'author'  => 'Momo',
        'content' => 'NSi toi aussi tu as envie de nettoyer de la merde virtuelle...',
        'date'    => new \Datetime())
    );

    return $this->render('OCPlatformBundle:Advert:index.html.twig',
      ['listAdverts'=>$listAdverts]);
  }

  public function viewAction($id){
  		$repository = $this->getDoctrine()->getManager()->getRepository('OCPlatformBundle:Advert');

      $advert = $repository->find($id);
      if(null === $advert){
        throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas");
      }

	    return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
	      'advert' => $advert
	    ));
  	}

  public function addAction(Request $request)
  {

    $advert = new Advert();
    $advert->setTitle('Recherche esclave php');
    $advert->setAuthor('Amazon');
    $advert->setContent('On cherche un bon pigeon des familles.');

    $em = $this->getDoctrine()->getManager();
    $em->persist($advert);
    $em->flush();

  	if($request->isMethod('POST')){
  		$request->getSession()->getFlashBag()->add('notice','Annonce enregistrée');

  		return $this->redirectToRoute('oc_platform_view',['id'=>$advert->getId()]);
  	}

  	return $this->render('OCPlatformBundle:Advert:add.html.twig',['advert'=>$advert]);

  }

  public function editAction($id,Request $request){
	$advert = array(
	      'title'   => 'Recherche développpeur Symfony2',
	      'id'      => $id,
	      'author'  => 'Alexandre',
	      'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
	      'date'    => new \Datetime()
	    );

  	return $this->render('OCPlatformBundle:Advert:edit.html.twig',[
  		'advert'=>$advert]);
  }

  public function deleteAction($id){
  	$advert = array(
	      'title'   => 'Recherche développpeur Symfony2',
	      'id'      => $id,
	      'author'  => 'Alexandre',
	      'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
	      'date'    => new \Datetime()
	    );

  	return $this->render('OCPlatformBundle:Advert:delete.html.twig',['advert'=>$advert]);
  }

  public function menuAction($limit){
  	$listAdverts = array(
      array(
        'title'   => 'Recherche développpeur Symfony',
        'id'      => 1,
        'author'  => 'Alexandre',
        'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Mission de webmaster',
        'id'      => 2,
        'author'  => 'Hugo',
        'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Offre de stage webdesigner',
        'id'      => 3,
        'author'  => 'Mathieu',
        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Offre de d\'esclave tamagochi',
        'id'      => 4,
        'author'  => 'Momo',
        'content' => 'NSi toi aussi tu as envie de nettoyer de la merde virtuelle...',
        'date'    => new \Datetime())
    );

    // Récupération dégueulasse des 3 dernières annonces au lieu d'un ORDER BY en SQL
    usort($listAdverts, function ($offer1, $offer2) {
        return $offer2['date'] <=> $offer1['date'];
    });

    $nbAdvert = 0;
    foreach ($listAdverts as $advert) {
      $listAdvertsDisplay[] = $advert;
      $nbAdvert++;
      if($nbAdvert == $limit) break;
    }

    return $this->render('OCPlatformBundle:Advert:menu.html.twig',
    	['listAdverts' => $listAdvertsDisplay]
      );
  }
}