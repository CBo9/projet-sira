# project-sira
site de location de voitures en ligne

# Le projet en détails
- Avant tout, téléchargez la dernière version disponible et enregistrez-la dans le dossier 'www' de votre WAMP. Assurez-vous que 
le dossier soit nommé 'projet-sira'.<br>
- Créez un dossier 'img' contenant 2 dossiers : 'voitures' et 'agences'.<br>
- Puis créez une base de données sur PhpMyAdmin et nommez-la 'sira'.<br>
- Importez le fichier 'sira.sql' situé dans la racine du projet.<br>

 Attention, selon le WAMP utilisé les paramètres de connexions peuvent varier!Pour corriger ce problème, ouvrez projet-sira/utility/fonctions.php et échangez 'root' et 'mysql' lignes 19,44 et 83 par 
 l'identifiant et le mot de passe de votre compte PhpMyAdmin.<br>
 <br>
 Le site est prêt à être utilisé! <br>


Notre code est organisé en 5 sous-dossiers:<br>
- "pages" contient le code principal de chacune des pages du site <br>
- "templates" contient les morceaux de codes inclus dans différentes pages (exemple : le menu principal)<br>
- "img" contient les images uploadés sur le serveur <br>
- "utility" contient des codes php ayant des fonctions back-end seulement<br>
- "style" contient les fiches de styles css<br>


## Problèmes connus:
- [ ] problème au niveau des cookies<br>
- [x] ~~affichage de page suivante si index.php possède 1 seule page listant les voitures~~<br>
- [ ] véhicule réservé pour une période à venir affiché comme disponible sur la page de réservation <br>

## Fonctionnalités en cours de développement:<br>
- connexion disponible dans le menu hamburger (disponible sur l'intégralité des pages)<br>
- correction des problèmes listés avant<br>
- ajout d'avatar et de favoris possible<br>

