<?php 
require('navbar.php');
require('post.php');
 if (isset($_SESSION['id'])){
 header('Location:index.php');
} 
?>
<h1>Se connecter</h1>
  <form method="post"action="">
   <input type="text" name="search_pseudo" id="search_pseudo" placeholder="Pseudo" required  />
   <input type="password" name="password" id="password1" placeholder="Mot de passe" required />
   <input type="checkbox"  onclick="myFunction('password1')" title="Afficher le mot de passe">
   <input type="submit" class="btn" value="Se connecter" name="login_request">
   <br>
   
   <input type="checkbox" id="keep-connect"  name="keep-connect" ><label for="keep-connect">Rester connecté</label>
  </form>
 <a href="register.php" class="lien-redirection"> Pas encore inscrit? Inscrivez-vous ici</a>
   



<form action="" method="post" name="formulaire" id="formulaire">
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

           <label for="type">Statut</label>: <select name="type" id="type">
            <option hidden disabled selected  value id="empty" >---</option>
            <option value="pro">Professionnel</option>
            <option value="particulier">Particulier</option>
          </select><br><br>

          <input type="checkbox" onclick="myFunction('password')">Afficher mot de passe 
       <br><br>
          <input type="submit" value="Envoyer" id="envoyer" name="register_request">
          <br>
      <a  href="login.php" class="lien-redirection">Déjà inscrit? Connectez-vous ici!</a>
      </fieldset>
      </form>
<?php 
if ($_SESSION['error']==1){
    echo 'Le mot de passe est incorrect ';
    session_destroy();
  }
?>

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