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
      		['id'=>5]
		);
  	}

  public function addAction(Request $request){

  	if($request->isMethode('POST')){
  		$request->getSession()->getFlashBag()->add('notice','Annonce enregistrée');

  		return $this->redirectToRoute('oc_platform_view',['id'=>5]);
  	}

  	return $this->render('OCPlatformBundle:Advert:add.html.twig');

  }

  public function editAction($id,Request $request){
	if($request->isMethode('POST')){
	  		$request->getSession()->getFlashBag()->add('notice','Annonce modifiée');

	  		return $this->redirectToRoute('oc_platform_view',['id'=>5]);
	  	}

  	return $this->render('OCPlatformBundle:Advert:edit.html.twig');
  }

  public function deleteAction($id){
  	return $this->render('OCPlatformBundle:Advert:delete.html.twig');
  }
}