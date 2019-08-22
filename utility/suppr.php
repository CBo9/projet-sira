<?php

require('fonctions.php');
require('../templates/navbar.php');

// RECUPERATION DE L'"id" EN GET
echo $_GET['id'];
if(!isset($_SESSION['id']) OR $_SESSION['statut']!='admin'){
	echo '<span class="erreur">Vous n\'avez pas accès à ces fonctionnalités (réservé aux administrateurs)</span> <a href="../index.php">Retourner à l\'accueil</a>';
}else{
// REQUETE DE SUPPRESSION DES VEHICULE DANS LA BASE DE DONNEE 
if(isset($_GET['idv']))
{
	$id=$_GET['idv'];

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

// REQUETE DE SUPPRESSION DES AGENCES DANS LA BASE DE DONNEE
if(isset($_GET['ida']))
{
	$id=$_GET['ida'];

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

// REQUETE DE SUPPRESSION DES MEMBRES DANS LA BASE DE DONNEE
if(isset($_GET['idm']))
{
	$id=$_GET['idm'];

	$db=connexion('sira');
	
	$req=$db->prepare("DELETE FROM membres WHERE id='$id'");
	$req->execute();
	header('location:../pages/membre.php');
	
}

// REQUETE DE SUPPRESSION DES COMMANDES DANS LA BASE DE DONNEE
if(isset($_GET['idc']))
{
	$id=$_GET['idc'];

	$db=connexion('sira');
	$recup=$db->prepare("SELECT id_vehicule FROM commande WHERE id_commande='$id'");
	$recup->execute();
	while($data=$recup->fetch()){$recupId=$data['id_vehicule'];}
	$requ=$db->prepare("UPDATE vehicule  SET statutV='dispo' WHERE id_vehicule='$recupId'");
	$requ->execute(['statutV'=>'dispo']);
	$req=$db->prepare("DELETE FROM commande WHERE id_commande='$id'");
	$req->execute();
	header('location:../pages/commandes.php');
}


if(isset($_GET['filtre'])){
	$filtre=$_GET['filtre'];
	if($filtre==0){
		$_SESSION['filtre']='ASC';
	}else{
		$_SESSION['filtre']='DESC';
	}
	header('Location:../index.php');
}
}