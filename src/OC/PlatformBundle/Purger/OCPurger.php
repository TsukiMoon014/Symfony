<?php

namespace OC\PlatformBundle\Purger;

class OCPurger{

	/**
	 * @var EntityManager
	 */
	private $em;

	/**
	 * Class Constructor
	 * @param EntityManager   $em
	 */
	public function __construct($em)
	{
		$this->em = $em;
	}

	public function purge($days){

		$oldAdverts = $this->em->getRepository('OCPlatformBundle:Advert')->findOldAdverts($days);

		foreach ($oldAdverts as $advert) {
			$this->em->remove($advert);
		}

		$this->em->flush();
		return '<html><body>Purge des '.$days.' derniers jours</body></html>';
	}

}