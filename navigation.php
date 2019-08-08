<?php


	
if (!isset($_SESSION['id'])) {
echo'
			<a href="index.php"><li>Accueil</li></a>
			<a href="login_register.php" ><li>Inscription/Se connecter</li></a>
			<a href="support.php"><li>Nous contacter</li></a>
		
		';
}
else if($_SESSION['statut']=="admin"){
echo ' 
			
			<a href="index.php"><li>Accueil </li></a>
			<a href="agences.php"><li>Nos agences</li></a>
			<a href="voitures.php"><li>Nos voitures</li></a>
			<a href="membres.php"><li>Nos membres</li></a>
			<a href="support.php"  ><li>Support</li></a>
			<a href="profile_me.php"  ><li>'. $_SESSION['nom'] .  " " . $_SESSION['prenom'] .'</li></a>
			<a onclick="deconnect()" class="dc-link" ><li>Deconnexion</li></a>
			
		
		<script>
			function deconnect(){
				var deci = confirm("Etes-vous sûr de vouloir quitter?") ;
			
			if (deci == true){
				document.location.replace(\'logout.php\');
				
			}
}
			</script>
		';
	}
	else if($_SESSION['statut']!="admin"){
echo 		
			'
			<a href="index.php"><li>Accueil </li></a>
			<a href="questions.php"  ><li>Quiz</li></a>		
			<a href="support.php"  ><li>Support</li></a>
			<a href="profile_me.php"  ><li>'. $_SESSION['pseudo'] . '</li></a>
			<a  onclick="deconnect()" class="dc-link" ><li>Deconnexion</li></a>
		
			
			
		
		<script>
			function deconnect(){
				var deci = confirm("Etes-vous sûr de vouloir quitter?") ;
			
			if (deci == true){
				document.location.replace(\'logout.php\');
				
			}
}
			</script>
		';
	}
	
?>