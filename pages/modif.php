<?php
$titrePage='Modification des informations';
require('../templates/navbar.php');
require('../utility/fonctions.php');

//INSERTION DES NOUVELLES DONNES DANS LA BDD APRES REMPLISSAGE DU FORM
if(!isset($_SESSION['id']) OR $_SESSION['statut']!='admin'){
	header('location: ../index.php');
}
if(!isset($_GET['idv'])){
	header('location: ajoutv.php');
}



// RECUPERATION DES DONNEES DES VEHICULE
$id=$_GET['idv'];
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
}

?>

<!-- FORMULAIRE DE MODIFICATION -->
<body class="adPg"> 
	<h1 class="underTitle">Modifiez un véhicule</h1>
	<h2>Administateur : <?= $_SESSION['prenom']?></h2>
	<form method="post" action="" enctype="multipart/form-data">
		<fieldset>
			<label for="agence">Ajoutez votre agence</label>: 
			<select name="agence" id="agence">
				<option hidden disabled selected  value id="empty" >---</option>
				<?php listArticle2("sira","agences","titreA",""); ?>
			</select>   <em>Agence actuelle: <?= $nomA ?></em>
			<br><br>
			<label>Modification du nom de la voiture</label>
			<input type="text" name="voiture" value="<?= $titre?>" >
			<br><br>
			<label>Modification de la marque</label>
			<input type="text" name="marque" value="<?= $marque?>">
			<br><br>
			<label>Modification du modèle</label>
			<input type="text" name="modele" value="<?= $modele?>">
			<br><br>
			<label>Nouveau prix</label>
			<input type="text" name="prixj" value="<?= $prixJ?>">
			<br><br>
			<label>Nouvelle description</label><br>
			<textarea type="text" name="des" ><?= $descr?></textarea>
			<br><br>
			<img class='photoTab' src="../img/voitures/<?= $image?>"> <em>Photo actuelle</em><br><br>
			<label>Nouvelle photo</label>
			<br><br>
			<img id="blah" src="#" alt="Prévisualisation" />
			<input type="file" name="nfichier" id="imgInp" >
			<br><br>
			<input type="submit" name="modif" >
		</fieldset>
	</form>
	<!-- FIN DU FORMULAIRE DE MODIFICATION -->


</body>
</html>

<!-- DEBUT DU CODE PHP -->
<?php

// DECLARATION DES VARIABLES
$agence= isset($_POST['agence']) ? $_POST['agence'] : $ida;
$voiture = isset($_POST['voiture']) ? $_POST['voiture'] : NULL;
$marque = isset($_POST['marque']) ? $_POST['marque'] : NULL;
$modele = isset($_POST['modele']) ? $_POST['modele'] : NULL;
$des = isset($_POST['des']) ? $_POST['des'] : NULL;
$prixj = isset($_POST['prixj']) ? $_POST['prixj'] : NULL;

// ENVOI DE DONNEES
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
				unlink('../img/voitures/' . $image );
				$image = $date . basename($_FILES['nfichier']['name']) ;


			}

		}

		else{

			echo "La photo est trop large ";
		}
	}

	// REQUETE DE MISE A JOUR
	$db=connexion('sira');
	$insert=$db->prepare("UPDATE vehicule SET id_agence='$agence', titreV = '$voiture', marque = '$marque', modele = '$modele', descriptionV = '$des', photoV = '$image' , prix_journalier = '$prixj' WHERE id_vehicule = '$id'");
	$insert->execute(['id_agence'=>$agence,
		'voiture'=>$voiture,
		'marque'=>$marque,
		'modele'=>$modele,
		'descriptionV'=>$des,
		'photoV'=>$image,
		'prix_journalier'=>$prixj]);
	header('location:ajoutv.php');
}
// FIN DE REQUETE


include '../utility/picPreview.js';
?>
