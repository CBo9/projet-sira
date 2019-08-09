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

