<?php
$titrePage="Gestion de commandes";
require('../templates/navbar.php');
require('../utility/fonctions.php'); ?>

<table class="order">
	<h1>Nos commandes</h1>
		<tr>
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
<!-- FIN DE L'AFFICHAGE DES VEHICULE -->


<!-- DEBUT DE L'AFFICHAGE DES COMMANDES -->
<?php
$idm = $_SESSION['id'];
$connect=connexion('sira');
$requete=$connect->prepare("SELECT * FROM commande  AS c INNER JOIN agences AS a ON c.id_agence=a.id_agence INNER JOIN vehicule AS v on c.id_vehicule = v.id_vehicule INNER JOIN membres AS m ON m.id = c.id_membre ");
$requete->execute();
while($donnees =$requete->fetch()){
	echo "<tr>
			<td> ". $donnees['id_commande'] . "</td>
			<td> ". $donnees['id'] . "</td>
			<td> ". $donnees['prenom'] . "  " .  $donnees['nom'] . "</td>
			<td><img src='../img/voitures/" . $donnees['photoV'] . "' class='photoTab'>" . $donnees['titreV'] ."</td>
			<td>". $donnees['titreA']."</td>
			<td>". $donnees['date_depart']." </td>
			<td>".$donnees['date_fin']." </td>
			<td>".$donnees['prix_total']." </td>
			<td></td>
			<td><a href=../utility/suppr.php?idc=" . $donnees['id_commande'] .">Supprimer</a>
		</tr>";
}
// FIN DE L'AFFICHAGE DU TABLEAU



  ?>
</table>