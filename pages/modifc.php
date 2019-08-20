<?php
$id = $_GET['modc'];  ?>
	
	

	<h1>Modifiez une commande</h1>
	<form method="post" action="commandes.php">
		<fieldset>
			<br><br>
			<input type="text" hidden name="cid" id="cid" value="<?=$id;?>">
			<input type="text" hidden name="prixT" id="pt" value="">
			<label>Modifier la date de départ</label>
			<input type="date" name="dateD" id="dateD" value="<?=$dateD;?>" min="<?= $datenow;?>">
			<br><br>
			<label>Modifier la date de retour</label>
			<input type="date"  onclick="datej()" min="<?= $datenow;?>" name="dateF" id="dateF" value="<?=$dateF;?>">
			<br><br>
			<a onclick="calculer(<?= $prixJ; ?>)">Consulter les modifications
			</a>
			<p id="res"></p>
			
		</fieldset>
	</form>

	<script type="text/javascript">
		


function temps(date)
{
var d = new Date(date[0], date[1] - 1, date[2]);
return d.getTime();
}

//FONCTION DE CALCUL DU PRIX AVEC LA VALEUR DE LA function 'temps'
function calculer(prixj) 
{ 


var date1=document.getElementById('dateD').value;
var date2=document.getElementById('dateF').value;
var dateD=date1.replace(/-/gi, '/');
var dateF=date2.replace(/-/gi, '/');

var debut = temps(dateD.split("/"));
var fin = temps(dateF.split("/"));
var nb = (fin - debut) / (1000 * 60 * 60 * 24); // + " jours";

nb++;
document.getElementById('res').innerHTML='Vous réservez pour ' + nb + 'jours: ' + (nb*prixj)+ '€.';
document.getElementById('res').innerHTML+= '<input type="submit" name="modif" value="Confirmer">';
document.getElementById('pt').value = nb*prixj;
} 

//FONCTION DE RESERVATION
function datej(){

	var date1=document.getElementById('dateD').value;
	document.getElementById('dateF').min=date1;
}

</script>

