<?php
require('fonctions.php');
echo $_GET['id'];
if(isset($_GET['id']) AND $_GET['type']=="v" )
{
$id=$_GET['id'];

	$db=connexion('sira');
	$rq=$db->prepare("SELECT * FROM vehicule WHERE id_vehicule='$id'");
	$rq->execute();
	while($photo=$rq->fetch()){
		unlink('../img/voitures/' . $photo['photoV'] );
	}

	$req=$db->prepare("DELETE FROM vehicule WHERE id_vehicule='$id'");
	$req->execute();
	header('location:../pages/ajoutv.php');
	
}

if(isset($_GET['id']) AND $_GET['type']=="a" )
{
$id=$_GET['id'];

	$db=connexion('sira');
	$rq=$db->prepare("SELECT * FROM agences WHERE id_agence='$id'");
	$rq->execute();
	while($photo=$rq->fetch()){
		unlink('../img/agences/' . $photo['photoA'] );
	}

	$req=$db->prepare("DELETE FROM agences WHERE id_agence='$id'");
	$req->execute();
	header('location:../pages/ajouta.php');
	
}

if(isset($_GET['id']) AND $_GET['type']=="m" )
{
$id=$_GET['id'];

	$db=connexion('sira');
	
	$req=$db->prepare("DELETE FROM membres WHERE id='$id'");
	$req->execute();
	header('location:../pages/membre.php');
	
}