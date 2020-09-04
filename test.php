<html>

<head>

	<meta charset="UTF-8">
	<!--		<title>  </title>-->
	<link rel="stylesheet" href="resources/css/basic.css">

</head>

<body>

<?php

header('content-type: text/html;charset=utf-8');

require_once 'core/config.php';
require_once PROJECT_PATH . 'core/utils.php';
require_once PROJECT_PATH . 'core/defines.php';
require_once PROJECT_PATH . 'classes/Battle.class.php';
require_once PROJECT_PATH . 'classes/Printer.class.php';

// Gerando ações

$attack = new Action(
	ATTACK,
	OFFENSIVE,
	' attacks ',
	SINGLE_ENEMY,
	0,
	STRENGTH,
	10,
	true
);

$guard = new Action(
	GUARD,
	NEUTRAL,
	' went in defensive stance.',
	SELF,
	0,
	null,
	0,
	false
);

$kamehameha = new Action(
	'Kame Hame Ha',
	OFFENSIVE,
	' shoots a Kame Hame Ha against ',
	SINGLE_ENEMY,
	20,
	POWER,
	15,
	true
);

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

$galickho = new Action(
	'Galick Ho',
	OFFENSIVE,
	' shoots a Galick Ho against ',
	SINGLE_ENEMY,
	15,
	POWER,
	20,
	true
);

$bakuhatsuha = new Action(
	'Bakuhatsuha',
	OFFENSIVE,
	' casts Bakuhatsuha!',
	ALL_ENEMIES,
	10,
	POWER,
	10,
	true
);

$moon = new Action(
	'Artificial Moon',
	NEUTRAL,
	' creates an artificial moon!',
	ENVIRONMENT,
	10,
	POWER,
	0,
	false
);

$makkankosappo = new Action(
	'Makkankosappo',
	OFFENSIVE,
	' shoots a Makkankosappo against ',
	SINGLE_ENEMY,
	10,
	POWER,
	25,
	true
);

$normalActions = array( 1 => $attack, );
$gokuActions = array( 1 => $attack, $kamehameha, $kaioken );
$piccoloActions = array( 1 => $attack, $makkankosappo );
$nappaActions = array( 1 => $attack, $bakuhatsuha );
$vegetaActions = array( 1 => $attack, $galickho );


//	dd ( $normalActions, $gokuActions, $vegetaActions );


// Gerando heróis

$hero1 = new Character(
	'Kakarotto',
	8,
	'goku.png',
	$gokuActions
);

$hero2 = new Character(
	'Piccolo',
	3,
	'piccolo.png',
	$piccoloActions
);

$hero3 = new Character(
	'Gohan',
	2,
	'gohan.png',
	$normalActions
);

$hero4 = new Character(
	'Kuririn',
	2,
	'kuririn.png',
	$normalActions
);

// Gerando inimigos

$enemy1 = new Character(
	'Nappa',
	4,
	'nappa.png',
	$nappaActions
);

$enemy2 = new Character(
	'Vegeta',
	18,
	'vegeta.png',
	$vegetaActions
);

$saibaman = new Character(
	'Saibaman',
	1,
	'saibaman.png',
	$normalActions
);

// Gerando Grupos

$group1 = new Group( $hero1, $hero2, $hero3, $hero4);

$group2 = new Group( $enemy1, $enemy2);

// Gerando a Batalha

$battle = new Battle( $group1, $group2 );

//	Printer::printCard( $hero1);

$battle->runBattle();

echo '<br>teste';