<?php
$titrePage="Support";
// PAGE DU SUPPORT

require('../templates/navbar.php');
require('../utility/fonctions.php');
$idm = $_SESSION['id'];

?>

<body class="support-page">
	<div class="wrapper">
<?php if($_SESSION['statut']='admin'){

	echo'<h1>Gestion des requetes</h1>
	<table id="supportadm">
    <thead>
    <tr>
  		<td>Id membre</td>
  		<td>Nom</td>
  		<td>Prénom</td>
  		<td>Pseudo</td>
  		<td>Email</td>
  		<td>Message</td>
    </tr>
    <thead>';




$connect=connexion('sira');
$requete=$connect->prepare('SELECT * FROM support');
$requete->execute();
while($donnees =$requete->fetch()){
	echo "<tr>
			<td> ". $donnees['id_membre'] . "</td>
			<td>" . $donnees['nom'] ."</td>
			<td>". $donnees['prenom']."</td>
			<td>". $donnees['pseudo']." </td>
			<td>".$donnees['mail']." </td>
			<td id='message'>".$donnees['message']." </td>
		</tr>";

}
echo '</table>';
}
  ?>




	
<div id="formulaire-support">

	<!-- DEBUT DU FORMULAIRE -->
	<form  name="formulaire" method="post" action="">
	<fieldset>
		<legend>Envoyer une requête au support</legend>
					<label for="nom">Nom</label>: <input type="text" name="nom" id="nom" maxlength="25"  required ><br><br>
					<label for="prenom">Prénom</label>: <input type="text" name="prenom" id="prenom" maxlength="25"  required ><br><br>
					<label for="mail">Mail</label>:<input type="text" name="mail" id="mail" maxlength="35"  required class="mail-form-support" ><br><br>
					<label for="pseudo">Pseudo</label>:<input type="text" name="pseudo" id="pseudo" maxlength="35"  required ><br><br>
					<label for="message">Message</label>:<br><textarea type="text" name="message" id="message" maxlength="300"  required  placeholder="Décrivez votre question ou votre problème du mieux que possible. Francais et anglais acceptés." class="font-placeholder"></textarea> <br><br>
				    
       				<br><br>

       				<input type="submit" name="envoyer" value="Envoyer ma demande">
      </fieldset>
</form>
<!-- FIN DU FORMULAIRE -->

</div>


<!-- DEBUT DU CODE PHP -->
<?php 

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
<!-- FIN DU CODE PHP -->
<div class="push"></div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>

<!-- DEBUT DU CODE PHP -->
<?php 

$idm = $_SESSION['id'];
// REQUETE DE L'INSERTION DU LESSAGE DANS LA BASE DE DONNEE
	$id_membre = isset($_SESSION['id']) ? $_SESSION['id'] : $idm;
	$nom=isset($_POST['nom']) ? $_POST['nom'] : NULL ;
	$prenom=isset($_POST['prenom']) ? $_POST['prenom'] : NULL ;
	$mail=isset($_POST['mail']) ? $_POST['mail'] : NULL ;
	$pseudo=isset($_POST['pseudo']) ? $_POST['pseudo'] : NULL ;
	$message=isset($_POST['message']) ? $_POST['message'] : NULL ;


	/*if ($nom!=NULL AND $prenom<>NULL AND $tel<>NULL AND $mail<>NULL AND $pseudo<>NULL AND $message<> NULL){*/
		if (isset($_POST['envoyer'])) {
			
		    	$db=connexion('sira');
				$insertion=$db->prepare('INSERT INTO support (id_membre, nom, prenom, mail, pseudo, message )
				VALUES (:id_membre, :nom,:prenom,:mail,:pseudo,:message) ' );
				$insertion->execute([
							'id_membre'=>$idm,
							'nom'=>$nom,
							'prenom'=>$prenom,
						    'mail'=>$mail,
							'pseudo'=>$pseudo,
							'message'=>$message]
								);
			}
			//FIN DE REQUETE D'INSERTION
		require($_SERVER['DOCUMENT_ROOT'] . '/projet_sira/templates/footer.php');		
?>

			
		