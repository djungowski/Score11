Score11 lokal aufsetzen
=======================

Abhängigkeiten:

	mysql
	php
	memcache

1. Score11 auschecken

        git clone git@github.com:djungowski/Score11.git

2. Score11-API auschecken

        git clone git@github.com:djungowski/frapi.git

3. Alias fuer Score11/public anlegen, z.B.

        Alias /score11 /Users/djungowski/Sites/Score11/public

4. Darauf achten, dass der Score11 Ordner folgende Rechte besitzt (Apache2)

        Options MultiViews FollowSymlinks
        AllowOverride All

5. Hostseinträge für Frapi

        sudo echo "127.0.0.1 api.score11.de" >> /etc/hosts
        sudo echo "127.0.0.1 admin.frapi" >> /etc/hosts

6. Apache2 Config für Score11

        <Directory /Users/djungowski/Sites/Score11/public>
                SetEnv APPLICATION_ENV development
                RewriteEngine On
                RewriteBase /2012
                RewriteCond %{REQUEST_FILENAME} !-f
                RewriteCond %{REQUEST_FILENAME} !-d
                RewriteRule !\.(js|ico|gif|jpg|png|css)$ index.php
        </Directory>

7. Apache2 Config fuer Frapi Admin (siehe auch http://frapi.github.com/installing/index.html)

        <VirtualHost *:80>
            ServerName admin.frapi
            DirectoryIndex index.php
            ServerAdmin admin@api.frapi
        
            # This should be omitted in the production environment
            SetEnv APPLICATION_ENV development
        
            DocumentRoot /Users/djungowski/Sites/frapi/src/frapi/admin/public
            <Directory /Users/djungowski/Sites/frapi/src/frapi/admin/public>
                AllowOverride All
                Order deny,allow
                Allow from All
            </Directory>
        </VirtualHost>

8. Apache2 Config fuer Frapi Api (siehe auch http://frapi.github.com/installing/index.html)
        
        <VirtualHost *:80>
            ServerName api.score11.de
            ServerAdmin admin@api.frapi
            DocumentRoot /Users/djungowski/Sites/frapi/src/frapi/public
        
            # This should be omitted in the production environment
            SetEnv APPLICATION_ENV development
        
            <Directory /Users/djungowski/Sites/frapi/src/frapi/public>
                AllowOverride All
                Order deny,allow
                Allow from All
            </Directory>
        </VirtualHost>

9. Sicherstellen, dass die folgenden PHP Module aktiviert ist

        apc
        gd2
        mysql
	memcache

10. DB Dump ziehen und einspielen

        scp root@score11.de:/home/sschwarz/dbbackup/score11.gz . && gunzip score11.gz && mysql score11 <score11

11. Sicherstellen, dass in der php.ini der timezone Wert gesetzt ist, z.B.

        date.timezone = Europe/Berlin

12. score11 DB User anlegen

        grant all privileges on score11.* to 'score11'@'localhost';

13. setup-dev.sh ausfuehren (Score11)

        ./setup-dev.sh

14. setup-tests.sh ausfuehren (frapi)

        cd frapi/src/frapi/custom/
        ./setup-tests.sh
