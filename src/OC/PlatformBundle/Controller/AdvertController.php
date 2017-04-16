<?php
namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends Controller
{

  public function indexAction()
  {
    $url = $this->generateUrl(
    	'oc_platform_view',
    	['id'=> 5],
    	UrlGeneratorInterface::ABSOLUTE_URL);
    $content = $this->get('templating')
    ->render('OCPlatformBundle:Advert:index.html.twig',
      ['advert_id'=>5]);

    return new Response($content);
  }

  public function viewAction($id){
  	return new Response("Annonce id : ".$id);
  }

  public function viewSlugAction($year, $slug, $_format){
  	return new Response("On pourrait afficher l'annonce correspondant au
            slug '".$slug."', créée en ".$year." et au format ".$_format.".");
  }

  public function addAction(){

  }

  public function deleteAction($id){

  }

  public function editAction($id){

  }
}