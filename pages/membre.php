<?php
$titrePage = 'Gestion des membres';
require('../templates/navbar.php');
require('../utility/fonctions.php');

// SI LE STATUT EST DIFFERENT DE "admin"
if (!isset($_SESSION['id']) OR $_SESSION['statut'] != 'admin') {
	header('location:../index.php');
}
?>

<?php

// VALIDATION DU FORMULAIRE D'INSCRIPTION
if (isset($_POST['register'])) {

// INSERTION DANS LA BASE DE DONNEE
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

<!-- TABLEAU POUR L'AFFICHAGE DES MEMBRES -->
<body>
	<h1>Gestion des membres</h1>
	<table>
    <tr>
  		<td>Id membre</td>
  		<td>Nom</td>
  		<td>Prénom</td>
  		<td>Pseudo</td>
  		<td>Email</td>
  		<td>Type</td>
  		<td>Statut</td>
      <td>Modification/Suppression</td>
    </tr>

    <?php 

    //DEBUT DE LA REQUETE 
    $connect=connexion('sira');
    $requete=$connect->prepare('SELECT * FROM membres');
    $requete->execute();
    while($donnees =$requete->fetch()){
      // AFFICHAGE DE DONNEES DANS LE TABLEAU
      echo "<tr>
          <td> ". $donnees['id'] . "</td>
          <td>" . $donnees['nom'] ."</td>
          <td>". $donnees['prenom']."</td>
          <td>". $donnees['pseudo']." </td>
          <td>".$donnees['mail']." </td>
          <td>".$donnees['type']." </td>
          <td>".$donnees['statut']." </td>";
          if ($donnees['id'] != $_SESSION['id']) {
            echo "<td><a href=../pages/modifm.php?idm=" . $donnees['id'] .">";
          }
          else{
            
             echo "<td><a href=../pages/profile.php>";
          }
          
          echo "Modifier</a>/<a href=../utility/suppr.php?idm=" . $donnees['id'] .">Supprimer</a></td>
        </tr>";
    }
    ?>
	</table>
  <!-- FIN DU TABLEAU -->

  <!-- FORMULAIRE D'INSCRIPTION -->
	<form action="" method="post" name="formulairead" id="formulairead">
      <fieldset>
        <legend>S'inscrire</legend>
          <label for="civilite">Civilité</label>: 

          <select name="civilite" id="civilite" required>
            <option hidden disabled selected  value id="empty" >---</option>
            <option value="Mr">Mr</option>
            <option value="Mme">Mme</option>
          </select><br><br>

          <label for="nom">Nom</label>: <input type="text" name="nom" id="nom" maxlength="25" placeholder="Nom" required ><br><br>
          <label for="prenom">Prénom</label>: <input type="text" name="prenom" id="prenom" maxlength="25" placeholder=" Prénom" required ><br><br>
          <label for="pseudo">Pseudo</label>:<input type="text" name="pseudo" id="pseudo" maxlength="35" placeholder="Pseudo" required ><br><br>
          <label for="mail">Mail</label>:<input type="text" name="mail" id="mail" maxlength="35" placeholder="Mail" required ><br><br>
          <label for="password">Mot de passe</label>:<input type="password" name="password" id="password" maxlength="35" placeholder="Mot de passe" required ><br><br>

          <!-- SELECTION DU TYPE -->
          <label for="type">Type</label>: 
          <select name="type" id="type">
            <option hidden disabled selected  value id="empty" >---</option>
            <option value="pro">Professionnel</option>
            <option value="particulier">Particulier</option>
          </select>
          <br><br>

          <!-- SELECTION STATUT -->
          <label for="statut">Statut</label>: <select name="statut" id="statut">
            <option hidden disabled selected  value id="empty" >---</option>
            <option value="admin">Administrateur</option>
            <option value="client">Client</option>
          </select>
          <br><br>

          <input type="checkbox" onclick="myFunction('password')">Afficher mot de passe 
          <br><br>
          <input type="submit" value="Envoyer" id="envoyer" name="register">
          <br>
    
      </fieldset>
      </form>
      <!-- fIN DU FORMULAIRE D'INSCRIPTION -->

</body>

</html>


<!--SCRIPT POUR AFFIHCAGE MDP-->
  <script type="text/javascript">
  function myFunction(id) {
  var x = document.getElementById(id);
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
  </script>