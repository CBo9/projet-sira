<?php
$titrePage="Localoc, les meilleurs voitures aux meileurs prix";
require('../templates/navbar.php');
require('../utility/fonctions.php'); ?>
<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
<h1>Bienvenue <?= $_SESSION['prenom']?></h1>

<?php  
if ($_SESSION['statut']== 'admin') {

		echo '<fieldset><a href=""> Gestion des membres</a><br>';
		echo '<a href="ajoutv.php"> Gestion des voiture</a><br>';
		echo '<a href="ajouta.php"> Gestion des agences</a></fieldset>';
	

}
?>
<div class="info" id="infojoueur">
  		<ul class="list-joueur">
  			<ol>
  				<?php 
  			echo "<br>";
	  		echo "<li><u>Login:</u> ".$_SESSION["pseudo"]."</li><br>";
	        echo "<li><u>Nom:</u> ".$_SESSION["nom"]."</li><br>";
	        echo"<li><u>Prénom:</u> ".$_SESSION["prenom"]."</li><br>";
	        echo"<li><u>Statut:</u> ".$_SESSION["statut"]."</li><br>";
	         
	         ?>
  			</ol>
  		</ul>
  	</div>

<form action="" method="post" name="formulaire" id="formulaire">
			<legend id="toggleUpdate">Modifier mes informations</legend>
			<fieldset id="updateToggle">
					 <label for="civilite">Civilité</label>: <select name="civil" id="civilite" >
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
    
					
<?php


					$nom=isset($_POST['nom']) ? $_POST['nom'] : NULL ;
	                $prenom=isset($_POST['prenom']) ? $_POST['prenom'] : NULL ;
	                $mail=isset($_POST['mail']) ? $_POST['mail'] : NULL ;
	                $pseudo=isset($_POST['pseudo']) ? $_POST['pseudo'] : NULL ;
	                $password=isset($_POST['password']) ? md5($_POST['password']): NULL ;
	                $civil=isset($_POST['civil']) ? ($_POST['civil']): $_SESSION['civilite'] ;
	                
	                $id= $_SESSION['id'];
	                
	               $connexion=connexion('sira');	
					 
					if ((requete($pseudo,'pseudo','sira','membres'))!=NULL AND ($pseudo!= $_SESSION['pseudo'])){
				    	echo ' <span class="erreur"> Ce pseudo est déjà pris</span>';
				    }else{

					if (isset($password) AND $password==$_SESSION['password']){
					if ($_POST['nv_password']!=NULL){
							$password=isset($_POST['nv_password']) ? md5($_POST['nv_password']) : NULL;
						}



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
			</fieldset>
</form>


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
        $("fieldset").slideToggle(750);
    });
});
</script>