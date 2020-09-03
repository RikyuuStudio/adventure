<?php


class Action {

	private $name;
	private $description; // Only for interface
	private $type;
	private $phrase;

	private $cost;
	private $costType;
	
	private $effectType;
	private $effectValue;
	private $effectVariation;
	private $effectModifier;
	
	
	private $scope;

	private $critical;
	
	private $active;
	

	public function __construct( $name, $type, $phrase, $scope,
						  $effectValue, $effectModifier, $effectVariation,
						  $critical
						) {
		
		$this->name = $name;
		$this->type = $type;
		$this->phrase = $phrase;
		$this->scope = $scope;
		$this->effectValue = $effectValue;
		$this->effectModifier = $effectModifier;
		$this->effectVariation = $effectVariation;
		$this->critical = $critical;

	}

	public function getPhrase() {

		return $this->phrase;

	}

	public function getName() {

		return $this->name;

	}

	public function getType() {

		return $this->type;

	}
	
	public function getScope() {
		
		return $this->scope;
		
	}

	/**
	 * @param $user Character
	 * @param $target Character
	 */
	public function execute( $user, $target = null ) {

		switch ( $this->type ) {

			case OFFENSIVE:

				if ( ! $target->evades( $user ) ) {

					$damage = $this->calculateEffect($user, $target );

					Printer::recordMessage( $target->getName() . ' takes ' . $damage . ' damage points.' );

					$target->takeDamage($damage);

				} else {

					Printer::recordMessage( $target->getName() . ' evades.' );

				}

				break;

		}


	}

	/**
	 * @param $user Character
	 * @param $target Character
	 * @return int
	 */
	public function calculateEffect( $user, $target = null ) {

		$base = $this->effectValue;
		$modifier = $user->getAttributes( $this->effectModifier );
		$variation = Dice::roll( $this->effectVariation );

		$result = $base + $modifier + $variation;
		
		

		if ( $this->critical && $this->checkCriticalHit( $user ) )
			$result = $this->calculateCriticalDamage( $user, $result );

		return $result;

	}

	/**
	 * @param $user Character
	 * @param $damage int
	 * @return int
	 */
	public function calculateCriticalDamage( $user, $damage ) {

		$damage *= $user->getCriticalDamageMultiplier();

		return $damage;

	}

	/**
	 * @param $user Character
	 * @return bool
	 */
	public function checkCriticalHit( $user ) {

		return rand( 0, 100 ) <= $user->getCriticalHitRate() ? true : false;

	}

}