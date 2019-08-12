<?php
$titrePage='Modifictation des agences';
require('../templates/navbar.php');
require('../utility/fonctions.php');
//INSERTION DES NOUVELLES DONNES DANS LA BDD APRES REMPLISSAGE DU FORM
if(!isset($_SESSION['id']) OR $_SESSION['statut']!='admin'){
	header('location: ../index.php');
}
?>

<body>
<h1>Modifiez une agence</h1>
<h2>Administateur : <?= $_SESSION['prenom']?></h2>
	<form method="post" action="" enctype="multipart/form-data">
		<fieldset>
		
			<h1>Modifiez les informations liées à l'agence</h1>
	<form method="post" action="" enctype="multipart/form-data">
		<fieldset>
			<label>Nouveau nom de l'agence</label>
			<input type="text" name="nom_agence">
			<br><br>
			<label>Nouvelle adresse</label>
			<input type="text" name="adresse">
			<br><br>
			<label>code postal</label>
			<input type="text" name="cp">
			<br><br>
			<label>Ville</label>
			<input type="text" name="ville">
			<br><br>
			<label>Nouvelle description</label>
			<br><br>
			<textarea type="text" name="des"></textarea> 
			<br><br>
			<label>Ajoutez la nouvelle photo</label>
			<br><br>
			<input type="file" name="nfichier">
		
			<br><br>
			<input type="submit" name="envoyer">
		</fieldset>
	</form>
</body>
</html>

<?php

if (isset($_POST['envoyer'])) {
$agence = isset($_POST['nom_agence']) ? $_POST['nom_agence'] : NULL;
$adresse = isset($_POST['adresse']) ? $_POST['adresse'] : NULL;
$cp = isset($_POST['cp']) ? $_POST['cp'] : NULL;
$ville = isset($_POST['ville']) ? $_POST['ville'] : NULL;
$des = isset($_POST['des']) ? $_POST['des'] : NULL;
$id = $_GET['ida'];

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
            move_uploaded_file($_FILES['nfichier']['tmp_name'], '../img/agences/'. $date.basename($_FILES['nfichier']['name']));
            $image = $date . basename($_FILES['nfichier']['name']) ;
			$db=connexion('sira');
			$insert=$db->prepare("UPDATE agences SET titreA = '$agence', adresse = '$adresse',ville = '$ville',cp = '$cp', descriptionA = '$des', photoA = '$image' WHERE id_agence = '$id'");
							$insert->execute(['titreA'=>$agence,
											'adresse'=>$adresse,
											'ville'=>$ville,
											'cp'=>$cp,
											'descriptionA'=>$des,
											'photoA'=>$image]);
			
		}
	
	}

	else{

		echo "La modification n'a pas fonctionné ";
	}
}
}



  


  ?>