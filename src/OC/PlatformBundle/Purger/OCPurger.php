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
		return '<html><body>Purge des '.$days.' derniers jours</body></html>';
	}

}