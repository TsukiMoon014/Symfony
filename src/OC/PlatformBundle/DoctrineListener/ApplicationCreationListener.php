<?php

namespace OC\PlatformBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Email\ApplicationMailer;

class ApplicationCreationListener{

	/**
	 * @var applicationMailer
	 */
	private $applicationMailer;


	/**
	 * @param applicationMailer   $applicationMailer
	 */
	public function __construct($applicationMailer)
	{
		$this->applicationMailer = $applicationMailer;
	}

	public function postPersist(LifecycleEventArgs $args){
		$entity = $args->getObject();

		if(!$entity instanceof Application){
			return;
		}

		$this->applicationMailer->sendNewNotification($entity);
	}
}