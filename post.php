<?php 
session_start();
require ('fonctions.php');

//CODE RELATIF A LA CONNEXION

$connect=connexion('sira');

$search_pseudo = isset($_POST['search_pseudo']) ? $_POST['search_pseudo'] : NULL;
$password = isset($_POST['password1']) ? md5($_POST['password1']) : NULL;


//DEBUT DE AVEC COOKIES
 $search_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : NULL;
 if (isset($search_id)){

  $reponse=$connect->prepare("SELECT * FROM membres WHERE id='$search_id'");
  $reponse->execute (array ('id'=>$search_id));
 

  while($donnees=$reponse->fetch())
  {
    $_SESSION['id']=$donnees['id'];
    $_SESSION['nom']=$donnees['nom'];
    $_SESSION['prenom']=$donnees['prenom'];
    $_SESSION['mail']=$donnees['mail'];
    $_SESSION['pseudo']=$donnees['pseudo'];
    $_SESSION['password']=$donnees['mdp'];
    $_SESSION['statut']=$donnees['statut'];
    $_SESSION['type']=$donnees['type'];
    $_SESSION['civilite']=$donnees['civilite'];
   
    if (isset($_POST['keep-connect']) ){
     setcookie('id', $donnees['id'], time() + 365*24*3600, null, null, false, true); 
     setcookie('nom', $donnees['nom'], time() + 365*24*3600, null, null, false, true); 
     setcookie('prenom', htmlspecialchars($donnees['prenom']), time() + 365*24*3600, null, null, false, true); 
   }

   header('Location: index.php');
 }
}
//FIN DE AVEC COOKIES
if (isset($_POST['login_request'])){

 //DEBUT DE SANS COOKIES
if (isset($password)){

  $reponse=$connect->prepare("SELECT * FROM membres WHERE pseudo='$search_pseudo' AND mdp='$password' ");
  $reponse->execute (array ('pseudo'=>$search_pseudo , 'mdp'=>$password));
  
  while($donnees=$reponse->fetch())
  {
  	$_SESSION['id']=$donnees['id'];
  	$_SESSION['nom']=$donnees['nom'];
  	$_SESSION['prenom']=$donnees['prenom'];
  	$_SESSION['mail']=$donnees['mail'];
  	$_SESSION['pseudo']=$donnees['pseudo'];
  	$_SESSION['password']=$donnees['mdp'];
    $_SESSION['statut']=$donnees['statut'];
    $_SESSION['type']=$donnees['type'];
    $_SESSION['civilite']=$donnees['civilite'];
 
    if (isset($_POST['keep-connect']) ){
     setcookie('id', $donnees['id'], time() + 365*24*3600, null, null, false, true); 
     setcookie('nom', $donnees['nom'], time() + 365*24*3600, null, null, false, true); 
     setcookie('prenom', htmlspecialchars($donnees['prenom']), time() + 365*24*3600, null, null, false, true); 
   }
   header('location:index.php');
 }




$reponse->closeCursor();
}
  //FIN DE SANS COOKIES





}//FIN DU CODE RELATIF A LA CONNEXION

?>




<?php 
//DEBUT DU CODE RELATIF A L INSCRIPTION
if (isset($_POST['register_request'])){
                  $nom=isset($_POST['nom']) ? $_POST['nom'] : NULL ;
                  $prenom=isset($_POST['prenom']) ? $_POST['prenom'] : NULL ;
                  $mail=isset($_POST['mail']) ? $_POST['mail'] : NULL ;
                  $pseudo=isset($_POST['pseudo']) ? $_POST['pseudo'] : NULL ;
                  $password=isset($_POST['password']) ? $_POST['password'] : NULL ;
                  $civilite=isset($_POST['civilite']) ? $_POST['civilite'] : NULL ;
                  $type=isset($_POST['type']) ? $_POST['type'] : NULL ;


$connect=connexion('sira');

    

      
      if (requete($mail,'mail','sira','membres') != NULL){
        echo '<span class="erreur">Cette adresse email est déjà utilisée sur un autre compte.</span>';
      }
        else if (requete($pseudo,'pseudo','sira','membres')!=NULL ){
          echo ' <span class="erreur"> Ce pseudo est déjà pris</span>';
        }else{

        $connect=connexion('sira');
        $insertion=$connect->prepare('INSERT INTO membres ( nom, prenom, mail, pseudo, mdp, civilite, type )
                                VALUES (:nom,:prenom,:mail,:pseudo,:password,:civilite,:type) ' );
        $insertion->execute([
              'nom'=>$nom,
              'prenom'=>$prenom,
                'mail'=>$mail,
              'pseudo'=>$pseudo,
              'password'=>md5($password),
              'civilite'=>$civilite,
              'type'=>$type
                ]);
        header('Location: login_register.php');
      }
    } 
//FIN DU COD RELATIF A L INSCRIPTION
?>