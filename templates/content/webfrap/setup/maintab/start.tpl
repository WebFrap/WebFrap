<div class="wgt-panel title" >
  <h2>Test System</h2>
</div>


<div style="width:400px;" >
  <table class="wgt-table full" >

  <thead>
    <tr>
      <th>Key</th>
      <th>Value</th>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td>PHP Version:</td>
      <td><?php echo  phpversion(); ?></td>
    </tr>
    <tr>
      <td colspan="2" ><h3>Check Extensions</h3></td>
    </tr>
    <tr>
      <td>CType</td>
      <td><?php echo extension_loaded('ctype')?'loaded':'not loaded'; ?></td>
    </tr>
    <tr>
      <td>PgSql</td>
      <td><?php echo extension_loaded('pgsql')?'loaded':'not loaded'; ?></td>
    </tr>
    <tr>
      <td>PDO</td>
      <td><?php echo extension_loaded('PDO')?'loaded':'not loaded'; ?></td>
    </tr>
    <tr>
      <td>pdo_pgsql</td>
      <td><?php echo extension_loaded('pdo_pgsql')?'loaded':'not loaded'; ?></td>
    </tr>
    <tr>
      <td>pdo_sqlite</td>
      <td><?php echo extension_loaded('pdo_sqlite')?'loaded':'not loaded'; ?></td>
    </tr>
    <tr>
      <td>ldap</td>
      <td><?php echo extension_loaded('ldap')?'loaded':'not loaded'; ?></td>
    </tr>
    <tr>
      <td>GD</td>
      <td><?php echo extension_loaded('gd')?'loaded':'not loaded'; ?></td>
    </tr>
    <tr>
      <td>JSON</td>
      <td><?php echo extension_loaded('json')?'loaded':'not loaded'; ?></td>
    </tr>

  <?php /*
  #
  bcmath
bz2
calendar
Core
ctype
curl
date
dba
dom
ereg
exif
fileinfo
filter
ftp
gd
gettext
hash
iconv
imagick
imap
json
ldap
libxml
mbstring
mcrypt
memcached
mhash
mysql
mysqli
openssl
pcntl
pcre
PDO
pdo_mysql
pdo_pgsql
pdo_sqlite
pgsql
Phar
posix
readline
Reflection
session
shmop
SimpleXML
soap
sockets
SPL
SQLite
sqlite3
standard
sysvmsg
sysvsem
sysvshm
tokenizer
wddx
xdebug
xml
xmlreader
xmlwriter
zip

  */ ?>

  </tbody>

  </table>
</div>

<div class="label" ><h2>Create Database</h2></div>
<div>
  <form action=""></form>
</div>
