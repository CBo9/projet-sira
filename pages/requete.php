<?php
$titrePage="Support";
// PAGE DU SUPPORT

require('../templates/navbar.php');
require('../utility/fonctions.php');
$idm = isset($_SESSION['id'])? $_SESSION['id'] :NULL;
if (isset($_GET['id'])) {
	$idr=$_GET['id'];
	$db=connexion('sira');
	$req=$db->prepare("SELECT * FROM support LEFT JOIN membres ON support.id_membre=membres.id WHERE id_requete='$idr'");
	$req->execute();
	$verif=0;
	while($data=$req->fetch()){
		$objet=$data['objet'];
		$mainRequest=$data['message'];
		$statut=$data['statutRep'];
		$verif+=1;
	}
		if($verif==0){
			header('location: error.php?error_supp=1');
		}
}else{
	header('location: error.php?error_supp=1');
}


?>

<h1>Requête N°<?= $idr;?> </h1>

<h2><?= $objet; ?></h2>

<div id='mainRequest'><?= $mainRequest; ?></div>


<?php
if (isset($_POST['envoiRep'])) {

$reponse=isset($_POST['reponse']) ? $_POST['reponse'] :NULL;
$insRep=$db->prepare('INSERT INTO reponse (id_requete, id_membre, pseudo, reponse)
				VALUES (:id_requete, :idm,:pseudo,:reponse) ' );
				$insRep->execute([
							'id_requete'=>$idr,
							'idm'=>$_SESSION['id'],
							'pseudo'=>$_SESSION['pseudo'],
						    'reponse'=>$reponse]
								);


$statutRep= $_SESSION['statut']=='admin' ? 'client' :'admin';
$statutRep=isset($_POST['resolved'])?'résolu': $statutRep;
$upd=$db->prepare("UPDATE support SET statutRep='$statutRep' WHERE id_requete='$idr'");
$upd->execute(['statutRep'=>$statutRep]);
}


$db=connexion('sira');
$req=$db->prepare("SELECT * FROM reponse INNER JOIN membres ON reponse.id_membre=membres.id WHERE id_requete='$idr' ORDER BY id_reponse ASC");
$req->execute();
while($aff =$req->fetch()){
	echo '<div class="rep';
	if($aff['statut']=='admin'){echo 'A';}else{echo 'U';}
	echo '">'
	. $aff['reponse'] . '</div>' ;


		}


if($statut!='résolu') :?>
<form method="post" action="">
	<label>Répondre</label>
	<br>
	<textarea name="reponse" ></textarea>
	<input type="submit" name="envoiRep">
	<input type="checkbox" id="resolved" name="resolved"><label for="resolved">Marqué comme résolu</label>
</form>

<?php endif; ?>