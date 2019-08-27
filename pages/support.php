<?php
$titrePage="Support";
// PAGE DU SUPPORT

require('../templates/navbar.php');
require('../utility/fonctions.php');
$idm = isset($_SESSION['id'])? $_SESSION['id'] :NULL;

?>

<body class="support-page">
	<div class="wrapper">
<?php
$statut=isset($_SESSION['statut'])?$_SESSION['statut']:NULL;
 if($statut=='admin'){

	echo'<h1>Gestion des requetes</h1>
	<table id="supportadm">
    <thead>
    <tr>
		<td>Numéro de commande</td>
    	<td>Dernier ajout</td>
  		<td>Id membre</td>
  		<td>Nom</td>
  		<td>Prénom</td>
  		<td>Email</td>
  		<td>Objet</td>		
    </tr>
    </thead>';

$connect=connexion('sira');
$requete=$connect->prepare('SELECT * FROM support ORDER BY statutRep, dateDebut ASC ');
$requete->execute();
while($donnees =$requete->fetch()){
	echo "<tr ";
	if($donnees['statutRep']=='résolu'){
		echo 'class="resolvedLine"';
	}
	echo ">
			<td>" . $donnees['id_requete'] . "</td>
			<td>";
			$idr=$donnees['id_requete'];

$lastrep=$connect->prepare("SELECT * FROM reponse WHERE id_requete = '$idr'");
$lastrep->execute();
$verif=0;
while ($affRep=$lastrep->fetch()) {
	$verif+=1;
	$heure=$affRep['dateHeure'];
}
if ($verif!=0) {
	echo $heure;
}else{
	echo $donnees['dateDebut'];
}
	        echo"</td>
			<td>". $donnees['id_membre'] . "</td>
			<td>" . $donnees['nom'] ."</td>
			<td>". $donnees['prenom']."</td>
			<td>".$donnees['mail']." </td>
			<td>".$donnees['objet']." </td>
			<td class='rep'><a href='requete.php?id=" .$donnees['id_requete'] . "'><span class='arrow'>→</span></a></td>
		</tr>";

}
echo '</table>';
}else{
  ?>





	
<div id="formulaire-support">

	<!-- DEBUT DU FORMULAIRE -->
	<form  name="formulaire" method="post" action="">
	<fieldset>
		<legend>Envoyer une requête au support</legend>
					<label for="nom">Nom</label>: <input type="text" name="nom" id="nom" maxlength="25"  required value=""><br><br>
					<label for="prenom">Prénom</label>: <input type="text" name="prenom" id="prenom" maxlength="25"  required value=""><br><br>
					<label for="mail">Mail</label>:<input type="text" name="mail" id="mail" maxlength="35"  required class="mail-form-support" value=""><br><br>
					<label for="objet">Objet</label>:<input type="text" name="objet" id="objet" maxlength="35"  required placeholder="35 caractères max"><br><br>
					<label for="message">Message</label>:<br><textarea type="text" name="message" id="message" maxlength="300"  required  placeholder="Décrivez votre question ou votre problème du mieux que possible. Francais et anglais acceptés." class="font-placeholder"></textarea> <br><br>
				    
       				<br><br>

       				<input type="submit" name="envoyer" value="Envoyer ma demande">
      </fieldset>
</form>
<!-- FIN DU FORMULAIRE -->

</div>
<div class="push"></div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>

<!-- DEBUT DU CODE PHP -->
<?php 
// REQUETE DE L'INSERTION DU LESSAGE DANS LA BASE DE DONNEE
	$id_membre = isset($_SESSION['id']) ? $_SESSION['id'] : $idm;
	$nom=isset($_POST['nom']) ? $_POST['nom'] : NULL ;
	$prenom=isset($_POST['prenom']) ? $_POST['prenom'] : NULL ;
	$mail=isset($_POST['mail']) ? $_POST['mail'] : NULL ;
	$objet=isset($_POST['objet']) ? $_POST['objet'] : NULL ;
	$message=isset($_POST['message']) ? $_POST['message'] : NULL ;


	/*if ($nom!=NULL AND $prenom<>NULL AND $tel<>NULL AND $mail<>NULL AND $pseudo<>NULL AND $message<> NULL){*/
		if (isset($_POST['envoyer'])) {
			
		    	$db=connexion('sira');
				$insertion=$db->prepare('INSERT INTO support (id_membre, nom, prenom, mail, objet, message )
				VALUES (:id_membre, :nom,:prenom,:mail,:objet,:message) ' );
				$insertion->execute([
							'id_membre'=>$idm,
							'nom'=>$nom,
							'prenom'=>$prenom,
						    'mail'=>$mail,
							'objet'=>$objet,
							'message'=>$message]
								);
			}
			//FIN DE REQUETE D'INSERTION
		require($_SERVER['DOCUMENT_ROOT'] . '/projet_sira/templates/footer.php');	
		}	
		

if (isset($_SESSION['id'])){
	echo "
<script>
    $( document ).ready(function() {
        $(\"#nom\").val('". $_SESSION['nom'] . "');
        $(\"#prenom\").val('".  $_SESSION['prenom']. "');
        $(\"#mail\").val('" .  $_SESSION['mail']. " ');
        $(\"#pseudo\").val('". $_SESSION['pseudo']. "');
        });
</script>";
}
?>