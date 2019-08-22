<?php
$titrePage="Localoc, les meilleurs voitures aux meileurs prix";
require('../templates/navbar.php');
require('../utility/fonctions.php'); ?>
<head>
<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
</head>

<!-- PAGE "profile" -->
<div class="wrapper">
<h1 class="underTitle">Bienvenue <?= $_SESSION['prenom']?></h1>

<!-- AFFICHAGE SPECIFIQUE AU ADMINISTRATEUR -->
<?php  
if ($_SESSION['statut']== 'admin') {

		echo '<fieldset class="administration"><a href="membre.php"> Gestion des membres</a><br>';
		echo '<a href="ajoutv.php"> Gestion des voitures</a><br>';
		echo '<a href="ajouta.php"> Gestion des agences</a></fieldset>';

}
?>
<!-- FIN DE L'AFFICHAGE ADMINISTRATEUR -->


<!-- AFFICHAGE DES INFORMATION DE L'UTILISATEUR -->

<div class="info" id="infojoueur">
  		<ul class="list-joueur">
  			<?php 
  			echo "<br>";
	  		echo "<li><u><i>Login:</i></u> ".$_SESSION["pseudo"]."</li><br>";
	        echo "<li><u><i>Nom:</i></u> ".$_SESSION["nom"]."</li><br>";
	        echo"<li><u><i>Prénom:</i></u> ".$_SESSION["prenom"]."</li><br>";
	        echo"<li><u><i>Statut:</i></u> ".$_SESSION["statut"]."</li><br>";
	        ?>
<!-- FIN DE L'AFFICHAGE DES INFORMATION DE L'UTILISATEUR -->
	<form action="" method="post" name="formulaire" id="formprof">
			<legend id="toggleUpdate"><u><i>Modifier mes informations</i></u> </legend>
			<div id="slideDown">
					<label for="civilite">Civilité</label>: 
					<select name="civil" id="civilite" >
					   <option hidden disabled selected  value id="empty" >---</option>
					   <option value="Mr">Mr</option>
					   <option value="Mme">Mme</option>
					</select><br><br>
					<label for="nom">Nom</label>: <input type="text" name="nom" id="nom" maxlength="25"  required ><br><br>
					<label for="prenom">Prénom</label>: <input type="text" name="prenom" id="prenom" maxlength="25"  required ><br><br>
					<label for="mail">Mail</label>:<input type="text" name="mail" id="mail" maxlength="35"  required ><br><br>
					<label for="mail">Pseudo</label>:<input type="text" name="pseudo" id="pseudo" maxlength="35"  required ><br><br>
					<label for="mail">Mot de passe</label>:<input type="password" name="password" id="password" maxlength="35" required ><br>
					<input type="checkbox" class="show_password_up" onclick="myFunction('password')" title="Afficher le mot de passe">
					<br> 
					
					<label for="mail">Nouveau mot de passe (optionnel)</label>:<input type="password" name="nv_password" id="nv_password" maxlength="35"  ><br>
					
					 <input type="checkbox" class="show_password_up" onclick="myFunction('nv_password')" title="Afficher le mot de passe"><br>
       <br><br>
<!-- FIN DU FORMULAIRE DE MODIFICATIONS -->

<!-- DEBUT DU CODE PHP -->
<?php

// DECALARATION DES VARIABLES
$nom=isset($_POST['nom']) ? $_POST['nom'] : NULL ;
$prenom=isset($_POST['prenom']) ? $_POST['prenom'] : NULL ;
$mail=isset($_POST['mail']) ? $_POST['mail'] : NULL ;
$pseudo=isset($_POST['pseudo']) ? $_POST['pseudo'] : NULL ;
$password=isset($_POST['password']) ? md5($_POST['password']): NULL ;
$civil=isset($_POST['civil']) ? ($_POST['civil']): $_SESSION['civilite'] ;
$id= $_SESSION['id'];

// CONNEXION A LA BASE DE DONNEE
$connexion=connexion('sira');

//VERIFICATION DU PSEUDO  
if ((requete($pseudo,'pseudo','sira','membres'))!=NULL AND ($pseudo!= $_SESSION['pseudo'])){
	echo ' <span class="erreur"> Ce pseudo est déjà pris</span>';
				    }else{

if (isset($password) AND $password==$_SESSION['password']){
	if ($_POST['nv_password']!=NULL){
	$password=isset($_POST['nv_password']) ? md5($_POST['nv_password']) : NULL;
						}


						// MISE A JOUR DES DONNEES DE L'UTILISATEUR
					$req= $connexion->prepare("UPDATE membres SET nom= '$nom', prenom='$prenom',mail= '$mail',pseudo= '$pseudo',mdp= '$password',civilite='$civil'  WHERE id ='$id'");
					$req->execute(array(
						'nom' => $nom,
						'prenom' => $prenom,
						'mail' => $mail,
						'pseudo' => $pseudo,
						'mdp' => $password,
						'civilite' => $civil,

						));
				  	$_SESSION['nom']=$nom;
				  	$_SESSION['prenom']=$prenom;
				  	$_SESSION['mail']=$mail;
				  	$_SESSION['pseudo']=$pseudo;
				  	$_SESSION['password']=$password;
				  	$_SESSION['civilite']=$civil;
					echo '<span class="success">Vos informations ont été modifiées avec succès</span>';
					
					}else if (isset($password))
					{
					echo '<span class="erreur">mot de passe incorrect</span>';
					}
				}
			?>

					<input type="submit" value="Modifier " id="modifier">
			</div>
		</form>
	</ul>
</div>

<!--  DEBUT DE L'AFFICHAGE DU TABLEAU DES VEHICULES DE LA BDD-->

	
	<table class="order">
	<h1>Mes commandes</h1>
	<thead>
		<tr>
			<td>Numéro de commande</td>
			<td>véhicule</td>
			<td>Agence</td>
			<td>Début de location</td>
			<td>Fin de location</td>
			<td>Statut</td>
			<td>Supprimer la commande</td>
		</tr>
	</thead>
<!-- FIN DE L'AFFICHAGE DES VEHICULE -->


<!-- DEBUT DE L'AFFICHAGE DES COMMANDES -->
<?php
$idm = $_SESSION['id'];
$connect=connexion('sira');
$requete=$connect->prepare("SELECT * FROM commande  AS c INNER JOIN agences AS a ON c.id_agence=a.id_agence INNER JOIN vehicule AS v on c.id_vehicule = v.id_vehicule WHERE id_membre = '$idm'");
$requete->execute();
while($donnees =$requete->fetch()){
	echo "<tr>
			<td> ". $donnees['id_commande'] . "</td>
			<td><img src='../img/voitures/" . $donnees['photoV'] . "' class='photoTab'>" . $donnees['titreV'] ."</td>
			<td>". $donnees['titreA']."</td>
			<td>". $donnees['date_depart']." </td>
			<td>".$donnees['date_fin']." </td>
			<td>" .$donnees['statutC']. "</td>
			<td><a href=../utility/suppr.php?idc=" . $donnees['id_commande'] .">Supprimer</a>
		</tr>";
}
// FIN DE L'AFFICHAGE DU TABLEAU



  ?>
</table>
<div class="push"></div>
</div>


<script>
    
    $( document ).ready(function() {
        $("#nom").val('<?php echo $_SESSION['nom']; ?>');
        $("#prenom").val('<?php echo $_SESSION['prenom']; ?>');
        $("#mail").val('<?php echo $_SESSION['mail']; ?> ');
        $("#pseudo").val('<?php echo $_SESSION['pseudo']; ?>');
        });
        
</script>
 <script type="text/javascript">
  function myFunction($var) {
  var x = document.getElementById($var);
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
<script>
$(function() {
    $("legend").click(function() {
        $("#slideDown").slideToggle(750);
    });
});
</script>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/projet_sira/templates/footer.php'); ?>