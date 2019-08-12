<?php
$titrePage='Modifictation des informations';
require('../templates/navbar.php');
require('../utility/fonctions.php');
//INSERTION DES NOUVELLES DONNES DANS LA BDD APRES REMPLISSAGE DU FORM
if(!isset($_SESSION['id']) OR $_SESSION['statut']!='admin'){
	header('location: ../index.php');
}
?>

<body>
<h1>Modifiez un véhicule</h1>
<h2>Administateur : <?= $_SESSION['prenom']?></h2>
	<form method="post" action="" enctype="multipart/form-data">
		<fieldset>
		
			<label for="agence">Sélectionnnez le véhicule à modifier</label>:
			<br><br>
			<label>Modification de Nom de la voiture</label>
			<input type="text" name="voiture">
			<br><br>
			<label>Modification de la marque</label>
			<input type="text" name="marque">
			<br><br>
			<label>Modification du modèle</label>
			<input type="text" name="modele">
			<br><br>
			<label>Nouveau prix</label>
			<input type="text" name="prixj">
			<br><br>
			<label>Nouvelle description</label>
			<input type="text" name="des">
			<br><br>
			<label>Nouvelle photo</label>
			<br><br>
			<input type="file" name="nfichier">
		
			<br><br>
			<input type="submit" name="modif">
		</fieldset>
	</form>


</body>
</html>

<?php
$voiture = isset($_POST['voiture']) ? $_POST['voiture'] : NULL;
$marque = isset($_POST['marque']) ? $_POST['marque'] : NULL;
$modele = isset($_POST['modele']) ? $_POST['modele'] : NULL;
$des = isset($_POST['des']) ? $_POST['des'] : NULL;
$prixj = isset($_POST['prixj']) ? $_POST['prixj'] : NULL;
$id = $_GET['idv'];
if (isset($_POST['modif'])) {


	if (isset($_FILES['nfichier']) AND $_FILES['nfichier']['error'] == 0)  {


	if ($_FILES['nfichier']['size'] <= 1000000) {


		// Extentions autorisées
		$extension_autorisees = ["jpg", "jpeg", "png", "gif"];
		$info= pathinfo($_FILES['nfichier']['name']);
		
		// Extentions de notre fichier
		$extension_uploadee = $info['extension'];
		
		// On verifie l'extention
		if (in_array($extension_uploadee, $extension_autorisees)) {
			$date = date('m_d_Y_h_i_s', time());
            move_uploaded_file($_FILES['nfichier']['tmp_name'], '../img/voitures/'. $date.basename($_FILES['nfichier']['name']));
            $image = $date . basename($_FILES['nfichier']['name']) ;
			$db=connexion('sira');
			$insert=$db->prepare("UPDATE vehicule SET titreV = '$voiture', marque = '$marque', modele = '$modele', descriptionV = '$des', photoV = '$image' , prix_journalier = '$prixj' WHERE id_vehicule = '$id'");
							$insert->execute(['voiture'=>$voiture,
											'marque'=>$marque,
											'modele'=>$modele,
											'descriptionV'=>$des,
											'photoV'=>$image,
											'prix_journalier'=>$prixj]);
			
		}
	
	}

	else{

		echo "La modification n'a pas fonctionné ";
	}
}
}



  ?>