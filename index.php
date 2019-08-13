<?php
$titrePage="Localoc, les meilleurs voitures aux meileurs prix";
require('templates/navbar.php');
require('utility/fonctions.php');?>

<h1>Bienvenue sur Localoc</h1>

<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />


<div id="cssSlider">
  <div id="sliderImages">
    <img id="si_1" src="imgcarr/voiture1.jpg" alt="" />
    <img id="si_2" src="imgcarr/voiture2.jpg" alt="" />
    <img id="si_3" src="imgcarr/voiture3.jpg" alt="" />
    <img id="si_4" src="imgcarr/voiture4.jpg" alt="" />
    <img id="si_5" src="imgcarr/voiture1.jpg" alt="" />
    <div style="clear:left;"></div>
  </div>
</div>

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