# PVF-wordpress-extension

Voici le début de l'extension wordpress initalement développée pour le site du serveur minecraft PureVanilla France visant à apporter un espace communauté au site pour remplacer le Google Sheet qui sert de base de données.
Je n'ai pas eu le temps de finir le travail et il est assez probable que je ne puisse plus m'en occuper à partir de maintenant, je le laisse donc à disposition de l'Internet pour qu'il le termine ou bien l'oublie.

## Ce qui fonctionne déjà
 - Commerce
 - Bases
 - Magasins
 - Projets
 - Inscription et identification des joueurs via le serveur Discord


## Le projet

Extension Wordpress assez classique en PHP. Le gros du travail est allé sur le système d'inscription et de connexion qui utilise un bot Discord pour récupérer la liste des joueurs et ainsi les connecter au compte wordpress associé sans avoir à passer par une inscription classique incluant l'adresse mail notamment. En utilisant les comptes wordpress intégrés, il est plus simple de gérer les autorisations de création et de modifications de pages pour les joueurs.

L'idée était de créer un Wiki d'articles personnalisés utilisant les meta de wordpress pour stocker les informations spécifiques aux posts, comme par exemple la position d'une base, les différents items vendus, les propriétaires d'une ferme, etc...

Pouvoir rechercher dans tout le contenu du serveur et avoir des liens qui regroupent les informations. Par exemple rechercher "fer" et avoir bien sûr le PMI du fer, mais aussi la liste des magasins qui les vendent avec leur propriétaires, en cliquant sur le propriétaire on voit la liste de ses magasins / bases / projets, son skin, pourquoi pas une description et une intro pour le RP. Bref, un simili-réseau social intégré à Wordpress.


## Un peu sur la technique

Il y a à la fois beaucoup et pas grand chose à dire sur le code en lui-même, il n'est ni commit ni commenté (bon courage les gens !) mais il n'est pas très long ou complexe. Parmi les choses intéressantes :
 - La liste des items est stockée dans un fichier json (/data/items.json)
 - Les skins sont animés en 3D et récupérés directement depuis mojang.net sans API token particulier
 - Les utilisateurs créés ont leur pseudo Minecraft enregistré dans un meta ce qui rend leur recherche assez compliquée et longue
 - J'ai tenu à séparer le plus possible les fonctions dans diverses pages PHP en m'inspirant de l'architecture MVC mais sans utiliser la POO


## Ce qui n'est pas fini / pas fait
 - Les capacités permettant aux différents rôles de voir ou modifier les divers types de posts ne sont pas au point
  - La redirection lors de la connexion
  - Les pages des joueurs (il me semble que la page d'un utilisateur Wordpress est uniquement gérée par le thème)
  - Le système d'actualité
  - L'intégration des nouveaux posts à la recherche
  - Le menu "Communauté" regroupant toutes les pages
  - Les pages de contenu (liste complète des magasins, des bases, etc...)
  - La possibilité d'autoriser un autre joueur à modifier une page magasin ou base
  - Sûrement un million d'autres choses auxquelles je ne pense pas tout de suite

## Pour ceux qui souhaitent continuer
YEAH ! Plus sérieusement je vous encourage à continuer le projet pour ceux qui sont intéressés, sachant que je parle de PVF mais le plugin peut complètement s'adapter à n'importe quel site gérant une communauté sur un serveur Minecraft. Une seule contrainte peur ceux qui s'en serviront : je vous interdit absolument de créer une version Lite et une version Premium de cette extension. Si vous la modifiez à tel point que vous souhaitez la vendre, aucun problème faites-vous plaisir mais par contre j'ai horreur des extensions soit-disant géniales qu'on installe et qu'en fait nous affiche de la pub dans l'espace admin de wordpress en nous rappelant que ce serait quand même mieux d'acheter la version payante de l'extension pour profiter des fonctions de bases qui sont mises en avant sur la page du plugin. Je m'égare, mais je suis sérieux !

A bon entendeur.
