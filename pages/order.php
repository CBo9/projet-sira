<?php
$titrePage='Réservation';
require('../templates/navbar.php');
require('../utility/fonctions.php');

// ON RECUPERE L'"id"
$id=$_GET['id'];

// VARIABLE DATE
$datenow=date('Y-m-d');


// RECUPERATION DES DONNEES DANS LE BASE DE DONNEE
$connect= connexion('sira');
$req=$connect->prepare("SELECT * FROM vehicule AS v INNER JOIN agences AS a ON v.id_agence=a.id_agence  WHERE id_vehicule='$id'");
$req->execute();
$verif=0;
while($donnees = $req->fetch()){
	$ida=$donnees['id_agence'];
	$titre=$donnees['titreV'];
	$marque=$donnees['marque'];
	$modele=$donnees['modele'];
	$prixJ=$donnees['prix_journalier'];
	$descr=$donnees['descriptionV'];
	$image=$donnees['photoV'];
	$nomA=$donnees['titreA'];
	$adr=$donnees['adresse'];
	$ville=$donnees['ville'];
	$cp=$donnees['cp'];
	$descrA=$donnees['descriptionA'];
	$imageA=$donnees['photoA'];
	$statutVehicule=$donnees['statutV'];
	$verif++;
}
if($verif==0){
	header('location:error.php');
}

// FIN DE LA RECUPERATION

// INSERTION DE LA COMMANDE DANS LA BASE DE DONNEES 

if (isset($_POST['envoi'])) {
	$db=connexion('sira');
	$ins=$db->prepare('INSERT INTO commande (id_membre, id_vehicule, id_agence, date_depart, date_fin, prix_total) VALUES (:idm,:idv,:ida,:dd,:df,:pt)');
	$ins->execute(['idm' => $_SESSION['id'],
		'idv' =>$id,
		'ida' =>$ida,
		'dd'=>$_POST['dateD'],
		'df'=>$_POST['dateF'],
		'pt'=>$_POST['prixT']]);
	// FIN DE LA REQUETE D'INSERTION DANS LA TABLE COMMANDE
	$upd=$db->prepare("UPDATE vehicule SET statutV='non dispo' WHERE id_vehicule = '$id'");
	$upd->execute(['statutV'=>'non dispo']);
	$statutVehicule='non dispo';
}
?> 
<div class="wrapper">
	<h1 class="underTitle">Réserver une <?= $titre?></h1>

	<!-- AFFICHAGE DE L'INFORMATION DE LA VOITURE + AFFICHAGE -->
	<div class="infosCar">
		<img src="../img/voitures/<?= $image;?>" class='photOrder'>
		<div class="infos">
			<p><span class="soulign">Véhicule</span>: <?= ' ' . $titre; ?></p>
			<p><span class="soulign">Description:</span> <em><?= ' ' . $descr; ?></em></p>
			<p><span class="soulign">Prix journalier:</span> <?= ' ' . $prixJ; ?>€/jour</p>
		</div>

		<!-- AFFICHAGE DES INFORMATIONS DES AGENCES -->
		<div class="infosA">
			<fieldset>
				<img src="../img/agences/<?= $imageA;?>" class="photoTab2 photoTab">
				<p><span class="soulign">Agence:</span> <?= ' ' . $nomA;?></p>
				<p><?=$adr ;?></p>
				<p><?=$cp .' '.  $ville;?></p></div>
			</fieldset>
		</div>
		<!-- FIN AFFICHAGE INFORMATIONS DE L'AGENCE -->

		<!-- SECTION DE RESERVATION -->
		<div class="resa">
			<form method='post' name="formOrder">

				<!-- INPUT CACHE QUI RECUPERE LA VALEUR DU PRIX DU VEHICULE -->
				<input type="text" hidden name="prixT" id="pt" value="">
				<table id='tableRes'>
					<tr>
						<!-- INPUT POUR LA DATE DE DEBUT -->
						<td><label>Date de début de location</label></td>
						<td><input type="date"   oninput="datej(), calculer(<?=$prixJ ;?>)"  min="<?= $datenow;?>"  value="<?= $datenow;?>" name="dateD" id="dateD"></td>
					</tr>
					<tr>

						<!-- INPUT DE LA DATE DE FIN -->
						<td><label>Date de fin</label></td>
						<td><input type="date"  oninput="calculer(<?=$prixJ ;?>)"   min="<?= $datenow;?>" name="dateF" id="dateF"  ></td>
					</tr>

					
					<!-- LIEN POUR AFFICHER LE PRIX TOTAL -->	
					<tr>
						<?php if($statutVehicule!='dispo'){
							echo '<td><a id="resaBtnDisabled">Non disponible</a></td>';
						}
						?>
					</tr>

				</table>

				<p id="res"></p>
			</form>
		</div>
		<div class="push"></div>
	</div>
	<!-- FIN DE LA SECTION RESERVATION -->



	<script>

		


autoPlace
		
//FONCTION DE RECUPEARTION DE LA DATE 
function temps(date)
{
	var d = new Date(date[0],date[1]-1, date[2]);
	return d.getTime();
}

//FONCTION DE CALCUL DU PRIX AVEC LA VALEUR DE LA function 'temps'
function calculer(prixj){ 
	var date1=document.getElementById('dateD').value;
	var date2=document.getElementById('dateF').value;
	var dateD=date1.replace(/-/gi, '/');
	var dateF=date2.replace(/-/gi, '/');

	var debut = temps(dateD.split("/"));
	var fin = temps(dateF.split("/"));
var nb = (fin - debut) / (1000 * 60 * 60 * 24); // + " jours";
nb=Math.floor(nb);
nb++;
document.getElementById('res').innerHTML='Vous réservez pour ' + nb + ' jours: ' + (nb*prixj)+ '€.';


<?php if($statutVehicule=='dispo'):?>
	document.getElementById('res').innerHTML+= 
	<?php if(isset($_SESSION['id'])){
		echo '\'<input id="finalResBtn" type="submit" name="envoi" value="Confirmer">\'';
	}else{
		echo'\'<br><a href="login_register.php">Connectez-vous pour pouvoir réserver un véhicule</a>\'';
	}?>;
<?php endif;?>

document.getElementById('pt').value = nb*prixj;	
var date2=document.getElementById('dateF').value;
document.getElementById('dateD').max=date2;
} 

//FONCTION DE RESERVATION
function datej(){
	var date1=document.getElementById('dateD').value;
	document.getElementById('dateF').min=date1;
	document.getElementById('dateF').value=date1;
}

</script>

<?php
require($_SERVER['DOCUMENT_ROOT'] . '/projet_sira/templates/footer.php');
?>

