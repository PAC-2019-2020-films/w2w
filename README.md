# w2w




## Apache virtual hosts configuration :

http://www.nicolas-verhoye.com/comment-configurer-virtual-hosts-wamp.html


Ajouter dans le fichiers 'hosts' de votre système (/etc/hosts - C:/WINDOWS/system32/drivers/etc/hosts ?) :
```
127.0.0.1       w2w.localhost
::1             w2w.localhost
```

Exemple de config (remplacer '/media/data/dev/web/' par le chemin correspondant à votre installation) :

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

Eventuellement remplacer les lignes 

```
        ErrorLog ${APACHE_LOG_DIR}/w2w.error.log
        CustomLog ${APACHE_LOG_DIR}/w2w.access.log combined
```

par : 

```
        ErrorLog ${INSTALL_DIR}/logs/w2w/w2w.error.log
        CustomLog ${INSTALL_DIR}/logs/w2w/w2w.access.log combined
```
ou définir la variable ${APACHE_LOG_DIR} dans le fichier httpd.conf d'Apache, selon l'emplacement souhaité de l'enregistrement des logs.
