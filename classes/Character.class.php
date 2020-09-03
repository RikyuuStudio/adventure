<?php

require_once PROJECT_PATH . 'classes/Dice.class.php';
require_once PROJECT_PATH . 'classes/Action.class.php';

class Character {

	private $name;

	private $level;
	private $hitPoints;

	private $status = array();
	private $attributes = array();
	private $equipments = array();
	private $actions = array();
	private $criticalHitRate = 5;
	private $criticalDamageMultiplier = 2;
	private $playable = false; // Para definir quem pode ter ações escolhidas por um jogador.
	
	private $onGuard = false;

	private $portrait;

	private $behavior;

	/**
	 * Character constructor.
	 * @param $name
	 * @param $portrait
	 * @param $actions
	 */
	public function __construct( $name,
						  $level,
						  $portrait,
						  $actions
						) {

		$this->name = $name;

		$this->level = $level;
		
		$this->attributes = array(
			
			STRENGTH => 2 * $level,
			POWER => 3 * $level,
			
			ACCURACY => 3 * $level,
			EVASION => 2 * $level,
			SPEED => 5 * $level,

			PS_RESIST => 2 * $level,
			MG_RESIST => 3 * $level,
			WILL => 2 * $level
			
		);
		
		$this->hitPoints = $this->getMaxHP();

		$this->status = array(
			
			FAINTED => false,

			POISONED => false, BLEEDING => false, BURNING => false,

			WEAKENED => false, CURSED => false, SLOW => false,

			CONFUSE => false, CHARMED => false, PARALYZED => false, BLIND => false,
			FEARFUL => false, HAUNTED => false, SILENCED => false,

			STUNNED => false, FROZEN => false, PETRIFIED => false, SLEEPING => false

		);

		$this->actions = $actions;

		$this->portrait = $portrait;

	}

	/***********
	 * GETTERS *
	 ***********/

	/**
	 * @param $actionName string
	 * @return Action
	 */
	public function getAction( $actionName = null ): Action {

		foreach ( $this->actions as $action ) {

			if ( is_string( $actionName ) && $action->getName() === $actionName )
				return $action;

		}

		return $this->getRandomAction();

	}

	/**
	 * @param null|string $key
	 * @return array|int
	 */
	public function getAttributes( $key = null ) {

		if ( isset( $key ) )
			return array_key_exists( $key, $this->attributes ) ? $this->attributes[ $key ] : 0;

		return $this->attributes;

	}

	/**
	 * @return int
	 */
	public function getCriticalDamageMultiplier(): int {

		return $this->criticalDamageMultiplier;

	}

	/**
	 * @return int
	 */
	public function getCriticalHitRate(): int {

		return $this->criticalHitRate;

	}

	/**
	 * @return int
	 */
	public function getHitPoints(): int {

		return $this->hitPoints;

	}

	/**
	 * @return int
	 */
	public function getLevel() {

		return $this->level;

	}

	/**
	 * @return string
	 */
	public function getName(): string {

		return $this->name;

	}

	public function getPortrait() {

		return "resources\images\portraits\\" . $this->portrait;

	}

	/**
	 * @param null|string $key
	 * @return array|bool
	 */
	public function getStatus( $key = null ) {

		if ( isset( $key ) )
			return array_key_exists( $key, $this->status ) ? $this->status[ $key ] : false;

		return $this->status;

	}

	/***********
	 * SETTERS *
	 ***********/

	/**
	 * @param mixed $name
	 */
	public function setName($name): void {

		$this->name = $name;

	}

	/**
	 * @param float|int $hitPoints
	 */

	public function setHitPoints($hitPoints): void {

		$this->hitPoints = $hitPoints;

	}

	/**
	 * @param $key
	 * @param null $value
	 */
	public function setAttributes( $key, $value = null ): void {

		$this->attributes[ $key ] = $value;

	}

	/**
	 * @param array $equipment
	 */
	public function setEquipment(array $equipment): void
	{
		$this->equipment = $equipment;
	}

	/**
	 * @param array $actions
	 */
	public function setActions(array $actions): void
	{
		$this->actions = $actions;
	}

	/**
	 * @param int $criticalHitRate
	 */
	public function setCriticalHitRate(int $criticalHitRate): void
	{
		$this->criticalHitRate = $criticalHitRate;
	}

	/**
	 * @param int $criticalDamageMultiplier
	 */
	public function setCriticalDamageMultiplier(int $criticalDamageMultiplier): void
	{
		$this->criticalDamageMultiplier = $criticalDamageMultiplier;
	}

	/**
	 * @param bool $playable
	 */
	public function setPlayable(bool $playable): void {

		$this->playable = $playable;

	}

	/**
	 * @param string $portrait
	 */
	public function setPortrait(string $portrait ) {

		$this->portrait = $portrait;

	}



	/**********************
	 * DYNAMIC ATTRIBUTES *
	 **********************/

	public function getInitiative() {

		return $this->attributes[ SPEED ] + Dice::roll( 20 );

	}

	public function getMaxHP( $temporary = 0 ) {

		return ( $this->level * 28 ) + $temporary;

	}

	public function getRandomAction() {
		
		$action = $this->actions[ array_rand( $this->actions) ];
		
		return $action;

	}

	/**************
	 * PROCEDURES *
	 **************/

	/**
	 * @param $action Action
	 * @param $target Character|null
	 */
	public function act( $action, $target = null ) {

		if ( is_null( $target ) ) {

			Printer::recordMessage( '<hr/>' . $this->name . $action->getPhrase() );
			$action->execute( $this );

		} elseif ( is_array( $target ) ) {

			Printer::recordMessage( '<hr/>' . $this->name . $action->getPhrase() );

			foreach ( $target as $singleTarget ) {

				$action->execute($this, $singleTarget );

			}

		} else {

			Printer::recordMessage(	'<hr/>' . $this->name . $action->getPhrase() . $target->getName() . '.' );
			$action->execute($this, $target);

		}

	}

	public function faint() {

		$this->hitPoints = 0;
		$this->setStatus( FAINTED );

		Printer::recordMessage( '<s>' . $this->getName() . ' was defeated.</s>' );

	}
	
	public function guard() {
	
	
	
	}

	public function levelUp() {



	}

	public function lockEquipment() {



	}

	public function raise() {

		if ( $this->hitPoints > 0 )
			$this->unsetStatus( FAINTED );

	}

	public function restore( $cure ) {

		$this->hitPoints + $cure > $this->getMaxHP() ? $this->hitPoints = $this->getMaxHP() : $this->hitPoints += $cure;

	}

	public function revive( $cure ) {

		$this->restore( $cure );
		$this->raise();

	}

	public function setAllStatus() {

		foreach ( array_keys($this->status) as $status ) {

			$this->setStatus( $status );

		}

	}

	public function setStatus( ...$statusTypes) {

		foreach ( $statusTypes as $statusType ) {

			$this->status[ $statusType ] = true;

		}

	}

	/**
	 * @param $action Action
	 * @param $groups Group[]
	 */
	public function setTarget( $action, $groups ) {

		switch ( $action->getScope() ) {

			case SINGLE_ENEMY:

				foreach ( $groups as $group ) {

					if ( ! $this->belongsToGroup( $group ) )
						$possibleTargetGroups[ key($groups) ] = $group;

					next( $groups);

				}

			break;
			case SINGLE_ALLY || ALL_ALLIES:

				foreach ( $groups as $group ) {

					if ( $this->belongsToGroup( $group ) )
						$possibleTargetGroups[ key($groups) ] = $group;

					next( $groups);

				}

				break;

		}

//		return $targets[ array_rand( $targets ) ];

	}

	/**
	 * @param $groups Group[]
	 * @return Group;
	 */
	public function setTargetGroup( $groups ) {

		return $this->belongsToGroup( $groups[ 1 ] ) ? $groups[2] : $groups[ 1 ];

	}

	public function takeDamage( $damage ) {

		$damage >= $this->hitPoints ? $this->faint() : $this->hitPoints -= $damage;

	}

	public function unsetAllStatus() {

		foreach ( array_keys($this->status) as $status ) {

			$this->unsetStatus( $status );

		}

	}

	public function unsetStatus( ...$statusTypes ) {

		foreach ( $statusTypes as $statusType ) {

			$this->status[$statusType] = false;

		}

	}

	/*************
	 * VERIFIERS *
	 *************/

	/**
	 * @param $group Group
	 * @return boolean
	 */
	public function belongsToGroup( $group ) : bool {

		return array_search( $this, $group->getCharacters() ) ? true : false;

	}

	public function canAct() {

		$causalStatus = array( FAINTED, STUNNED, FROZEN, PETRIFIED, SLEEPING );

		foreach ( $causalStatus as $status) {

			if ( $this->status[ $status ] )
				return false;

			next( $causalStatus);

		}

		return true;

	}

	public function canAttackAllies() {

		$causalStatus = array( BLIND, CONFUSE, HAUNTED );

		foreach ( $causalStatus as $status) {

			if ( $this->status[ $status ] == true )
				return true;

		}

		return false;

	}

	public function canAttackItself() {

		$causalStatus = array( BLIND, CONFUSE, HAUNTED );

		foreach ( $causalStatus as $status) {

			if ( $this->status[ $status ] == true )
				return true;

		}

		return false;

	}

	public function canBeTargeted() {

		return $this->isFainted() ? false : true;

	}

	/**
	 * @param $attacker Character
	 * @return boolean
	 */
	public function evades( $attacker ) {

		$evasion = 50 + $this->attributes[ EVASION ] - $attacker->getAttributes( ACCURACY );

		if ( $evasion < 10 )
			$evasion = 10;

		return Dice::roll(100) < $evasion ? true : false;

	}

	public function isDisponible() {

		return $this->playable ? true : false;

	}

	public function isFainted() {

		return $this->status[ FAINTED ] ? true : false;

	}
	
	public function isOnGuard() {
		
		return $this->onGuard;
		
	}

	/**
	 * @return bool
	 */
	public function isPlayable(): bool {

		return $this->playable;

	}

	/**
	 * @param $group Group
	 * @return Character
	 */
	public function getOpponent( $group ) {

		$characters = $group->getCharacters();

		return $characters[ array_rand( $characters ) ];

	}
	
}