<h1>Apache Setup</h1>

<p></p>

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