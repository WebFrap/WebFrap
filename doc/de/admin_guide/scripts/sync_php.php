<h1>sync.php</h1>

<a href="./files/scripts/sync.txt" >Download File</a><br />
<br />
<?php start_highlight(); ?>
<?php echo PHP_TAG ?>

// die Basis Logik einbinden
// hier wird auch das entsprechende conf / settingsfile eingebunden
// in welchem die hier verwendetetn Variablen vorhanden sind.
include './deploy_core.php';


Console::head( "Start sync", true );

// eine Temporäre HG RC Datei erstellen, wird benötigt
// um die Passwörter nicht in die URL packen zu müssen oder bei Proxies
Hg::createTmpRc
( 
  $repoRoot,
  $syncRepos,
  $displayName,
  $repoUser,
  $repoPwd
);

Hg::sync( $syncRepos, $contactMail );
Fs::chown( $repoRoot, $repoOwner );


Console::footer( "Finished sync ", true );
<?php display_highlight( 'php' ); ?>