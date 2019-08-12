<?php
$titrePage='Modifictation des agences';
require('../templates/navbar.php');
require('../utility/fonctions.php');
//INSERTION DES NOUVELLES DONNES DANS LA BDD APRES REMPLISSAGE DU FORM
if(!isset($_SESSION['id']) OR $_SESSION['statut']!='admin'){
	header('location: ../index.php');
}

$id=$_GET['ida'];
$connect= connexion('sira');
$req=$connect->prepare("SELECT * FROM agences WHERE id_agence='$id'");
$req->execute();
while($donnees = $req->fetch()){
	$titre=$donnees['titreA'];
	$adr=$donnees['adresse'];
	$ville=$donnees['ville'];
	$cp=$donnees['cp'];
	$descr=$donnees['descriptionA'];
	$image=$donnees['photoA'];
}
?>

<body>
	<h1>Modifiez une agence</h1>
	<h2>Administateur : <?= $_SESSION['prenom']?></h2>
	

	<h1>Modifiez les informations liées à l'agence</h1>
	<form method="post" action="" enctype="multipart/form-data">
		<fieldset>
			<label>Nouveau nom de l'agence</label>
			<input type="text" name="nom_agence" value="<?= $titre;?>">
			<br><br>
			<label>Nouvelle adresse</label>
			<input type="text" name="adresse" value="<?= $adr;?>">
			<br><br>
			<label>code postal</label>
			<input type="text" name="cp"  value="<?= $cp;?>">
			<br><br>
			<label>Ville</label>
			<input type="text" name="ville"  value="<?= $ville;?>">
			<br><br>
			<label>Nouvelle description</label>
			<br><br>
			<textarea type="text" name="des"><?= $descr;?></textarea> 
			<br><br>
			<img class='photoTab' src="../img/agences/<?= $image?>"> <em>Photo actuelle</em><br><br>
			<label>Ajoutez la nouvelle photo</label>
			<br><br>
			<img id="blah" src="#" alt="Prévisualisation" />
			<input type="file" name="nfichier" id="imgInp" >
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
				unlink('../img/agences/' . $image );
				$image = $date . basename($_FILES['nfichier']['name']) ;	
			}

		}

		else{

			echo "La photo est trop large ";
		}
	}
	$db=connexion('sira');
	$insert=$db->prepare("UPDATE agences SET titreA = '$agence', adresse = '$adresse',ville = '$ville',cp = '$cp', descriptionA = '$des', photoA = '$image' WHERE id_agence = '$id'");
	$insert->execute(['titreA'=>$agence,
		'adresse'=>$adresse,
		'ville'=>$ville,
		'cp'=>$cp,
		'descriptionA'=>$des,
		'photoA'=>$image]);
		header('location:ajouta.php');
}
include '../utility/picPreview.js';
?>