# w2w

## Étapes d'installation et de configuration du projet

### Clonage du dépôt

Dans votre répertoire de projets, importer le projet depuis le dépôt :
```
git clone https://github.com/PAC-2019-2020-films/w2w.git
```

### Installation de Composer

Il faut installer Composer, gestionnaire de dépendances PHP, sur votre machine (pour Windows, c'est un simple installer à exécuter).
https://getcomposer.org/

### Installation des dépendances

Pour installer les dépendances définies dans le fichier de config "composer.json", exécuter dans le répertoire de base du projet :
```
composer install
```
Éventuellement, il pourrait réclamer un (si une installation a déjà été effectuée et que le composer.json a changé depuis) :
```
composer update
```
Après ça, vous devez avoir plein de code dans un nouveau répertoire "vendor" dans le projet. Celui-ci ne doit pas être versionné (le .gitignore du projet contient déjà une ligne dédiée).

#### Phing

Parmi les dépendances installées, il y a Phing, outil de "build" pour PHP. Il permet d'automatiser facilement des tâches standard. Son fichier de config est le "build.xml" à la racine du projet.

Pour afficher un message d'aide propre à notre projet, expliquant les "cibles" Phing disponibles et affichant quelques autres commandes fréquentes utiles :
(unix-like)
```
vendor/bin/phing
```
ou (Windows)
```
vendor\bin\phing.bat
```

#### Doctrine

Doctrine est un ORM pour PHP, inspiré de Hibernate (ORM Java). Ça permet d'automatiser les I/O de nos objets métier PHP dans les tables relationnelles de notre db en automatisant les accès SQL.

#### PHPUnit

Pour exécuter des tests unitaires automatisés sur notre code PHP.

#### phpDocumentor ?

Pas encore installé, mais ça pourrait être une bonne idée


### Configuration de MySQL

Création de la base de données 'w2w' et de l'utilisateur MySQL 'w2w' (mot de passe : 'w2w'). Avec des droits admin dans MySQL :
```sql
DROP DATABASE IF EXISTS  `w2w`;
CREATE DATABASE IF NOT EXISTS  `w2w`;
GRANT ALL PRIVILEGES ON `w2w`.* TO `w2w`@localhost IDENTIFIED BY 'w2w';
```

### Création/recréation de la db 

```
mysql -u w2w -pw2w w2w < sql/setup.sql
```
ou (si Phing est correctement installé) :
```
vendor/bin/phing db-reset
```

### Remplissage/re-remplissage de la db

```
php cli/populate.php
```
ou  (si Phing est correctement installé) :
```
vendor/bin/phing db-populate
```

### (Re)Création + (re)remplissage de la db

Pour effectuer les deux opérations précédentes en une seule étape :

```
vendor/bin/phing reset
```

### Tests 

Pour lancer des tests unitaires PHPUnit en ligne de commande :
```
vendor/bin/phpunit --bootstrap appsrc/bootstrap.php appsrc/tests/Test/w2w/DAO
```

Insert by camol : Sous WINDOWS : vendor\bin\phpunit --bootstrap appsrc/bootstrap.php appsrc/tests/Test/w2w/DAO

Ou avec Phing :
```
vendor/bin/phing tests
```

### Nom de domaine local ('hosts')

Pour associer un nom de domaine local à l'IP de la machine locale ('localhost', IP : 127.0.0.1), il faut éditer le fichiers 'hosts' de votre système (unix-like : /etc/hosts - Windows : C:/WINDOWS/system32/drivers/etc/hosts ?) :
```
127.0.0.1       w2w.localhost
::1             w2w.localhost
```
Le nom de domaine ne doit pas obligatoirement contenir 'localhost', c'est une convention personelle.

Maintenant, vous pouvez entrer "http://w2w.localhost/" dans votre navigateur, il vous affichera la page d'accueil par défaut de votre serveur web local (Apache).

### Hôte virtuel Apache

Pour faire tourner différents sites web sur un même serveur Apache, on configure des "hôtes virtuels". 

On va configurer un hôte virtuel en indiquant à Apache que l'on souhaite associer le nom de domaine "w2w.localhost" au répertoire public "www" contenu dans notre projet "w2w".

Notons que notre projet peut se trouver où l'on veut sur notre machine, donc pas nécessairement dans un sous-répertoire de Wamp. Par contre, il faudra éventuellement veiller (unix-like) à ce que le serveur web possède les droits d'accès sur le répertoire concerné.

Trouver le fichier de configuration des hôtes virtuels correspondant à votre installation (exemple Windows + Wamp : http://www.nicolas-verhoye.com/comment-configurer-virtual-hosts-wamp.html ) et l'éditer comme suit (remplacer '/media/data/dev/web/' par le chemin correspondant à l'endroit où vous avez installer le projet 'w2w' sur votre machine) :

```
<VirtualHost *:80>
        ServerName w2w.localhost
        ServerAlias www.w2w.localhost
        ServerAdmin webmaster@localhost
        DocumentRoot /media/data/dev/web/w2w/www/

        ErrorLog ${APACHE_LOG_DIR}/w2w.error.log
        CustomLog ${APACHE_LOG_DIR}/w2w.access.log combined
        
        <Directory "/media/data/dev/web/w2w/www">
            Options Indexes FollowSymLinks
            #AllowOverride None
            AllowOverride All
            #Require all granted
            Require local
        </Directory>

</VirtualHost>
```
(l est important de respecter la présence ou l'abscence de "/" final dans les chemins)

Redémarrer le serveur Apache pour prendre en compte les modifications.

Maintenant, vous pouvez entrer "http://w2w.localhost/" dans votre navigateur, il vous affichera la page d'accueil du projet "w2w".


#### Problème éventuel à résoudre
Eventuellement :
Soit remplacer les lignes 

```
        ErrorLog ${APACHE_LOG_DIR}/w2w.error.log
        CustomLog ${APACHE_LOG_DIR}/w2w.access.log combined
```

par : 

```
        ErrorLog ${INSTALL_DIR}/logs/w2w/w2w.error.log
        CustomLog ${INSTALL_DIR}/logs/w2w/w2w.access.log combined
```
et créer le dossier "w2w" dans le dossier d'installation de wamp/logs (par défaut C:\wamp64\logs).

Ou définir la variable ${APACHE_LOG_DIR} dans le fichier httpd.conf d'Apache, selon l'emplacement souhaité de l'enregistrement des logs.



## PHP technos / standards

- https://phptherightway.com/ (toutes les bonnes pratiques PHP...)
- https://phptherightway.com/#composer_and_packagist
- https://getcomposer.org/doc/01-basic-usage.md#commit-your-composer-lock-file-to-version-control
- https://www.phing.info/ 
- https://www.php-fig.org/psr/psr-12/ 



