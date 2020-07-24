# I - Qu'est ce que ft_server ?
### Le sujet
L'objectif de ft_server est de créer un serveur web capable de faire tourner un wordpress, un phpmyadmin, et une base de données. 
Ce serveur tournera dans un containeur Docker, sous Debian Buster.
### Le sujet pour les nuls
Quand tu tappes dans la barre de recherche "Google.com" un serveur web stocke les fichiers constituant le site web (les images, etc.)
Pour obtenir la page, ton navigateur fait une demande de page web au serveur qui lui envoie alors les fichiers.

Il existe différents types de seveurs web : des statiques ou des dynamiques. 
Dans notre cas, nous créerons un serveur web dynamique. D'un point de vue logiciel, les composantes d'un serveur web dynamique sont les suivantes :
- Un OS (ex : Windows ou Linux)
- Un serveur HTTP = un logiciel qui prend en charge les requêtes client-serveur du protocole HTTP (ex : Apache ou Nginx)
- Une base de données (ex : mySQL)
- Un langage de script = permet d’interpréter les demandes du client et les traduire en html (ex : le php)

Notre OS = **Debian Buster** (Linux est une sorte de famille de systèmes d’exploitation avec plusieurs versions. Chaque version est une “distribution” parmi lesquelles Debian).
Notre seveur HTTP = **Nginx** (Nginx est un serveur web open-source. Microsoft, Google ou IBM utilisent eux aussi Nginx.).
Notre Base de données = **Maria DB**.
Notre langage de script = **PHP**. + Nous installerons et configurerons **Phpmyadmin** et **Wordpress** 

Et tout ça, nous le ferons dans ce qu'on appelle un conteneur **Docker**. 
Pourquoi dans un conteneur Docker ?
- Le problème :
Souvent on se retrouve avec applications qui ont des tonnes de dépendances : besoin de magic pour faire la conversion des images, besoin d’une base de donnée particulière, besoin de nginx ou apache etc. Quand on travaille avec un hébergeur tiers c’est un peu l’enfer. l’administrateur système devra installer les bonnes versions sur un certain nombre de machine etc, casse tête.
- La solution :
Docker permet d’empaqueter une application dans un conteneur virtuel. C’est une sorte de boîte complètement isolée de notre système d’exploitation. Dans laquelle on peut installer toutes les librairies dont a besoin notre application pour fonctionner. Et on y installe aussi notre application. Et donc on peut envoyer cette boxe un peu partout, et elle va fonctionner peu importe le système d’exploitation.

# II - Comment ai-je fait ft_server ?

## 1. Comprendre Docker & créer ses premiers conteneurs
### étape 1 : installe Docker sur ton ordinateur
Si ton Docker fonctionne difficilement tu peux faire ces deux commandes :
  ```
  > git clone https://github.com/alexandregv/42toolbox.git ~/42toolbox
  > bash init_docker.sh
  ```
### étape 2 : créer une image
Chaque conteneur est créé à partir d’une image Docker.
Soit tu prends une image déjà crée (que tu peux retrouver dans le Docker Hub).
Soit tu crée ta propre image, et c'est ce qu'on fait ici. Pour créer ton image, tu peux créer un fichier qu'il faut appeller **Dockerfile**.
Mais pour créer ton image il faut lancer cette commande à l'endroit où il y a ton Dockerfile:
  ```
  > docker build -t *nomimage* .
  ```
Vérifie si ton image est crée avec :
  ```
  > docker images
  ```
Supprimer une image ou la totalité des images avec :
  ```
  > docker rmi *nomimageouid*
  > docker rmi $(docker images -a -q)
  ```
### étape 3 : rouler le conteneur
Une fois ton image crée, tu peux lancer ton conteneur avec (ici on ouvre le port 80) :
  ```
  > docker run -d -p 80:80 --name=*nomconteneur* *nomimage*
  ```
Vérifie les conteneurs qui tournent et la totalité des conteneurs avec :
  ```
  > docker ps
  > docker ps -a
  ```
Arrêter un conteneur et arrêter la totalité des conteneurs :
  ```
  > docker stop *nomconteneurouid*
  > docker rm $(docker ps -a -q)
  ```
Très important, la commande pour entrer dans ton conteneur :
  ```
  > docker exec -ti *nomconteneurouid* bash
  ```

## 2. Installer et configurer Nginx
### étape 1 : installer Nginx
On utilise la commande apt-get. apt-get offre une méthode simple pour installer des paquets à la ligne de commande à partir des serveurs Debian qui contiennent un ensemble de paquets.
La première action à effectuer avant d'utiliser apt-get est de récupérer les listes de paquets depuis les Sources afin que le programme sache quels sont les paquets disponibles, c'est pourquoi on commence par la commande update.
L'option -y permet de répondre oui par avance aux demandes de confirmations, puisqu'on est on dans un script on peut pas mettre oui. 
  ```
  > apt-get update
  > apt-get -y install nginx
  ```
### étape 2 : Lancer Nginx et avoir le "Welcome to Nginx"
Ne pas oublier de lancer Nginx :
  ```
  > service nginx start
  > sleep infinity
  ```
On a la page d’accueil "Welcome to Nginx" si on va sur l’adresse de notre serveur.
### étape 3 : Configurer Nginx
Toute la configuration de Nginx se trouve dans le fichier default à etc/nginx/sites-available. Tu peux entrer dans ton conteneur avec la commande exec dont j'ai parlé plus haut et aller voir ces configs.
Chaque élément du fichier default est expliqué sur openclassroom : https://openclassrooms.com/fr/courses/4425101-deployez-une-application-django/4688553-utilisez-le-serveur-http-nginx.
Concernant les configs tout est expliqué ici : https://www.digitalocean.com/community/tutorials/how-to-install-nginx-on-debian-10

## 3. Certificat SSL
### étape 1 : installer open ssl générer les 2 fichiers du certificat SSL
Un certificat SSL est un fichier de données qui lie une clé cryptographique aux informations d'une organisation. Installé sur un serveur, le certificat active le cadenas et le protocole « https », afin d'assurer une connexion sécurisée entre le serveur web et le navigateur.
Avant d'utiliser openssl, il faut l'installer.
  ```
  > apt-get install openssl
  ```
La commande openssl permet de générer le certificat ssl qui se compose de deux fichiers :
- localhost.pem
- localhost.key
  ```
  > openssl req -newkey rsa:4096 -x509 -sha256 -days 365 -nodes -out /etc/nginx/ssl/localhost.pem -keyout /etc/nginx/ssl/localhost.key -subj "/C=FR/ST=Paris/L=Paris/O=42 School/OU=emma/CN=localhost"
  ```
### étape 2 : configurer Nginx pour utiliser SSL
Ajouter dans le fichier du configuration Nginx :
  ```
  ssl_certificate /etc/nginx/ssl/localhost.pem;
  ssl_certificate_key /etc/nginx/ssl/localhost.key;
  ```
## 4. Installer PHP et tester
### étape 1 : installer php & configurer Nginx
  ```
  > apt-get install -y php7.3 php7.3-fpm php7.3-mysql php-common php7.3-cli php7.3-common php7.3-json php7.3-opcache php7.3-readline
  ```
Ne pas oublier de lancer php avec :
  ```
  > service php7.3-fpm start
  ```
Ajouter index.php dans les configurations de Nginx.
### étape 2 : créer un fichier test.php pour vérifier la configuration
Mettre un bout de php dans le fichier test.php, copier test.php dans var/www/localhost. Puis pour tester tapper dans la barre de recherche localhost/test.php
Si vous avez bien votre fichier qui s'affiche c'est OK.
## 5. Installer & lancer Maria DB
  ```
  > apt-get install -y mariadb-server mariadb-client
  ```
Ne pas oublier de lancer avec :
  ```
  > service mysql start
  ```
## 6. Installer & configurer Phpmyadmin
Suivre ce tuto : https://www.itzgeek.com/how-tos/linux/debian/how-to-install-phpmyadmin-with-nginx-on-debian-10.html

## 7. Installer & configurer Wordpress
Suivre ce tuto : https://www.digitalocean.com/community/tutorials/how-to-install-wordpress-with-lemp-nginx-mariadb-and-php-on-debian-10
Pour l'étape 1, "Creating a Database and User for WordPress", il n'est pas possible de rentrer les commandes une fois le conteneur en cours. Il nous fait donc utiliser echo.
Ici le "| mysql -u root" indique où il faut entrer le commande echo, ici directement dans le shell Mysql.
D'où :
  ```
  > echo "CREATE DATABASE wordpress DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;" | mysql -u root
  > echo "GRANT ALL ON wordpress.* TO 'wordpress_user'@'localhost' IDENTIFIED BY 'password';" | mysql -u root
  > echo "FLUSH PRIVILEGES;" | mysql -u root
  ```
