# w2w

Grosse modification de la structure effectuée, mergée et pushée dans la branche "master" (l'ancienne version MVC est toujours accessible dans la branche "mvc").

Le système de connexion fonctionne. Le mot de passe correspond au "userName" de l'utilisateur.

## Modification de l'hôte virtuel

Je conseille de continuer à utiliser un "virtual host" mais il faut modifier sa config pour ne plus pointer vers un sous-répertoire "ww" du projet mais directement à la racine du projet.

```
<VirtualHost *:80>
        ServerName w2w.localhost
        ServerAlias www.w2w.localhost
        ServerAdmin webmaster@localhost
        DocumentRoot /media/data/dev/web/w2w/

        <Directory "/media/data/dev/web/w2w">
            Options Indexes FollowSymLinks
            #AllowOverride None
            AllowOverride All
            #Require all granted
            Require local
        </Directory>
</VirtualHost>
```

## Fonctionnement

Tout le code de démarrage se trouve dans le fichier "index.php" à la racine du projet.

### Exécution d'un script
Pour faire tourner un script à l'url "http://w2w.localhost/account/review-add.php?id=54" :

- créer un fichier "<racine du projet>/scripts/account/review-add.php" : il sera automatiquement exécuté par le code de démarrage

- créer un fichier "<racine du projet>/scripts/account/review-add.view.php" (facultatif mais conseillé pour les scripts non triviaux) : si ce fichier existe, il est exécuté juste après et accède aux variables crées dans le premier ; ce second script est le script de "vue", responsable de l'affichage du résultat (le contenu de la page HTML à renvoyer), tandis que le premier est le script de "traitement".

Exemple :

fichier "<racine du projet>/scripts/account/review-add.php" (traitement) :
```
$id = param("id");
$daoFactory = \w2w\DAO\DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$movie = $movieDAO->find($id);
# suite du traitement...
```

fichier "<racine du projet>/scripts/account/review-add.view.php" (vue) :
```
<h2>Vous ajoutez une critique au film "<?php echo escape($movie->getTitle()); ?>"</h2>
<form action="/account/review-add-action.php" method="post">
        <input type="hidden" name="movie-id" value="<?php echo escape($movie->getId()); ?>"/>
        <!-- suite du formulaire... -->
</form>
```

### Layout et output buffering

Pendant l'exécution des scripts, le flux de sortie est bufferisé et récupéré dans une variable au lieu d'être envoyé dans la réponse au client HTPP. Le contenu de cette variable est ensuite inséré dans le fichier ""<racine du projet>/scripts/templates/layout.php", qui contient donc la mise en page commune à l'ensemble du site.

### Remarques :

- pour la page d'accueil, les scripts sont "<racine du projet>/scripts/homepage.php" et "<racine du projet>/scripts/homepage.view.php".
- pour une url de type "/account/", créer un fichier "<racine du projet>/scripts/account/index.php"








## Doc interne

- étapes installation projet : voir [doc/setup.md](https://github.com/PAC-2019-2020-films/w2w/blob/master/doc/setup.md)

## Doc externe

- https://phptherightway.com/ (toutes les bonnes pratiques PHP...)
- https://phptherightway.com/#composer_and_packagist
- https://getcomposer.org/doc/01-basic-usage.md#commit-your-composer-lock-file-to-version-control
- https://www.phing.info/ 
- https://www.php-fig.org/psr/psr-12/ 



