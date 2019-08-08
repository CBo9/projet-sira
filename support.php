<?php
session_start();
require('navigation.php');
require('test.php');

?>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	
</head>
<body class="support-page">
<div id="formulaire-support">
<form  name="formulaire" method="post" action="">
	<fieldset>
	<legend>Envoyer une requête au support</legend>
					<label for="nom">Nom</label>: <input type="text" name="nom" id="nom" maxlength="25"  required ><br><br>
					<label for="prenom">Prénom</label>: <input type="text" name="prenom" id="prenom" maxlength="25"  required ><br><br>
					<label for="mail">Mail</label>:<input type="text" name="mail" id="mail" maxlength="35"  required class="mail-form-support" ><br><br>
					<label for="pseudo">Pseudo</label>:<input type="text" name="pseudo" id="pseudo" maxlength="35"  required ><br><br>
					<label for="message">Message</label>:<textarea type="text" name="message" id="message" maxlength="300"  required  placeholder="Décrivez votre question ou votre problème du mieux que possible. Francais et anglais acceptés." class="font-placeholder"></textarea> <br><br>
				    
       				<br><br>

       				<input type="submit" name="envoyer" value="Envoyer ma demande">
      </fieldset>
</form>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
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

</body>

<?php 
$nom=isset($_POST['nom']) ? $_POST['nom'] : NULL ;
	                $prenom=isset($_POST['prenom']) ? $_POST['prenom'] : NULL ;
	                $mail=isset($_POST['mail']) ? $_POST['mail'] : NULL ;
	                $pseudo=isset($_POST['pseudo']) ? $_POST['pseudo'] : NULL ;
	                $message=isset($_POST['message']) ? $_POST['message'] : NULL ;


	/*if ($nom!=NULL AND $prenom<>NULL AND $tel<>NULL AND $mail<>NULL AND $pseudo<>NULL AND $message<> NULL){*/
		if (isset($_POST['envoyer'])) {
			
		    	$db=connexion('qcm');
				$insertion=$db->prepare('INSERT INTO support (id_customer, nom, prenom, email, pseudo, message )
																VALUES (:idcustom, :nom,:prenom,:mail,:pseudo,:message) ' );
				$insertion->execute([
							'idcustom'=>$_SESSION['id'],
							'nom'=>$nom,
							'prenom'=>$prenom,
						    'mail'=>$mail,
							'pseudo'=>$pseudo,
							'message'=>$message]
								);
			}
				
?>
			
		