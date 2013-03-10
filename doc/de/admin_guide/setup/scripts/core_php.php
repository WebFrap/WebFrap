<h1>deploy_core.php</h1>

<a href="./files/scripts/deploy_core.txt" >Download File</a><br />
<br />
<?php start_highlight(); ?>
<?php echo PHP_TAG ?>

///
/// NEIN, DIES DATEI ERHEBT NICHT DEN ANSPRUCH OOP ZU SEIN
/// ES IS EXPLIZIT AUCH NICHT ALS OOP GEWOLLT, DIE KLASSEN WER
///

define('NL',"\n");

if( 'cli' == php_sapi_name() )
  define( 'IS_CLI', true );
else
  define( 'IS_CLI', false );

/**
 * Ausgabe in die Console
 */
class Console
{
  
  /**
   * Einfach ausgabe des Textes
   * @param string $text
   */
  static function out( $text, $appendDate = false  )
  {
    
    if( $appendDate )
      $text .= date('Y-m-d');
    
    echo $text;
    flush();
    
  }//end static function out */
  
  /**
   * Neue Zeile schreiben
   * @param string $text
   */
  static function outl( $text, $appendDate = false  )
  {
    
    if( $appendDate )
      $text .= date('Y-m-d');
    
    if( IS_CLI )
      echo $text.NL;
    else 
      echo $text.NL."<br />";
    
    flush();
    
  }//end static function outl */
  
  /**
   * Head Bereich
   * @param string $text
   */
  static function header( $text, $appendDate = false  )
  {
    
    if( $appendDate )
      $text .= date('Y-m-d');
    
    if( IS_CLI )
    {
      echo "################################################################################".NL;
      echo "# ".$text.NL;
      echo "################################################################################".NL;
    }
    else 
    {
      echo "<h1>".$text."<h1>".NL;
    }
    
    flush();
    
  }//end static function header */
  
  /**
   * Head Bereich
   * @param string $text
   */
  static function chapter( $text, $appendDate = false )
  {
    
    if( $appendDate )
      $text .= date('Y-m-d');
    
    if( IS_CLI )
    {
      echo "# ".$text.NL;
      echo "################################################################################".NL;
    }
    else 
    {
      echo "<h2>".$text."<h2>".NL;
    }
    
    flush();
    
  }//end static function chapter */
  
  /**
   * Head Bereich
   * @param string $text
   */
  static function footer( $text, $appendDate = false  )
  {
    
    if( $appendDate )
      $text .= date('Y-m-d');
    
    if( IS_CLI )
    {
      echo "________________________________________________________________________________".NL;
      echo "|".NL;
      echo "| ".$text.NL;
      echo "|_______________________________________________________________________________".NL;
    }
    else 
    {
      echo "<br /><strong>".$text."<strong><br />".NL;
    }
    
    flush();
    
  }//end static function head */
  
  /**
   * Block Starten
   */
  static function startBlock( )
  {
    
    if( IS_CLI )
    {
      echo "---------------------------------------------------------------------------------".NL;
    }
    else 
    {
      echo "<pre>".NL;
    }
    
    flush();
    
  }//end static function chapter */
  
  /**
   * Block beenden
   */
  static function endBlock( )
  {
    
    if( IS_CLI )
    {
      echo "---------------------------------------------------------------------------------".NL;
    }
    else 
    {
      echo "</pre>".NL;
    }
    
    flush();
    
  }//end static function endBlock */
  
}//end class Console */

/**
 * Klasse zum ausführen von Programmen
 */
class Process
{
  
  /**
   * @param string $command
   */
  static function run( $command )
  {
    $result = '';
    if ($proc = popen("($command)2>&1","r") )
    {
      while (!feof($proc))
        echo fgets($proc, 1000);
  
      pclose($proc);

    }
    
  }//end static function run */
  
  /**
   * @param string $command
   */
  static function execute( $command )
  {
    $result = '';
    if ($proc = popen("($command)2>&1","r") )
    {
      while (!feof($proc))
        $result .= fgets($proc, 1000);
  
      pclose($proc);
  
      return $result;
    }
    
  }//end static function execute */
  
}//end class Process */

/**
 * Filesystem
 */
class Fs
{
  
  /**
   * Den aktuellen Pfad des Scriptes ändern
   * @param string $path
   */
  static function chdir( $path )
  {
    
    chdir($path);
    
  }//end static function chdir */
  
  /**
   * Den aktuellen Pfad des Scriptes ändern
   * @param string $path
   */
  static function exists( $path )
  {
    
    return file_exists( $path );
    
  }//end static function exists */
  
  /**
   * Datei oder Ordner rekursiv kopieren
   * 
   * @param string $src
   * @param string $target
   * @param boolean $isFolder
   */
  static function copy( $src, $target, $isFolder = true )
  {
    
    if( $isFolder && !file_exists($target) )
    {
      Fs::mkdir( $target );
    }
    
    Process::run("cp -rfv $src $target");
    
  }//end static function copy */

  /**
   * Datei oder Verzeichniss rekursiv löschen
   * @param string $path
   */
  static function del( $path )
  {    
    
    Process::run("rm -rfv $path");
    
  }//end static function del */
  
  /**
   * Ein Verzeichnis, bei bedarf rekursiv, erstellen
   * 
   * @param string $path
   * @param int $mode
   */
  static function mkdir( $path, $mode = 0777 )
  {    
    
    if( !file_exists($path) )
    {
      mkdir( $path, $mode, true );
    }
    
  }//end static function mkdir */
  
  /**
   * Eine Datei erstellen
   * @param string $path
   */
  static function touch( $path )
  {    
    
    Process::run( "touch $path" );
    
  }//end static function touch */
  
  /**
   * Den Besitzer einer Datei, oder eines Ordners rekursiv ändern
   * 
   * @param string $path
   * @param string $user
   */
  static function chown( $path, $user )
  {    
    Process::run( "chown -R $user $path" );
    
  }//end static function chown */
  
  /**
   * Anpassen der Dateiberechtigungen
   * 
   * @param string $path
   * @param string $level
   */
  static function chmod( $path, $level )
  {    
    Process::run( "chmod -R $level $path" );
    
  }//end static function chmod */
  
}//end class Fs */

/**
 * Klasse für das Management eines Mercurial Repository
 */
class Hg
{
  
  /**
   * Eine Temporäre HGRC erstellen, wird bei Proxies benötigt
   * und wenn user und pwd nicht direkt in der URL erscheinen sollen
   * 
   * @param string $deplPath
   * @param array $repos
   * @param string $displayName
   * @param string $userName
   * @param string $userPassd
   * @param string $proxy
   */
  public static function createTmpRc
  ( 
    $deplPath,
    $repos, 
    $displayName, 
    $userName, 
    $userPassd, 
    $proxy = null 
  )
  {
    
    $hgRc = <<<CODE

[ui]
username = {$displayName}

[web]
name = {$userName}

[trusted]
users = *
groups = *

CODE;
    
    // wenn durch einen proxy hindurchgesynct werden soll
    if( $proxy )
    {
      
      $hgRc .= <<<CODE
[http_proxy]
host = {$proxy}
user = {$userName}
passwd = {$userPassd}

CODE;
    
    }
    
    $hgRc .= <<<CODE
[auth]

CODE;

    foreach( $repos as $repoKey => $listRepos )
    {
      
      $repoPath = $listRepos['path'];
      
      foreach( $listRepos['repos'] as $repo => $tmpUrl )
      {
    
        $key = str_replace('-','_',$repoKey);
    
        $hgRc .= <<<CODE

{$repo}_{$key}.prefix = {$tmpUrl['url']}{$repo}
{$repo}_{$key}.username = {$userName}
{$repo}_{$key}.password = {$userPassd}
{$repo}_{$key}.schemes = https

CODE;
    
      }
    }

    file_put_contents(  $deplPath.'.hgrc' , $hgRc  );
    putenv( "HGRCPATH={$deplPath}.hgrc" );

  }//end public static function createTmpRc */
  
  /**
   * Repository clonen
   * @param string $url
   * @param string $repo
   * @param string $user
   * @param string $pwd
   */
  public static function cloneRepo( $url, $repo, $user = null, $pwd = null )
  {
    
    // es wird nur https zugelassen. punkt
    if( $user && $pwd )
      $url = 'https://'.$user.':'.$pwd.'@'.$url;
    else 
      $url = 'https://'.$url;

    Process::run( 'hg clone "'.$url.'" "'.$repo.'"' );
    
  }//end public static function cloneRepo */
  
  /**
   * Direkt ein bestimmtes Archiv vom Server laden anstelle zuerst zu clonen.
   * 
   * @param string $repo
   * @param string $type
   * @param string $rev
   * @param string $user
   * @param string $pwd
   */
  public static function getArchive( $url, $type, $rev = null, $user = null, $pwd = null )
  {
    
    if( $user && $pwd )
      $url = 'https://'.$user.':'.$pwd.'@'.$url;
    else 
      $url = 'https://'.$url;
      
    Process::run( 'wget "'.$url.'"' );
    
  }//end public static function getArchive */
  
  /**
   * Ein Archive aus einem geclonten repository erstellen
   * @param string $repo
   * @param string $rev
   * @param string $type
   */
  public static function archive( $target, $rev = null, $type = null  )
  {
    
  }//end public static function archive */
  
  /**
   * Repository clonen
   * @param string $rev
   */
  public static function update( $rev = null  )
  {
    
    $command = "hg update";
    
    if( $rev )
    {
      
      $tmp = explode( ':',$rev  );
      
      if( $rev[0] == 'ref' )
        $command .= "-C -r ".$rev[1];
      else 
        $command .= " ".$rev[1].'  -C';
    }
    else 
    {
      $command .= ' -C';
    }
    
    Process::run( $command );
    
  }//end public static function update */
  
  /**
   * Änderungen commiten
   */
  public static function commit( $message = 'Autocommit' )
  {
    
    Process::run( 'hg commit -A -m "'.$message.'"' );
     
  }//end public static function commit */
  
  /**
   * Auf einen Server pushen
   * @param string $url
   * @param string $user
   * @param string $pwd
   */
  public static function push( $url, $user = null, $pwd = null    )
  {
    
    // es wird nur https zugelassen. punkt
    if( $user && $pwd )
      $url = 'https://'.$user.':'.$pwd.'@'.$url;
    else 
      $url = 'https://'.$url;

    Process::run( 'hg push -f "'.$url.'" "'.$repo.'"' );
    
  }//end public static function push */
  
  /**
   * Von einem Server pullen
   * @param string $url
   * @param string $user
   * @param string $pwd
   */
  public static function pull( $url, $user = null, $pwd = null )
  {
    
    // es wird nur https zugelassen. punkt
    if( $user && $pwd )
      $url = 'https://'.$user.':'.$pwd.'@'.$url;
    else 
      $url = 'https://'.$url;

    Process::run( 'hg pull -f "'.$url.'" "'.$repo.'"' );
    
  }//end public static function pull */
  
  /**
   * Methode zum synchronisieren mehrere Repositories zwischen einem Lokalen
   * Repository Server und einem oder meheren anderen Repository Servern
   * 
   * @param array $repos
   */
  public static function sync( $repos, $contactMail )
  {
    
    foreach( $repos as $repoKey => $listRepos )
    {
      $repoPath = $listRepos['path'];
      
      foreach( $listRepos['repos'] as $repoName => $repoData )
      {
        if( Fs::exists( $repoPath.'/'.$repoName) )
        {
          
          Fs::chdir( $repoPath.$repoName );
          
          Console::chapter( "Sync {$repoData['url']}{$repoName} ".date('Y-m-d') );
          
          Console::startBlock(  );
          Hg::pull
          (
            $repoData['url'].$repoName,
            (isset($repoData['user'])?$repoData['user']:null), 
            (isset($repoData['pwd'])?$repoData['pwd']:null) 
          );
          
          Hg::push
          ( 
            $repoData['url'].$repoName,
            (isset($repoData['user'])?$repoData['user']:null), 
            (isset($repoData['pwd'])?$repoData['pwd']:null) 
          );
          
          Console::endBlock();
          
        }
        else
        {
          
          Console::chapter( "Clone {$repoData['url']}{$repoName} ".date('Y-m-d') );
          Console::startBlock(  );
          Fs::chdir( $repoPath );

          Hg::cloneRepo
          ( 
            $repoData['url'].$repoName, 
            $repoPath.'/'.$repoName,
            (isset($repoData['user'])?$repoData['user']:null), 
            (isset($repoData['pwd'])?$repoData['pwd']:null)
          );
          
          // hgweb.config sollte bitte existieren, sonst schreiben wir keine
          if( Fs::exists( $repoPath.'hgweb.config' ) )
          {
            Process::run( 'echo "'.$repoName.' = ' .$repoPath.'/'.$repoName.'" >> hgweb.config' );
            Process::run( 'echo "[web]" > ./'.$repoName.'/.hg/hgrc' );
            Process::run( 'echo "contact = '.$contactMail.'" >> ./'.$repoName.'/.hg/hgrc' );
            Process::run( 'echo "allow_archive = gz, zip, bz" >> ./'.$repoName.'/.hg/hgrc' );
            Process::run( 'echo "allow_push = *' );
          }

          Console::endBlock();
          
        }
        
      }//end foreach
      
    }//end foreach
    
  }//end public static function sync */
  
}//end class Hg */

/**
 * Klasse zum entpacken von Archiven
 */
class Archive
{
  
  /**
   * @param string $fileName
   */
  public static function unpack( $fileName  )
  {
    
    $tmp     = explode( '.', $fileName );
    $ending  = $tmp[count($tmp)-1];
    
    switch( $ending )
    {
      case 'tar':
      {
        Process::run( "tar xvf ".$fileName );
        return null;
      }
      
      case 'gz':
      {
        Process::run( "tar xzvf ".$fileName );
        return null;
      }
      
      case 'bz2':
      {
        Process::run( "tar xjvf ".$fileName );
        return null;
      }
      
      case 'zip':
      {
        Process::run( "unzip ".$fileName );
        return null;
      }
        
      default:
      {
        return 'Unknown Archive Type: '.$ending;
      }
      
    }

  }//end public static function unpack */
  
}//end class Archive */
<?php display_highlight( 'php' ); ?>