<?php

// AFFICHAGE DE LA BARRE DE NAVIGATION POUR LES VISITEUR DU SITE
if (!isset($_SESSION['id'])) {
echo'
			<a href="/projet_sira/index.php"><li>Accueil</li></a>
			<a href="/projet_sira/pages/login_register.php" ><li>Inscription/Se connecter</li></a>
			<a href="/projet_sira/pages/support.php"><li>Nous contacter</li></a>
		
		';
}
// FIN AFFICHAGE DE LA BARRE DE NAVIGATION POUR LES VISITEUR DU SITE

// AFFICHAGE D'UN MENU SPECIFIQUE SI L'UTILISATEUR A LE STATUT DE 'admin'
else if($_SESSION['statut']=="admin"){
echo ' 
			
			<a href="/projet_sira/index.php"><li>Accueil </li></a>
			<a href="/projet_sira/pages/ajouta.php"><li>Nos agences</li></a>
			<a href="/projet_sira/pages/ajoutv.php"><li>Nos voitures</li></a>
			<a href="/projet_sira/pages/membre.php"><li>Nos membres</li></a>
			<a href="/projet_sira/pages/commandes.php"><li>Commandes</li></a>
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
// FIN AFFICHAGE D'UN MENU SPECIFIQUE SI L'UTILISATEUR A LE STATUT DE 'admin'
	
	// AFFICHAGE DU MENU POUR LES UTILISATEUR MEMBRE DU SITE
	else if($_SESSION['statut']!="admin"){
echo 		
			'
			<a href="/projet_sira/index.php"><li>Accueil </li></a>		
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
	// FIN AFFICHAGE DU MENU POUR LES UTILISATEUR MEMBRE DU SITE
?>