<?php
$titrePage="Gestion de commandes";
require('../templates/navbar.php');
require('../utility/fonctions.php'); 

// LA VARIABLE DATE EST DEFINE
$datenow=date('Y-m-d');




?>
<!-- TABLEAU HTML POUR L'AFFICHAGE DES COMMANDES -->
<table class="order">
	<h1 class="underTitle">Nos commandes</h1>
	<thead>
		<tr>
			<td>Date de la commande</td>
			<td>Numéro de commande</td>
			<td>Numéro de client</td>
			<td>Nom et prénom</td>
			<td>Véhicule</td>
			<td>Agence</td>
			<td>Début de location</td>
			<td>Fin de location</td>
			<td>Prix total</td>
			<td>Statut</td>
			<td>Supprimer la commande</td>
		</tr>
	</thead>
<!-- FIN DU TABLEAU HTML POUR L'AFFICHAGE DES COMMANDES -->


<!-- DEBUT DE L'AFFICHAGE DES COMMANDES -->
<?php

 if (isset($_POST['modif'])){
		$dateD = isset($_POST['dateD']) ? $_POST['dateD'] : NULL;
		$dateF = isset($_POST['dateF']) ? $_POST['dateF'] : NULL;
		$prixT = isset($_POST['prixT']) ? $_POST['prixT'] : NULL;
		$id = isset($_POST['cid']) ? $_POST['cid'] : NULL;
		$db = connexion('sira');
		$update = $db ->prepare("UPDATE commande SET date_depart = '$dateD', date_fin = '$dateF', prix_total = '$prixT' WHERE id_commande = '$id'");
		$update -> execute(['date_depart' =>$dateD,
							'date_fin'=>$dateF,
							'prix_total'=>$prixT]);


	}

$connect=connexion('sira');
$requete=$connect->prepare("SELECT * FROM commande  AS c INNER JOIN agences AS a ON c.id_agence=a.id_agence INNER JOIN vehicule AS v on c.id_vehicule = v.id_vehicule INNER JOIN membres AS m ON m.id = c.id_membre ");
$requete->execute();
while($donnees =$requete->fetch()){
	echo "<tr>
			<td> ". $donnees['date_commande'] . "</td>
			<td> ". $donnees['id_commande'] . "</td>
			<td> ". $donnees['id'] . "</td>
			<td> ". $donnees['prenom'] . "  " .  $donnees['nom'] . "</td>
			<td><img src='../img/voitures/" . $donnees['photoV'] . "' class='photoTab'>" . $donnees['titreV'] ."</td>
			<td>". $donnees['titreA']."</td>
			<td>". $donnees['date_depart']." </td>
			<td>".$donnees['date_fin']." </td>
			<td>".$donnees['prix_total']." </td>
			<td>" .$donnees['statutC']. "</td>
			<td><a href=../pages/commandes.php?modc=" . $donnees['id_commande'] ."#formCom>Modifier</a>/<a href=../utility/suppr.php?idc=" . $donnees['id_commande'] .">Supprimer</a></td>
		</tr>";
}
// FIN DE L'AFFICHAGE DU TABLEAU
?>
</table>

<?php

// IF POUR FAIRE APPARAITRE LE FORMULAIRE DE MODIFICATION
if(isset($_GET['modc'])){
$id = $_GET['modc'];
$connect= connexion('sira');
$req=$connect->prepare("SELECT * FROM commande AS c INNER JOIN vehicule AS v ON c.id_vehicule=v.id_vehicule  WHERE id_commande='$id'");
$req->execute();

// ON RECUPERE LES DONNEES NECESSAIRE
while($donnees = $req->fetch()){
	$idc=$donnees['id_commande'];
	$idm=$donnees['id_membre'];
	$idv=$donnees['id_vehicule'];
	$ida=$donnees['id_agence'];
	$prixJ=$donnees['prix_journalier'];
	$prixT=$donnees['prix_total'];
	$dateD=$donnees['date_depart'];
	$dateF=$donnees['date_fin'];
}




	include('modifc.php');
	}?>
