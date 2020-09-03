<?php

require_once PROJECT_PATH . 'classes/Character.class.php';

class Group {
	
	/**
	 * @var Character array
	 */
	private $characters = array();
	
	
	/**
	 * Group constructor.
	 * @param Character ...$characters
	 */
	function __construct( ...$characters ) {
		
		$position = 1;

		foreach ( $characters as $character ) {
			
			$this->characters[$position++] = $character;
			
		}

	}

	/***********
	 * GETTERS *
	 ***********/

	/**
	 * @return Character
	 */
	public function getCharacters(): array
	{
		return $this->characters;
	}

	/***********
	 * SETTERS *
	 ***********/

	/**
	 * @param Character $characters
	 */
	public function setCharacters(Character $characters): void
	{
		$this->characters = $characters;
	}



	/**************
	 * PROCEDURES *
	 **************/

	function presentTargets() {

		$targetableCharacters = array();

		reset( $this->characters);

		/**
		 * @var $character Character
		 */
		foreach ($this->characters as $character ) {

			if ( $character->canBeTargeted() )
				$targetableCharacters[ key( $this->characters ) ] = $character;

			next($this->characters );

		}

		return $targetableCharacters;

	}

	/*************
	 * VERIFIERS *
	 *************/

	function canBeTargeted() {

		return $this->isGroupFainted() ? false : true;

	}

	/**
	 * @return bool
	 */
	function isGroupFainted() {
		
		$faintedCounter = 0;

		/**
		 * @var $character Character
		 */
		foreach($this->characters as $character) {

			if ( $character->isFainted() )
				$faintedCounter++;
		
		}
		
		return $faintedCounter == sizeof($this->characters) ? true : false;

	}

}