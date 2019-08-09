<?php
$titrepage = 'Gestion des membres';
require('../templates/navbar.php');
require('../utility/fonctions.php');

if (!isset($_SESSION['id']) OR $_SESSION['statut'] != 'admin') {
	header('location:../index.php');
}
  ?>




<body>
	<h1>Gestion des membres</h1>
	<table>
		<td>Id</td>
		<td>Nom</td>
		<td>Prénom</td>
		<td>Pseudo</td>
		<td>mail</td>
		<td>Type</td>
		<td>Statut</td>
	</table>

	<form action="" method="post" name="formulairead" id="formulairead">
      <fieldset>
        <legend>S'inscrire</legend>
          <label for="civilite">Civilité</label>: <select name="civilite" id="civilite" required>
            <option hidden disabled selected  value id="empty" >---</option>
            <option value="Mr">Mr</option>
            <option value="Mme">Mme</option>
          </select><br><br>

          <label for="nom">Nom</label>: <input type="text" name="nom" id="nom" maxlength="25" placeholder="Nom" required ><br><br>
          <label for="prenom">Prénom</label>: <input type="text" name="prenom" id="prenom" maxlength="25" placeholder=" Prénom" required ><br><br>
          <label for="pseudo">Pseudo</label>:<input type="text" name="pseudo" id="pseudo" maxlength="35" placeholder="Pseudo" required ><br><br>
          <label for="mail">Mail</label>:<input type="text" name="mail" id="mail" maxlength="35" placeholder="Mail" required ><br><br>
          <label for="password">Mot de passe</label>:<input type="password" name="password" id="password" maxlength="35" placeholder="Mot de passe" required ><br><br>

           <label for="type">Type</label>: <select name="type" id="type">
            <option hidden disabled selected  value id="empty" >---</option>
            <option value="pro">Professionnel</option>
            <option value="particulier">Particulier</option>
          </select><br><br>
           <label for="statut">Statut</label>: <select name="statut" id="statut">
            <option hidden disabled selected  value id="empty" >---</option>
            <option value="admin">Administrateur</option>
            <option value="client">Client</option>
          </select><br><br>

          <input type="checkbox" onclick="myFunction('password')">Afficher mot de passe 
       <br><br>
          <input type="submit" value="Envoyer" id="envoyer" name="register">
          <br>
    
      </fieldset>
      </form>
</body>
</html>


<?php
if (isset($_POST['register'])) {

$db=connexion('sira');
	$insert=$db->prepare('INSERT INTO membres (nom, prenom, civilite, pseudo, mail, statut, mdp, type ) VALUES(:nom, :prenom, :civilite, :pseudo, :mail, :statut, :mdp, :type)');
	$insert->execute(['nom'=>$_POST['nom'],
				  		'prenom' =>$_POST['prenom'],
				  		'civilite'=> $_POST['civilite'],
				  		'pseudo' => $_POST['pseudo'],
				  		'mail'=>$_POST['mail'],
				  		'statut'=>$_POST['statut'],
				  		'mdp'=>md5($_POST['password']),
				  		'type'=>$_POST['type']]);
	header('location:membre.php');
}
  ?>