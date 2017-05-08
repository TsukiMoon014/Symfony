<?php

namespace OC\PlatformBundle\Antispam;

class OCAntispam
{
	public function __construct(\Swift_mailer $mailer, $locale, $minLength){
		$this->mailer    = $mailer;
	    $this->locale    = $locale;
	    $this->minLength = (int) $minLength;
	}

	public function isSpam($text){
		return strlen($text) < $this->minLength;
	}
}