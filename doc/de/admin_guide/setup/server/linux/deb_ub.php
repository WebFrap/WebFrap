<h1>Debian / Ubuntu</h1>

<p>
Es liegt die Annahme zugrunde, dass der Server komplett neu aufgesetzt wird
und exklusiv für den Betrieb der Applikation bereitgestellt wird.
</p>

<p>
Auf dem Server sollte keine unnötigen Softwarepakete, und schon gar keine
zusätzlichen Serverdienste betrieben werden. Jeder Zusätzliche Dienst
auf dem System erhöht das Sicherheitsrisiko.
</p>

<p>Eine kleine Übersicht was zum Setup des Systems nötig ist</p>
<ul>
  <li>Vorbereitung</li>
  <li>Installation Basispakete</li>
  <li>Erstellen einer Ordnerstruktur</li>
  <li>Setup Mercurial</li>
</ul>

<h2>Vorbereitung</h2>

<p>
Bevor wir mit dem Setup Anfangen gilt es sich einige Gedanken zu machen.
Es werden benötigt:
</p>

<ul>
  <li>
  Der Name des Universums, hier verwenden wir <span class="value" >demo</span>. Dieser Name bezeichnet den Ordner in welchem
  später alle Daten des Systems vorhanden sein werden. Er sollte daher passend gewählt werden. 
  Es werden nur Zahlen, kleine Buchstaben des Alphabets ohne Sonderzeichen und Unterstriche akzeptiert.<br />
  Falsch: <span class="bad" >Whatever-2-Go</span>  Richtig: <span class="good" >whatever2go</span> oder <span class="good" >whatever_2_go</span><br />
  Falsch: <span class="bad" >H&B</span> Richtig: <span class="good" >h_and_b</span>, <span class="good" >h_a_b</span>, <span class="good" >hab</span><br />
  </li>
  <li>
  Den Namen und ein sicheres Passwort für den Adminstrativen Benutzer der Datenbank. 
  Wir verwenden <span class="value" >admin_user</span> und <span class="value" >admin_pwd</span> in der Doku, diese
  Namen sind <span class="important" >jedoch auf jeden Fall</span> zu ändern.
  </li>
  <li>
  Den Namen und ein sicheres Passwort für den Adminstrativen Benutzer der Datenbank definieren.
  </li>
  <li>
  Den Namen und ein sicheres Passwort für den Datenbankbenutzer der Applikation definieren.
  </li>
  <li>
  Einen Namen für die Datenbank und das Hauptdatenschema definieren.
  </li>
</ul>


<h2>Basis Packete</h2>

<p>
Schritt eins, wir sorgen für einen vernünftigen Editor mit dem wir später
auf die Konfiguratinsdateien losgehen können.
</p>

<pre>
<span class="command" >sudo apt-get install</span> vim openjdk-6-jdk
</pre>

<h2>Erstellen der Ordner Struktur</h2>

<pre>
<span class="command" >sudo mkdir</span> -p /srv/universe/demo
</pre>


<h2>Mercurial</h2>

<p>
Für den Download der Packete wird Merurial benötigt.
</p>

<pre>
<span class="command" >sudo apt-get install</span> mercurial
</pre>

<h2>Setup GAIA</h2>

<pre>
<span class="command" >cd</span> /srv/universe/demo
<span class="command" >hg clone</span> https://hg.webfrap-servers.de/webfrap/WebFrap_Gaia
<span class="command" >cd</span> /srv/universe/demo/WebFrap_Gaia
<span class="command" >hg update</span> stable
</pre>


<h2>Datenbank</h2>
<pre>
<span class="command" >sudo apt-get install</span> postgresql postgresql-contrib
</pre>

<p>

</p>

<label>Benutzer und Datenbank erstellen</label>

<pre>
you@yourdesk:~$ <span class="command" >sudo su postgres</span>
[sudo] password for you: 
postgres@yourdesk:/home/you$

postgres@yourdesk:/home/you$ <span class="command" >createuser admin_user -P</span>
Geben Sie das Passwort der neuen Rolle ein: 
Geben Sie es noch einmal ein: 
Soll die neue Rolle ein Superuser sein? (j/n) y
Soll die neue Rolle Datenbanken erzeugen dürfen? (j/n) y
Soll die neue Rolle weitere neue Rollen erzeugen dürfen? (j/n) y

postgres@yourdesk:/home/you$ <span class="command" >createuser system_user -P</span>
Geben Sie das Passwort der neuen Rolle ein: 
Geben Sie es noch einmal ein: 
Soll die neue Rolle ein Superuser sein? (j/n) n
Soll die neue Rolle Datenbanken erzeugen dürfen? (j/n) n
Soll die neue Rolle weitere neue Rollen erzeugen dürfen? (j/n) n

postgres@yourdesk:/home/you$ <span class="command" >createdb db_name -E "utf-8" -O createuser</span>
</pre>

<p>
Wichtig, danach mit <span class="command" >strg + d</span> wieder vom user postgres
zum ursprünglichen user wechseln.
</p>


<h2>Apache Webserver + PHP</h2>

<p>
Der nächste Schritt ist die Instalation des Webservers + PHP
</p>

<pre>
<span class="command" >sudo apt-get install</span> libapache2-mod-php5 php5-cli php5-common php5-curl \
php5-gd php5-pgsql php5-xdebug php5-suhosin php5-imagick php5-imap php5-mcrypt \
php-apc
</pre>

<p>Der nächste Schritt ist das Aufsetzen eines Vhosts für die Applikation.</p>

<label>Conf Vhost</label>
<?php start_highlight(); ?>
<VirtualHost 123.123.123.123:443>

  ServerAdmin adminOfTheDay@webfrap.net
  ServerName demo.webfrap.net

  DocumentRoot /srv/universe/demo/SDB_Gw_SBiz

  # don't loose time with IP address lookups
  HostnameLookups Off

  # needed for named virtual hosts
  UseCanonicalName Off
  
  # configures the footer on server-generated documents
  ServerSignature Off   
  
  # configure etags
  FileETag MTime Size
  <IfModule mod_expires.c>
    <filesmatch "\.(jpg|gif|png|css|js|zip|json|html|xml|flv|mpg|avi)$">
         ExpiresActive on
         ExpiresDefault "access plus 1 year"
     </filesmatch>
  </IfModule>
    
  # php app typen definieren
  AddType application/x-httpd-php .php .tpl

  #   SSL Engine Switch:
  #   Enable/Disable SSL for this virtual host.
  SSLEngine on

  #   SSL Cipher Suite:
  #   List the ciphers that the client is permitted to negotiate.
  #   See the mod_ssl documentation for a complete list.
  SSLProtocol all
  SSLCipherSuite HIGH:MEDIUM

  SSLCertificateFile    /etc/apache2/ssl/demo.pem
  SSLCertificateKeyFile /etc/apache2/ssl/demo.key


  <Directory "/srv/universe/demo/WebFrap_Gw_Demo">
    Options None
    Order allow,deny
    Allow from all
    AllowOverride None


    SSLOptions +StdEnvVars
    SSLRequireSSL

#    AuthType Basic
#    AuthName "DEMO"
#    AuthBasicProvider file
#    AuthUserFile /etc/apache2/htpasswd
#    AuthGroupFile /etc/apache2/htgroup
#    Require group demo
  </Directory>
  
  # Verhindern, dass auf die Code und Datenordner zugegriffen werden kann
  <Location /tmp>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /cache>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /data>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /conf>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /modules>
    Order allow,deny
    Deny from all
  </Location>

  <Location /src>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /templates>
    Order allow,deny
    Deny from all
  </Location>
  
  <Location /.hg>
    Order allow,deny
    Deny from all
  </Location>

  # Style
  Alias /icons /srv/universe/demo/WebFrap_Icons_Default

  # Wgt
  Alias /wgt /srv/universe/demo/WebFrap_Wgt

  # Theme
  Alias /themes /srv/universe/demo/WebFrap_Theme_Default

  ErrorDocument 400 "/error.php?l=400"
  ErrorDocument 401 "/error.php?l=401"
  ErrorDocument 403 "/error.php?l=403"
  ErrorDocument 404 "/error.php?l=404"
  ErrorDocument 405 "/error.php?l=405"
  ErrorDocument 500 "/error.php?l=500"

  ErrorLog "/var/log/apache2/demo/error.log"

  # Possible values include: debug, info, notice, warn, error, crit,
  # alert, emerg.
  LogLevel warn

  CustomLog "/var/log/apache2/demo/access.log" combined

</VirtualHost>
<?php display_highlight( 'xml' ); ?>