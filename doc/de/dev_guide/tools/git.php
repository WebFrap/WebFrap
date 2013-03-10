<h1>Git</h1>

<a href="http://git-scm.com/" >http://git-scm.com/</a><br />
<a href="http://git-scm.com/book" >http://git-scm.com/book</a>


<p>Setzen des Namens und der Adresse.</p>

<?php start_highlight(); ?>
# Setzen des Namens
git config --global user.name "Vorname Nachname"
# Setzen der E-Mail adresse
git config --global user.email "vorname.nachname@webfrap.net"
<?php display_highlight( 'bash' ); ?>

<p>Setze einiger Defaults</p>

<?php start_highlight(); ?>
# per default alle änderungen ins repository pushen
git config --global push.default "matching"
# unnötige commits vermeiden
git config --global branch.autosetuprebase always 
<?php display_highlight( 'bash' ); ?>