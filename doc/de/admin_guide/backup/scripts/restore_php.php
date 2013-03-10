<h1>restore.php</h1>

<a href="./files/scripts/restore.txt" >Download File</a><br />
<br />
<?php start_highlight(); ?>
<?php echo PHP_TAG ?>

// die Basis Logik einbinden
// hier wird auch das entsprechende conf / settingsfile eingebunden
// in welchem die hier verwendetetn Variablen vorhanden sind.
include './deploy_core.php';


Console::head( "Start backup", true );

$backupKey = Request::arg( 'key' );
$backupGw   = Request::arg( 'gateway' );

if( !$backupKey )
  $backupKey = date('Ymdhis');
  
foreach( $deplGateways as $gateway )
{
  
  if( $backupGw && $backupGw != $gateway['name'] )
    continue;
    
  Console::outl( 'Backup Gateway '.$gateway['name'], true );
    
  $bckTmp = $tmpFolder.$gateway['name'].'-'.$backupKey;
    
  Fs::mkdir( $tmpFolder.$gateway['name'].'-'.$backupKey );
  
  Fs::copy( $deployPath.$gateway['name'].'/data/uploads' , $bckTmp.'/uploads' );
  
  Fs::mkdir( $tmpFolder.$gateway['name'].'-'.$backupKey.'/dump' );

  Db::backup
  ( 
    $setupDb['db'][$gateway['name']], 
    $tmpFolder.$gateway['name'].'-'.$backupKey.'/dump/backup.dump' 
  );
  
  Fs::chdir( $tmpFolder );
  
  if( !Fs::exists( $backupFolder ) )
    Fs::mkdir( $backupFolder );
  
  Archive::pack
  (  
    $backupFolder.'/'.$gateway['name'].'-'.$backupKey.'.tar.bz2',
    $bckTmp
  );
  
  Fs::del( $bckTmp );
  
}


Console::footer( "Backup completed ", true );
<?php display_highlight( 'php' ); ?>