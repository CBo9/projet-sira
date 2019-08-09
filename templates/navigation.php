<?php


	
if (!isset($_SESSION['id'])) {
echo'
			<a href="/projet_sira/index.php"><li>Accueil</li></a>
			<a href="/projet_sira/pages/login_register.php" ><li>Inscription/Se connecter</li></a>
			<a href="/projet_sira/pages/support.php"><li>Nous contacter</li></a>
		
		';
}
else if($_SESSION['statut']=="admin"){
echo ' 
			
			<a href="/projet_sira/index.php"><li>Accueil </li></a>
			<a href="/projet_sira/pages/ajouta.php"><li>Nos agences</li></a>
			<a href="/projet_sira/pages/ajoutv.php"><li>Nos voitures</li></a>
			<a href="/projet_sira/pages/membre.php"><li>Nos membres</li></a>
			<a href="/projet_sira/pages/support.php"  ><li>Support</li></a>
			<a href="/projet_sira/pages/profile.php"  ><li>'. $_SESSION['nom'] .  " " . $_SESSION['prenom'] .'</li></a>
			<a onclick="deconnect()" class="dc-link" ><li>Deconnexion</li></a>
			
		
		<script>
			function deconnect(){
				var deci = confirm("Etes-vous sûr de vouloir quitter?") ;
			
			if (deci == true){
				document.location.replace(\'/projet_sira/templates/logout.php\');
				
			}
}
			</script>
		';
	}
	else if($_SESSION['statut']!="admin"){
echo 		
			'
			<a href="/projet_sira/index.php"><li>Accueil </li></a>
			<a href=""  ><li>Mes commandes</li></a>		
			<a href="/projet_sira/pages/support.php"  ><li>Support</li></a>
			<a href="/projet_sira/pages/profile.php"  ><li>'. $_SESSION['pseudo'] . '</li></a>
			<a  onclick="deconnect()" class="dc-link" ><li>Deconnexion</li></a>
		
			
			
		
		<script>
			function deconnect(){
				var deci = confirm("Etes-vous sûr de vouloir quitter?") ;
			
			if (deci == true){
				document.location.replace(\'/projet_sira/templates/logout.php\');
				
			}
}
			</script>
		';
	}
	
?>