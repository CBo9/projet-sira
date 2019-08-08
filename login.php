<?php 
session_start();
if (isset($_SESSION['nom'])){
	header('Location: profile_me.php');
}
if (isset($_COOKIE['id'])){
  header('Location:post.php');
}
require('navigation.php');

?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="styleForm.css">
  <link href="style.css" rel="stylesheet" type="text/css"/>
  <script type="text/javascript" src="cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
</head>
<body class="register-login-pages">
 <h1>Se connecter</h1>
  <form method="post"action="post.php">
   <input type="text" name="search_pseudo" id="search_pseudo" placeholder="Pseudo" required  />
   <input type="password" name="search_password" id="search_password" placeholder="Mot de passe" required />
   <input type="checkbox"  onclick="myFunction()" title="Afficher le mot de passe">
   <input type="submit" class="btn" value="Se connecter">
   <br>
   
   <input type="checkbox" id="keep-connect"  name="keep-connect" ><label for="keep-connect">Rester connecté</label>
  </form>
  <?php 
  if ($_SESSION['error']==1){
  	echo 'Le mot de passe est incorrect ';
  	session_destroy();
  }



?>
  <a href="register.php" class="lien-redirection"> Pas encore inscrit? Inscrivez-vous ici</a>
   <script type="text/javascript">
  function myFunction() {
  var x = document.getElementById("search_password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
  </script>
</body>
</html>