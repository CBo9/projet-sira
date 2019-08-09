<?php
require('../templates/navbar.php');
require('../utility/fonctions.php');
//INSERTION DES NOUVELLES DONNES DANS LA BDD APRES REMPLISSAGE DU FORM

if (isset($_POST['envoyer'])) {


if (isset($_FILES['mfichier']) AND $_FILES['mfichier']['error'] == 0)  {


	if ($_FILES['mfichier']['size'] <= 1000000) {


		// Extentions autorisées
		$extension_autorisees = ["jpg", "jpeg", "png", "gif"];
		$info= pathinfo($_FILES['mfichier']['name']);
		
		// Extentions de notre fichier
		$extension_uploadee = $info['extension'];
		
		// On verifie l'extention
		if (in_array($extension_uploadee, $extension_autorisees)) {
			
			move_uploaded_file($_FILES['mfichier']['tmp_name'], '../img/' .basename($_FILES['mfichier']['name']));
			$image = basename($_FILES['mfichier']['name']);
			$db=connexion('sira');
			$insert=$db->prepare('INSERT INTO vehicule (titre, marque, modele, description, photo, prix_journalier) VALUES(:voiture, :marque, :modele, :des, :mfichier, :prixj)');
							$insert->execute(['voiture'=>$_POST['voiture'],
				  							  'marque' =>$_POST['marque'],
				  							  'modele'=> $_POST['modele'],
				  							  'des' => $_POST['des'],
				  							'mfichier'=>$image,
				  							'prixj'=>$_POST['prixj']]);
			
		}
	
	}

	else{

		echo "Votre fichier est trop volumineux!!! ";
	}
}
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="">
	<title>Ajouter un véhicule</title>
</head>
<body id="page_ajouta">


<!--  DEBUT DE L'AFFICHAGE DU TABLEAU DES VEHICULES DE LA BDD-->	
	<h1>Nos véhicules</h1>
	<table>
		<tr>
			<td>Numéro de série</td>
			<td>Photo</td>
			<td>Marque</td>
			<td>Modèle</td>
			<td>Description</td>
			<td>Prix (à la journée)</td>
			<td>Situé à l'agence</td>
		</tr>
<?php 
//DEBUT DE LA REQUETE 
$connect=connexion('sira');
$requete=$connect->prepare('SELECT * FROM vehicule AS v ');
$requete->execute();
while($donnees =$requete->fetch()){
	echo "<tr>
			<td> ". $donnees['id_vehicule'] . "</td>
			<td><img src='../img/" . $donnees['photo'] . "' class='photoTab'></td>
			<td>" . $donnees['marque'] ."</td>
			<td>" . $donnees['modele'] ."</td>
			<td>". $donnees['description']."</td>
			<td>". $donnees['prix_journalier']." </td>
			<td>".$donnees['id_agence']." </td>
		</tr>";
}
?>
<table>
<!--  FIN DE L'AFFICHAGE DU TABLEAU DES VEHICULES DE LA BDD-->			

<!-- DEBUT DE L'AJOUT DE VEHICULE DANS LA BSS-->
	<h1>Ajoutez un véhicule</h1>
	<form method="post" action="" enctype="multipart/form-data">
		<fieldset>
			<label>Ajoutez votre agence</label>
			<input type="text" name="agence">
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
			<input type="file" name="mfichier">
		
			<br><br>
			<input type="submit" name="envoyer">
		</fieldset>
	</form>
</body>
</html>

