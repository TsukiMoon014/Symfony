<?php

namespace OC\PlatformBundle\Email;

use OC\PlatformBundle\Entity\Application;

class ApplicationMailer{

	/**
	 * @var Swift_Mailer
	 */
	private $mailer;

	/**
	 * @param \Swift_Mailer $mailer [description]
	 */
	public function __construct(\Swift_Mailer $mailer){
		$this->mailer = $mailer;
	}

	public function sendNewNotification(Application $application){
		$message = new \Swift_Message(
			"Nouvelle candidature",
			"Vous avez reçu à une cadidature"
		);

		try{
			$message->addTo($application->getAdvert()->getAuthor());
		}catch(\Exception $e){

		}
		$message->addFrom("olivier@admin.com");

		$this->mailer->send($message);
	}
}