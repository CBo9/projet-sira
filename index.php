<?php
$titrePage="Localoc, les meilleurs voitures aux meileurs prix";
require('templates/navbar.php');
require('utility/fonctions.php');?>

<h1>Bienvenue sur Localoc</h1>

<?php 
$pageS=isset($_GET['page']) ? $_GET['page'] +1 : 1;

if (!isset($_GET['page'])) {

$db = connexion('sira');

$req=$db->prepare('SELECT * FROM vehicule LIMIT 5');
$req->execute();
while($donnees = $req->fetch()){
	echo '<a href="pages/voiture.php?id=' . $donnees['id_vehicule'] . '"><div class="carSection"> 
	<img src="img/voitures/' . $donnees['photoV'] . '" class="photoSect"> <div class="infosSect"><h3>'. $donnees['titreV'] . '</h3><p>' . $donnees['prix_journalier'] . '€/mois</p><p><em>'. $donnees['descriptionV']. '</em></p></div></div></a>';
}

}else{

$db = connexion('sira');
$skip=5*$_GET['page'];
$query='SELECT * FROM vehicule LIMIT 5 OFFSET '. $skip  ;
$req=$db->prepare($query);
$req->execute();
while($donnees = $req->fetch()){
	echo '<a href="pages/voiture.php?id=' . $donnees['id_vehicule'] . '"><div class="carSection"> 
	<img src="img/voitures/' . $donnees['photoV'] . '" class="photoSect"> <div class="infosSect"><h3>'. $donnees['titreV'] . '</h3><p>' . $donnees['prix_journalier'] . '€/mois</p><p><em>'. $donnees['descriptionV']. '</em></p></div></div></a>';
}

}

echo '<a href="index.php?page=' . $pageS . '">Page suivante</a>';
?>