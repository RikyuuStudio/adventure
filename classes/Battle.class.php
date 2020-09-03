<?php

require_once PROJECT_PATH . 'classes/Group.class.php';
require_once PROJECT_PATH . 'classes/Printer.class.php';

class Battle {

	/**
	 * @var $groups Group[]
	 */
	private $groups = array();
	private $characters = array();

	private $turnOrder = array();
	private $turnCount = 1;


	/**
	 * Battle constructor.
	 * @param $playerGroup Group
	 * @param $enemyGroup Group
	 */
	public function __construct( $playerGroup, $enemyGroup ) {

		$this->groups[ 1 ] = $playerGroup;

		$this->groups[ 2 ] = $enemyGroup;

		foreach ( $this->groups[ 1 ]->getCharacters() as $character ) {

			array_push( $this->characters, $character);

		}

		foreach ( $this->groups[ 2 ]->getCharacters() as $character ) {

			array_push( $this->characters, $character);

		}

	}

	/**
	 * @return array
	 */
	public function getGroups(): array {
		
		return $this->groups;
		
	}

	/**
	 * @return array
	 */
	public function getCharacters(): array {
		
		return $this->characters;
		
	}

	/**
	 * @return array
	 */
	public function getTurnOrder(): array {
		
		return $this->turnOrder;
		
	}

	/**
	 * @return int
	 */
	public function getTurnCount(): int {
		
		return $this->turnCount;
		
	}

	/***********
	 * SETTERS *
	 ***********/

	/**
	 * @param array $groups
	 */
	public function setGroups(array $groups): void
	{
		$this->groups = $groups;
	}

	/**
	 * @param array $characters
	 */
	public function setCharacters(array $characters): void
	{
		$this->characters = $characters;
	}

	/**
	 * @param int $turnCount
	 */
	public function setTurnCount(int $turnCount): void
	{
		$this->turnCount = $turnCount;
	}

	/**************
	 * PROCEDURES *
	 **************/

	public function end() {

		echo '</div>';

		Printer::printTurn( $this );

		echo '<div style="clear:both;">';

		echo '<div style="text-align: center; font-family: Verdana"><hr/> <h2>BATTLE END</h2><hr/></div>';

		die();

	}

	public function nextTurn() {

		$this->turnCount++;

	}

	public function runBattle(){

		while ( $this->canContinue() ) {

			$this->runTurn();

		}

		$this->end();

	}

	public function runTurn() {

		$this->setTurnOrder();

		/**
		 * @var $character Character
		 * @var $action Action
		 */
		foreach ( $this->turnOrder as $character ) {

			if ( $character->getName() == 'Kakarotto' && $this->getTurnCount() == 3 ) {
			
				$character->setAttributes( STRENGTH, $character->getAttributes( STRENGTH ) * 3 );
				$character->setAttributes( POWER, $character->getAttributes( POWER ) * 3 );
				$character->setAttributes( EVASION, $character->getAttributes( EVASION ) * 3 );
				$character->setAttributes( ACCURACY, $character->getAttributes( ACCURACY ) * 3 );
				
				$character->setPortrait( 'gokukaioken.png' );
				
				$kaioken = new Action(
					'Kaioken',
					NEUTRAL,
					' uses Kaioken!',
					SELF,
					4,
					POWER,
					0,
					true
				);
				
				$character->act( $kaioken );
				
			}
			
			if ( ! $character->isFainted() ) {

				$action = $character->getAction();

				$targetGroup = $character->setTargetGroup( $this->groups );

				$targets = $targetGroup->presentTargets();

				switch ( $action->getScope() ) {

					case SELF:

						$character->act( $action );

						break;

					case ALL_ENEMIES:

						$character->act( $action, $targets );

						break;

					case SINGLE_ENEMY:

						$target = $targets[ array_rand( $targets ) ];

						$character->act( $action, $target );

				}

				if ( !$this->canContinue() )
					$this->end();

			}

		}

		Printer::printTurn( $this );

		$this->nextTurn();

		echo "<div style='clear: both'></div>";

	}

	public function setTurnOrder() {

		$this->turnOrder = array();

		/**
		 * @var $character Character
		 */
		foreach ( $this->characters as $character ) {

			if ( $character->canAct() ) {

				do {

					$initiative = $character->getInitiative();

				} while ( array_key_exists($initiative, $this->turnOrder));

				$this->turnOrder[$initiative] = $character;

			}
			
		}

		krsort( $this->turnOrder);
	
	}

	/*************
	 * VERIFIERS *
	 *************/

	/**
	 * @return bool
	 */
	public function canContinue() {

		return $this->groups[ 1 ]->isGroupFainted() || $this->groups[ 2 ]->isGroupFainted() ? false : true;

	}
		
}