<?php
namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{

  public function indexAction($page){

  	if($page < 1){
  		throw new NotFoundHttpException("Page".$page."does not exists");
  	}
    return $this->render('OCPlatformBundle:Advert:index.html.twig',
      ['page'=>$page]);
  }

  public function viewAction($id, Request $request){
  		return $this->render(
  			'OCPlatformBundle:Advert:view.html.twig',
      		['id'=>$id]
		);
  	}

  public function addAction(Request $request){

  	if($request->isMethod('POST')){
  		$request->getSession()->getFlashBag()->add('notice','Annonce enregistrée');

  		return $this->redirectToRoute('oc_platform_view',['id'=>5]);
  	}

  	return $this->render('OCPlatformBundle:Advert:add.html.twig');

  }

  public function editAction($id,Request $request){
	if($request->isMethod('POST')){
	  		$request->getSession()->getFlashBag()->add('notice','Annonce modifiée');

	  		return $this->redirectToRoute('oc_platform_view',['id'=>$id]);
	  	}

  	return $this->render('OCPlatformBundle:Advert:edit.html.twig');
  }

  public function deleteAction($id){
  	return $this->render('OCPlatformBundle:Advert:delete.html.twig');
  }

  public function menuAction(){
  	$listAdverts = array(
      array('id' => 2, 'title' => 'Recherche développeur Symfony'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );

    return $this->render('OCPlatformBundle:Advert:menu.html.twig',
    	['listAdverts' => $listAdverts]
      );
  }
}