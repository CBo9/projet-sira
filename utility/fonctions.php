<?php

function tri(&$tab){
	$change=1;
	
	for ($i=0;$i < count($tab) , $change!=0;$i++  ) {
		if($tab[$i] > $tab[$i+1]){
			$r=$tab[$i];
			$tab[$i]=$tab[$i+1];
			$tab[$i+1]=$r;
			$change++;
		}
	}
}

function requete($search,$bdData,$dbname,$table){
	try
	{
		$connexion = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",'root','mysql');
		array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
	}
	catch(Exception $e)
	{
		echo 'Echec de la connexion:'.$e->getMessage();
	}
	$reponse=$connexion->prepare("SELECT * FROM $table WHERE $bdData='$search'");
	$reponse->execute (array ());
	while($donnees=$reponse->fetch())
	{

		$count=count($donnees);
		return $count;
		$reponse->closeCursor();

	}
	
}

function connexion($dbname)
{
	try
	{
		$connexion = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",'root','mysql');
		array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
		return $connexion;
	}
	catch(Exception $e)
	{
		echo 'Echec de la connexion:'.$e->getMessage();
	}
}

function listArticle2($db,$table, $v1,$v2) {
	$db = connexion($db);
	$query = $db -> prepare("SELECT * FROM $table");
	$query -> execute();
	while ($donnee = $query -> fetch()) {
		echo '<option value="' . $donnee['id_agence'] . '">' . $donnee[$v1] . " " . $donnee[$v2] . '</option>';

	}
}

function postVar($var){
	$var=isset($_POST['$var']) ? $_POST['$var'] : NULL ;
	
}

function requeteConnexion($col1,$var1,$col2,$var2){
	try
			{
				$connexion = new PDO("mysql:host=localhost;dbname=profiles;charset=utf8",'root','mysql');
				array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
			}
			catch(Exception $e)
			{
				echo 'Echec de la connexion:'.$e->getMessage();
			}

			$reponse=$connexion->prepare("SELECT * FROM login WHERE $tab1='$var1' AND $tab2='$var2' ");
			  $reponse->execute (array ('$tab1'=>$var1 , '$tab2'=>$var2));
			  $tour=0;

			  while($donnees=$reponse->fetch())
			  {
			  	$_SESSION['id']=$donnees['id'];
			  	$_SESSION['nom']=$donnees['nom'];
			  	$_SESSION['prenom']=$donnees['prenom'];
			  	$_SESSION['tel']=$donnees['tel'];
			  	$_SESSION['mail']=$donnees['mail'];
			  	$_SESSION['pseudo']=$donnees['pseudo'];
			  	$_SESSION['password']=$donnees['password'];
			  	$tour+=1;
			    if (isset($_POST['keep-connect']) ){
			     setcookie('id', $donnees['id'], time() + 365*24*3600, null, null, false, true); 
			     setcookie('nom', $donnees['nom'], time() + 365*24*3600, null, null, false, true); 
			     setcookie('prenom', htmlspecialchars($donnees['prenom']), time() + 365*24*3600, null, null, false, true); 
			    }
			  
			  	header('Location: profile.php');
			  }
}

function ashuffle (&$arr) {
    uasort($arr, function ($a, $b) {
        return rand(-1, 1);
    });
}

function swap(&$array){
	if(count($array)<2){
		echo 'pas assez d\'éléments dans ' . '$array'; 
	}else{
$array=array_reverse($array);

}
}
$list=["Premier" ];





?>


