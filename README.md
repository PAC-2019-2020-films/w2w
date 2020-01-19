# w2w

Grosse modification de la structure effectuée, mergée et pushée dans la branche "master" (l'ancienne version MVC est toujours accessible dans la branche "mvc").

Le système de connexion fonctionne. Le mot de passe correspond au "userName" de l'utilisateur.

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

## Doc interne

- étapes installation projet : voir doc/setup.md

## Doc externe

- https://phptherightway.com/ (toutes les bonnes pratiques PHP...)
- https://phptherightway.com/#composer_and_packagist
- https://getcomposer.org/doc/01-basic-usage.md#commit-your-composer-lock-file-to-version-control
- https://www.phing.info/ 
- https://www.php-fig.org/psr/psr-12/ 



