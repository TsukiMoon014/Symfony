<?php
namespace OC\PlateformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends Controller
{
  public function indexAction()
  {
    $content = $this->get('templating')
    ->render('OCPlateformBundle:Advert:index.html.twig',
    	['nom'=>'olivier']);

    return new Response($content);
  }
}