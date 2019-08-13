<?php
$titrePage='Modification des informations liées l\'inscription';
require('../templates/navbar.php');
require('../utility/fonctions.php');
//INSERTION DES NOUVELLES DONNES DANS LA BDD APRES REMPLISSAGE DU FORM
if(!isset($_SESSION['id']) OR $_SESSION['statut']!='admin'){
	header('location: ../index.php');
}
if(!isset($_GET['idm'])){
	header('location: membre.php');
}


$id=$_GET['idm'];
$connect= connexion('sira');
$req=$connect->prepare("SELECT * FROM membres WHERE id='$id'");
$req->execute();
while($donnees = $req->fetch()){
	$nom=$donnees['nom'];
	$prenom=$donnees['prenom'];
	$pseudo=$donnees['pseudo'];
	$mail=$donnees['mail'];
	$mdp=$donnees['mdp'];
	$statut=$donnees['statut'];
	$type=$donnees['type'];
	$civil=$donnees['civilite'];

}
?>


<body>
	<h2>Administateur : <?= $_SESSION['prenom']?></h2>
	<h1>Modifiez les informations</h1>
	<form method="post" >
		<fieldset>
          <label for="civilite">Civilité</label>: <select name="civilite" id="civilite">
            <option hidden disabled selected  value id="empty" ><?=$civil?></option>
            <option value="Mr">Mr</option>
            <option value="Mme">Mme</option>
          </select>
			<br><br>
			<label>Modifiez le nom </label>
			<input type="text" name="nom" value="<?=$nom;?>" >
			<br><br>
			<label>Modifiez le prénom</label>
			<input type="text" name="prenom" value="<?=$prenom;?>">
			<br><br>
			<label>Modifiez le pseudo</label>
			<input type="text" name="pseudo" value="<?=$pseudo;?>">
			<br><br>
			<label>modifiez le mail</label>
			<input type="text" name="mail" value="<?=$mail;?>">
			<br><br>
			<label>modifiez le mot de passe</label>
			<input type="text" name="mdp">
			<br><br>
			<label for="type">Changement de type</label>: 
			<select name="type" id="type">
            	<option hidden disabled selected  value id="empty" ><?=$statut?></option>
            	<option value="pro">Professionnel</option>
            	<option value="particulier">Particulier</option>
          	</select><br><br>
          	<label for="statut">Changement de statut</label>: 
          	<select name="statut" id="statut">
            	<option hidden disabled selected  value id="empty" ><?=$type?></option>
            	<option value="admin">Administrateur</option>
            	<option value="client">Client</option>
          	</select><br><br>
			<br><br>
			<input type="submit" name="modifier" >
		</fieldset>
	</form>

<?php


$civilite= isset($_POST['civilite']) ? $_POST['civilite'] : $civil;
$nom= isset($_POST['nom']) ? $_POST['nom'] :NULL;
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : NULL;
$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : NULL;
$mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;
$mdp = isset($_POST['mdp']) ? md5($_POST['mdp']) : $mdp;
$type = isset($_POST['type']) ? $_POST['type'] : $type;
$statut = isset($_POST['statut']) ? $_POST['statut'] : $statut;



if (isset($_POST['modifier'])) {

	$db=connexion('sira');
	$insert=$db->prepare("UPDATE membres SET civilite = '$civilite', nom='$nom', prenom = '$prenom', pseudo = '$pseudo', mail = '$mail', mdp = '$mdp', statut = '$statut' , type = '$type' WHERE id = '$id'");
	$insert->execute([
		'civilite'=>$civilite,
		'nom'=>$nom,
		'prenom'=>$prenom,
		'pseudo'=>$pseudo,
		'mail'=>$mail,
		'mdp'=>$mdp,
		'statut'=>$statut,
		'type'=>$type]);

header('location: membre.php'); 
}





?>
