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

    $nbPerPage = 2;

  	$listAdverts = $this->getDoctrine()->getManager()->getRepository('OCPlatformBundle:Advert')->getAdverts($page,$nbPerPage);

    $nbPages = ceil(count($listAdverts)/$nbPerPage);

    return $this->render('OCPlatformBundle:Advert:index.html.twig',
      ['listAdverts' => $listAdverts,
        'nbPages' => $nbPages,
        'page' => $page
      ]);
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

    $advert->setAuthorEmail("ol.olivier.martinez@gmail.com");

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

    if($request->isMethod('POST')){
      $request->getSession()->getFlashBag()->add('notice','Annonce modifiée');

    return $this->redirectToRoute('oc_platform_view',['id'=>$advert->getId()]);
    }

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
  	$listAdverts = $this
    ->getDoctrine()
    ->getManager()
    ->getRepository("OCPlatformBundle:Advert")
    ->findBy(
        [],
        ['date'=>'desc'],
        $limit,0);

    return $this->render('OCPlatformBundle:Advert:menu.html.twig',
    	['listAdverts' => $listAdverts]
      );
  }
}