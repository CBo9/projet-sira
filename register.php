<?php 
session_start();
require ('test.php');
require('navigation.php');
?>
<!DOCTYPE html>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="styleForm.css">
    <script type="text/javascript" src="cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

    <title>Inscirption à SuperQuiz</title>

   <link href="styleForm.css" rel="stylesheet" type="text/css"/>
    <link href="style.css" rel="stylesheet" type="text/css"/>
  </head>
  
  <body class="register-login-pages">
  
  <form action="" method="post" name="formulaire" id="formulaire">
			<fieldset>
				<legend>S'inscrire</legend>
					<label for="nom">Nom</label>: <input type="text" name="nom" id="nom" maxlength="25" placeholder="Nom" required ><br><br>
					<label for="prenom">Prénom</label>: <input type="text" name="prenom" id="prenom" maxlength="25" placeholder=" Prénom" required ><br><br>
					<label for="mail">Mail</label>:<input type="text" name="mail" id="mail" maxlength="35" placeholder="Mail" required ><br><br>
					<label for="mail">Pseudo</label>:<input type="text" name="pseudo" id="pseudo" maxlength="35" placeholder="Pseudo" required ><br><br>
					<label for="password">Mot de passe</label>:<input type="password" name="password" id="password" maxlength="35" placeholder="Mot de passe" required ><br><br>
					<input type="checkbox" onclick="myFunction('password')">Afficher mot de passe	
       <br><br>
					<input type="submit" value="Envoyer" id="envoyer">
					<br>
			<a  href="login.php" class="lien-redirection">Déjà inscrit? Connectez-vous ici!</a>
			</fieldset>
		  </form>
  <br><br>
  
<?php	

                  $nom=isset($_POST['nom']) ? $_POST['nom'] : NULL ;
                  $prenom=isset($_POST['prenom']) ? $_POST['prenom'] : NULL ;
                  $mail=isset($_POST['mail']) ? $_POST['mail'] : NULL ;
                  $pseudo=isset($_POST['pseudo']) ? $_POST['pseudo'] : NULL ;
                  $password=isset($_POST['password']) ? $_POST['password'] : NULL ;

if (isset($_COOKIE['id'])){
	header('Location:post.php');
}
			try
			{
				$connexion = new PDO("mysql:host=localhost;dbname=qcm;charset=utf8",'root', 'mysql');
				array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
			}
			catch(Exception $e)
			{
				echo 'Echec de la connexion:'.$e->getMessage();
			}  

		if ($nom!=NULL AND $prenom<>NULL AND $mail<>NULL AND $pseudo<>NULL AND $password<> NULL){

			
			if (requete($mail,'mail','qcm','profiles') != NULL){
				echo '<span class="erreur">Cette adresse email est déjà utilisée sur un autre compte.</span>';
			}
		    else if (requete($pseudo,'pseudo','qcm','profiles')!=NULL ){
		    	echo ' <span class="erreur"> Ce pseudo est déjà pris</span>';
		    }else{

		    	$db=connexion('qcm');
				$insertion=$db->prepare('INSERT INTO profiles ( nom, prenom, mail, pseudo, password )
																VALUES (:nom,:prenom,:mail,:pseudo,:password) ' );
				$insertion->execute([
							'nom'=>$nom,
							'prenom'=>$prenom,
						    'mail'=>$mail,
							'pseudo'=>$pseudo,
							'password'=>md5($password)]
								);
				header('Location: login.php');
			}
		}	
  /*requête selection*/
  
 /*$search_pseudo = isset($_POST['search_pseudo']) ? $_POST['search_pseudo'] : NULL;
 $search_password = isset($_POST['search_password']) ? $_POST['search_password'] : NULL;

 if ($search_pseudo!= NULL XOR $search_password!= NULL){
 	echo '<span class="erreur">Veuillez remplir les 2 champs svp!</span>';
 }
 else if ($search_pseudo!= NULL AND $search_password!= NULL)
 {
  $reponse=$connexion->prepare("SELECT * FROM login WHERE pseudo='$search_pseudo' AND password='$search_password' ");
  $reponse->execute (array ('pseudo'=>$search_pseudo , 'password'=>$search_password));
  $tour=0;

  while($donnees=$reponse->fetch())
  {
  	$_SESSION['id']=$donnees['id'];
  	echo donnees['nom'];
  	$_SESSION['nom']=$donnees['nom'];
  	$_SESSION['prenom']=$donnees['prenom'];
  	$_SESSION['tel']=$donnees['tel'];
  	$_SESSION['mail']=$donnees['mail'];
  	$_SESSION['pseudo']=$donnees['pseudo'];
  	$_SESSION['password']=$donnees['password'];
  	$tour+=1;
  	
  }
  if ($tour==0 ){
  	echo '<span class="erreur">Ce pseudo et ce mot de passe ne sont pas associés. Veuillez réessayer.</span>';

  }else if (isset($_SESSION['mail'])){
  	header('Location: post.php');
  }
  $reponse->closeCursor();
  }*/
  
  ?>
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
  </body>
  </html>