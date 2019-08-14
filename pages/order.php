<?php
$titrePage='Réservation';
require('../templates/navbar.php');
require('../utility/fonctions.php');

$id=$_GET['id'];
$datenow=date('Y-m-d');
$connect= connexion('sira');
$req=$connect->prepare("SELECT * FROM vehicule AS v INNER JOIN agences AS a ON v.id_agence=a.id_agence  WHERE id_vehicule='$id'");
$req->execute();
while($donnees = $req->fetch()){
	$ida=$donnees['id_agence'];
	$titre=$donnees['titreV'];
	$marque=$donnees['marque'];
	$modele=$donnees['modele'];
	$prixJ=$donnees['prix_journalier'];
	$descr=$donnees['descriptionV'];
	$image=$donnees['photoV'];
	$nomA=$donnees['titreA'];
	$adr=$donnees['adresse'];
	$ville=$donnees['ville'];
	$cp=$donnees['cp'];
	$descrA=$donnees['descriptionA'];
	$imageA=$donnees['photoA'];
}

?> <h1>Réserver la <?= $titre?></h1>

<div class="infosCar">
<img src="../img/voitures/<?= $image;?>" class='photOrder'>
<div class="infos">
	<p>Véhicule : <?= ' ' . $titre; ?></p>
	<p>Description: <em><?= ' ' . $descr; ?></em></p>
	<p>Prix journalier : <?= ' ' . $prixJ; ?>€/jour</p>
		
</div>
<div class="infosA">
	<fieldset>
	<img src="../img/agences/<?= $imageA;?>" class="photoTab2 photoTab">
	<p>Agence: <?= ' ' . $nomA;?></p>
	<p><?=$adr ;?></p>
	<p><?=$cp .' '.  $ville;?></p></div>
</fieldset>
</div>

<div class="resa">
	<form method='post' name="formOrder">
		<input type="text" hidden name="prixT" id="pt" value="">
		<input type="date"   min="<?= $datenow;?>"  value="<?= $datenow;?>" name="dateD" id="dateD">
		<input type="date"  onclick="datej()" min="<?= $datenow;?>" name="dateF" id="dateF">
		<button onclick="calculer(<?= $prixJ; ?>)">Réserver</button>
		<input type="submit" name="envoi" value="Confirmer">
		<p id="res"></p>
	</form>
</div>




<script>
function temps(date)
{
var d = new Date(date[2], date[1] - 1, date[0]);
return d.getTime();
}
function calculer(prixj) 
{ 

var date1=document.getElementById('dateD').value;
var date2=document.getElementById('dateF').value;
var dateD=date1.replace(/-/gi, '/');
var dateF=date2.replace(/-/gi, '/');

var debut = temps(dateD.split("/"));
var fin = temps(dateF.split("/"));
var nb = (fin - debut) / (1000 * 60 * 60 * 24); // + " jours";
nb= (Math.floor(nb/365));
nb++;
document.getElementById('res').innerHTML='Vous réservez pour ' + nb + 'jours: ' + (nb*prixj)+ '€.';
document.getElementById('pt').value = nb*prixj;
} 

function datej(){

	var date1=document.getElementById('dateD').value;
	document.getElementById('dateF').min=date1;



}
</script>

<?php 
if (isset($_POST['envoi'])) {
	$db=connexion('sira');
	$ins=$db->prepare('INSERT INTO commande (id_membre, id_vehicule, id_agence, date_depart, date_fin, prix_total) VALUES (:idm,:idv,:ida,:dd,:df,:pt)');
	$ins->execute(['idm' => $_SESSION['id'],
					'idv' =>$id,
					'ida' =>$ida,
						'dd'=>$_POST['dateD'],
						'df'=>$_POST['dateF'],
						'pt'=>$_POST['prixT']]);

}

