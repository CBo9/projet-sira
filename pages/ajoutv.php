<?php
$titrePage='Gestion des véhicules';
require('../templates/navbar.php');
require('../utility/fonctions.php');
//INSERTION DES NOUVELLES DONNES DANS LA BDD APRES REMPLISSAGE DU FORM

// SI LE STATUT EST DIFFERENT DE "admin"
if(!isset($_SESSION['id']) OR $_SESSION['statut']!='admin'){
	header('location: ../index.php');
}

// CODE PHP L'AJOUT DE L'AGENCE. BOUTON "envoyer" DE LA PAGE AJOUT
if (isset($_POST['envoyer'])) {

// VERIFICATION DE LA PHOTO
if (isset($_FILES['mfichier']) AND $_FILES['mfichier']['error'] == 0)  {

	// LE FICHIER NE DOIT PAS EXEDER 1Mo
	if ($_FILES['mfichier']['size'] <= 1000000) {


		// EXTENSION AUTORISEES
		$extension_autorisees = ["jpg", "jpeg", "png", "gif"];
		$info= pathinfo($_FILES['mfichier']['name']);
		
		// EXTENSION DE NOTRE FICHIER
		$extension_uploadee = $info['extension'];
		
		// ON VERIFIE L'EXTENSION
		if (in_array($extension_uploadee, $extension_autorisees)) {
			$date = date('m_d_Y_h_i_s', time());
			move_uploaded_file($_FILES['mfichier']['tmp_name'], '../img/voitures/'. $date.basename($_FILES['mfichier']['name']));

			// DECLARATION DE LA VARIABLE IMAGE
			$image = $date . basename($_FILES['mfichier']['name']) ;

			// INSERTION DE DONNEES
			$db=connexion('sira');
			$insert=$db->prepare(
				'INSERT INTO vehicule (
				id_agence, 
				titreV, 
				marque, 
				modele, 
				descriptionV, 
				photoV, 
				prix_journalier) 
				VALUES(
				:agence,
				:voiture, 
				:marque, 
				:modele, 
				:des, 
				:mfichier, 
				:prixj)');
			$insert->execute(
				['agence'=>$_POST['agence'],
				'voiture'=>$_POST['voiture'],
				 'marque' =>$_POST['marque'],
				 'modele'=> $_POST['modele'],
				  'des' => $_POST['des'],
				  	'mfichier'=>$image,
				 'prixj'=>$_POST['prixj']]);
			
		}
	
		// FIN DE LA VERIFICATION DE L'EXTENSION ET DE LA REQUETE D'INSERTION
	}
	// FIN DE LA VERIFICATION DU FICHIER
	else{

		echo "Votre fichier est trop volumineux!!! ";
	}
}
}


?>

<body >


<!--  DEBUT DE L'AFFICHAGE DU TABLEAU DES VEHICULES DE LA BDD-->	
	<h1>Nos véhicules</h1>
	<table>
		<tr>
			<td>Numéro de série</td>
			<td>Photo</td>
			<td>Marque et modèle</td>
			<td>Description</td>
			<td>Prix (à la journée)</td>
			<td>Situé à l'agence</td>
			<td>Modification/Suppression</td>
		</tr>
<?php 
//DEBUT DE LA REQUETE 
$connect=connexion('sira');
$requete=$connect->prepare('SELECT * FROM vehicule AS v INNER JOIN agences AS a ON v.id_agence=a.id_agence   ');
$requete->execute();
while($donnees =$requete->fetch()){
	echo "<tr>
			<td> ". $donnees['id_vehicule'] . "</td>
			<td><img src='../img/voitures/" . $donnees['photoV'] . "' class='photoTab'></td>
			<td>" . $donnees['titreV'] ."</td>
			<td>". $donnees['descriptionV']."</td>
			<td>". $donnees['prix_journalier']." </td>
			<td>".$donnees['titreA']." </td>
			<td><a href=../pages/modif.php?idv=" . $donnees['id_vehicule'] .">Modifier</a>/<a href=../utility/suppr.php?idv=" . $donnees['id_vehicule'] .">Supprimer</a>
		</tr>";
}
?>
<table>
<!--  FIN DE L'AFFICHAGE DU TABLEAU DES VEHICULES DE LA BDD-->			

<!-- DEBUT DE L'AJOUT DE VEHICULE DANS LA BSS-->
	<h1>Ajoutez un véhicule</h1>
	<form method="post" action="" enctype="multipart/form-data">
		<fieldset>
		
			<label for="agence">Ajoutez votre agence</label>: 
			<select name="agence" id="agence">
						<option hidden disabled selected  value id="empty" >---</option>
						<?php listArticle("sira","agences","titreA"); ?>
			</select>
			<br><br>
			<label>Nom de la voiture</label>
			<input type="text" name="voiture">
			<br><br>
			<label>Marque</label>
			<input type="text" name="marque">
			<br><br>
			<label>Modèle</label>
			<input type="text" name="modele">
			<br><br>
			<label>Prix</label>
			<input type="text" name="prixj">
			<br><br>
			<label>Décrivez le véhicule</label>
			<input type="text" name="des">
			<br><br>
			<label>Ajoutez une photo</label>
			<br><br>
			<img id="blah" src="#" alt="Prévisualisation" />
			<input type="file" name="mfichier" id="imgInp" >
			<br><br>
			<input type="submit" name="envoyer">
		</fieldset>
	</form>
</body>
</html>
<?php include '../utility/picPreview.js';?>