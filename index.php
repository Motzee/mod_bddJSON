<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<meta name="author" content="LaLicorne">
	<meta name="description" content="Description de la page pour les moteurs de recherche" />
	<meta name="keywords" content="mots-clefs séparés par des virgules" />
	<title>Base de données JSON</title>
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]--> <!--si t'es un vieux navigateur, t'as besoin de ça pour comprendre la nouvelle ossature de page issue de html5-->
</head>

<body>
	<h1>Page de test</h1>

<?php
	include_once('classes/Objet.php') ;
	include_once('classes/DatabaseJSON.php') ;

	$bdd = new DatabaseJSON() ;

	$obj1 = new Objet("objet1", "nombre magique", 42) ;
	$obj2 = new Objet("objet2", "nombre démoniaque", 666) ;

	//ne doit pas être objet1 pour tests
	$cible = $obj2 ;
?>
	<h2>Notre base de donnée au départ</h2>
<?php 
	echo("<pre>") ;
	var_dump($bdd->getListeFromBD()) ;
	echo("</pre>") ;
?>

	<h2>On ajoute deux objets</h2>
<?php 
	$bdd->createInDB($obj1) ;
	$bdd->createInDB($cible) ;

	echo("<pre>") ;
	var_dump($bdd->getListeFromBD()) ;
	echo("</pre>") ;
?>

<h2>On affiche l'objet <?php echo $cible->getClef() ;?></h2>
<?php 
	echo("<pre>") ;
	var_dump($bdd->readInDB($cible->getClef())) ;
	echo("</pre>") ;
?>

<h2>On supprime cet objet</h2>
<?php 
	$bdd->deleteFromDB($cible->getClef()) ;

	echo("<pre>") ;
	var_dump($bdd->getListeFromBD()) ;
	echo("</pre>") ;
?>


<h2>On modifie l'objet1</h2>
<?php 
	$nouvelObjet = new Objet("objet1", "nombre magique", 9) ;
	$bdd->editInDB($nouvelObjet) ;

	echo("<pre>") ;
	var_dump($bdd->getListeFromBD()) ;
	echo("</pre>") ;
?>

</body>
</html>
<!--
	question : droit de communiquer entre classes ? la database qui utilise la méthode getClef() d'un objet qu'elle reçoit ? c'est MVC ?
-->