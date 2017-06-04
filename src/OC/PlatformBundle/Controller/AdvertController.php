<?php
namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\Skill;
use OC\PlatformBundle\Entity\AdvertSkill;

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

    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
    if(null === $advert){
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas");
    }

    $listApplications = $em->getRepository('OCPlatformBundle:Application')->findBy(['advert' => $advert]);

    $listAdvertSkills = $em->getRepository("OCPlatformBundle:AdvertSkill")->findBy(['advert'=>$advert]);

    return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
      'advert' => $advert,
      'listApplications' => $listApplications,
      'listAdvertSkills' => $listAdvertSkills
    ));
	}

  public function editImage($advertId){
    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('OCPlatformBundle:Advert')->find($advertId);

    $advert->getImage()->setUrl("https://c1.staticflickr.com/6/5337/8940995208_5da979c52f.jpg");

    $em->flush();

    return new Response("OK");
  }

  public function addAction(Request $request)
  {

    $advert = new Advert();
    $advert->setTitle('Recherche esclave php');
    $advert->setAuthor('Amazon');
    $advert->setContent('On cherche un bon pigeon des familles.');
    $img = new Image();
    $img->setUrl("https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Toto%27025.jpg/220px-Toto%27025.jpg");
    $img->setAlt('altTata.jpg');
    $img->setIsSfw(TRUE);

    $advert->setImage($img);

    $application1 = new Application();
    $application1->setAuthor('Renardo');
    $application1->setContent('Je suis malin tout plein. Reeeeenaaaard ! Sacripant');
    $application1->setAdvert($advert);

    $application2 = new Application();
    $application2->setAuthor('Alphonso');
    $application2->setContent('Je suis toujours à fond, à poing');
    $application2->setAdvert($advert);

    $em = $this->getDoctrine()->getManager();

    $listSkills = $em->getRepository("OCPlatformBundle:Skill")->findAll();

    foreach ($listSkills as $skill) {
      $advertSkill = new AdvertSkill();

      $advertSkill->setAdvert($advert);
      $advertSkill->setSkill($skill);
      $advertSkill->setLevel("Expert");

      $em->persist($advertSkill);
    }

    $em->persist($advert);
    $em->persist($application1);
    $em->persist($application2);

    $em->flush();

  	if($request->isMethod('POST')){
  		$request->getSession()->getFlashBag()->add('notice','Annonce enregistrée');

  		return $this->redirectToRoute('oc_platform_view',['id'=>$advert->getId()]);
  	}

  	return $this->render('OCPlatformBundle:Advert:add.html.twig',['advert'=>$advert]);

  }

  public function editAction($id,Request $request){

    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository("OCPlatformBundle:Advert")->find($id);
    if(null === $advert){
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas");
    }

    $listeCategories = $em->getRepository("OCPlatformBundle:Category")->findAll();

    foreach ($listeCategories as $category) {
      $advert->addCategory($category);
    }

    $em->flush();

  	return $this->render('OCPlatformBundle:Advert:edit.html.twig',[
  		'advert'=>$advert]);
  }

  public function deleteAction($id){
  	$em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository("OCPlatformBundle:Advert")->find($id);
    if(null === $advert){
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas");
    }

    foreach ($advert->getCategories() as $category) {
      $advert->removeCategory($category);
    }

    $em->flush();

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