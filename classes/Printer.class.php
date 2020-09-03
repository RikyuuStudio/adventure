<?php

require_once PROJECT_PATH . 'classes/Dice.class.php';

class Printer {

	static private $battleMessage = array();

	/**
	 * @param $message string
	 */
	static function recordMessage( $message ) {

		array_push( Printer::$battleMessage, '<p>' . $message . '</p>' );

	}

	/**
	 * @param $character Character
	 */
	static function printCard( $character ) {

		echo '<div class="card">';

			echo '<div class="portrait">';

				if ( $character->isFainted() ) {

					echo '<img src="' . $character->getPortrait() . '" style="filter: brightness(20%)"/>';

				} else {

					echo '<img src="' . $character->getPortrait() . '"/>';

				}

			echo '</div>';

			echo '<div class="cardname">' . strtoupper( $character->getName() ) . '</div>';

			echo '<div class="cardlevel">Lv. ' . $character->getLevel() . '</div>';

			echo '<div class="lifebar">';

				$size = (int) 118 * $character->getHitPoints() / $character->getMaxHP() . 'px';

				echo '<div class="innerlifebar" style="width: ' . $size . ';"></div>';

				echo '<div class="lifenumbers">' . $character->getHitPoints() . ' / ' . $character->getMaxHP() . '</div>';

			echo '</div>';

		echo '</div>';

	}

	static function printActions() {

		foreach ( Printer::$battleMessage as $message ) {

			echo $message;

		}

		Printer::$battleMessage = array();
	
	}

	/**
	 * @param $battle Battle
	 * @var $groups Group[]
	 */
	static function printArena( $battle ) {

		$groups = $battle->getGroups();

		echo '<div class="arena">';

			echo '<div class="arenablock messagescreen">';

				echo '<iframe>';

					echo '<div class="action">';

					echo '</div>';

				echo '</iframe>';

			echo '</div>';

			echo '<div class="arenablock group">';

				foreach ( $groups as $group ) {

					if ( key( $groups ) != 1 ) {

						foreach ($group->getCharacters() as $character) {

							Printer::printCard($character);

						}

					}

					next( $groups );

				}

			echo '</div>';

		echo '</div>';

	}

	/**
	 * @param $group Group
	 */
	static function printGroup( $characters, $float) {

		echo '<div class="group" style="float: ' . $float . '">';

			foreach ( $characters as $character ) {

				Printer::printCard($character);

			}

		echo '</div>';

	}

	/**
	 * @param $battle Battle
	 * @var $groups Group[]
	 */
	static function printTurn( $battle ) {

		echo '<hr/>';

		$groups = $battle->getGroups();

		$leftGroup = $groups[1]->getCharacters();

		$rightGroup = array();

		reset( $groups);

		foreach ( $groups as $group ) {

			foreach ( $group->getCharacters() as $character ) {

				if ( key( $groups) != 1 )
					array_push( $rightGroup, $character);

			}

			next( $groups );

		}

			Printer::printGroup( $leftGroup, 'left' );

			echo '<div class="messageboard">';

			echo '<h2>TURN ' . $battle->getTurnCount() . '</h2>';

			Printer::printActions();

			echo '</div>';

			Printer::printGroup( $rightGroup, 'right' );

	}

}