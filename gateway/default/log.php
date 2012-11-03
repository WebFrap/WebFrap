<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
* 
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/


  ob_start();
  session_name('WEBFRAP_GW_EXAMPLE');
  session_start();
  error_reporting(0);
  ob_end_clean();

  if( function_exists('xdebug_is_enabled') )
    define( 'DEBUGGER' , true );
  else
    define('DEBUGGER' , false );

  if( isset( $_GET["reset"]) )
  {
    $_SESSION['SCREENLOG']    = array();
    $_SESSION['PHPLOG']       = array();
    $_SESSION['TRACES']       = array();
    $_SESSION['DUMPS']        = array();
    $_SESSION['BUFFERD_OUT']  = null;
  }

?>
<html>
<head>
<title>Log Screen</title>

<style>

h1{
  color:#FFFCDB;
}

h2{
  color:#FFFCDB;
}

h3{
  color:#FFFCDB;
}

body{
  background-color:#474747;
}

table{
  padding:0px;
  margin:0px;
  font-size:10px;
}

.trace {
    color : #F199FF;
    font-style : italic;
  }

.debug {
    color:#34BB3D;
  }

.verbose {
    color:#AEFF3D;
    font-weight:bold;
  }

.user {
    color:#4E588E;
    font-style : italic;
  }

.info {
    color:#07C9FF;
    font-style : italic;
    font-weight:bold;
  }

.config {
    color:#3A44FF;
  }

.warn {
    color:#E39C45;
  }

.error {
    color:#FF1D1D;
  }

.security {
    color:#FF2FE0;
    font-weight:bold;
  }

.fatal {
    color:#DA0000;
    font-weight:bold;
  }

.key {
    color:#E9E9E9;
    width:35px;
}

.dumpText
{
  color:#ffffc1;
  font-size:10px;
}
</style>
<script type="application/javascript">

function openClose( idName )
{

  var s_link = document.getElementById( 'link'+idName );
  var s_box  = document.getElementById( 'box'+idName );

  if( s_box.style.display != 'none' )
  {
    //alert('open');
    s_link.innerHTML      = 'open';
    s_box.style.display   = 'none';
  }
  else
  {
    //alert('close');
    s_link.innerHTML      = 'close';
    s_box.style.display   = '';
  }

}
</script>

</head>

<body>

<h2>Manage Logs</h2>

<p><a style="color:#ffffff;" href="log.php">Logs neu laden</a></p>
<p><a style="color:#ffffff;" href="log.php?reset=true">Logs löschen</a></p>

<h2>Abgefangener Output</h2>
<a id="linkMessages" href="javascript:openClose('Messages')">close</a>
<div id="boxMessages" >
<pre><?php echo $_SESSION['BUFFERD_OUT'] ?></pre>
</div>


<h2>Webfrap Log</h2>
<a id="linkLOG" href="javascript:openClose('LOG')">close</a>
<div id="boxLOG" >


<?php
$Width = array
(
0 => '180px',
1 => '70px',
2 => '300px',
3 => '60px',
4 => '300px'
);

if( isset( $_GET['ses']))
  $logName = $_GET['ses'];
else
  $logName = 'SCREENLOG';

$maxLenght = 5000;

$pos = isset($_GET['pos'])?$_GET['pos']:0;
$size = count($_SESSION[$logName]);

$till = $pos + $maxLenght;

if( $till > $size )
{
  $till = $size;
  $pos = $size - $maxLenght;
}

if( $pos < 0 )
{
  $pos = 0;
}

echo 'LogSize: '.$size.'<br />';
echo 'MaxLenght: '.$maxLenght.'<br />';

?>

<table cellspacing="0" >

<?php
for( $key = $pos ;  $key < $till ; ++$key  )
{

  $message = $_SESSION[$logName][$key];

  $back = explode("\t" , $message);
  switch($back['1'] )
  {
    case 'TRACE':
    {
      $class = 'trace';
      break;
    }
    case 'DEBUG':
    {
      $class = 'debug';
      break;
    }
    case 'CONFIG':
    {
      $class  = 'config';
      break;
    }
    case 'VERBOSE':
    {
      $class  = 'verbose';
      break;
    }
    case 'USER':
    {
      $class  = 'user';
      break;
    }
    case 'INFO':
    {
      $class   = 'info';
      break;
    }
    case 'WARN':
    {
      $class    = 'warn';
      break;
    }
    case 'ERROR':
    {
      $class     = 'error';
      break;
    }
    case 'SECURITY':
    {
      $class     = 'security';
      break;
    }
    case 'FATAL':
    {
      $class      = 'fatal';
      break;
    }
  }


  echo "<tr>\n<td class=\"key\" width=\"90px\" >$key:</td>\n";
  foreach( explode( "\t" , $message ) as $Key => $part )
  {
    echo "<td class=\"$class\" width=\"".$Width[$Key]."\" >$part</td>\n";
  }
  echo "</tr>\n";
}
?>

</table>

<?php

$anz = round( ($size / $maxLenght) )+1;

for( $pos = 0 ; $pos < $anz ; ++$pos )
  echo '<a href="index.php?pos='.($pos*$maxLenght).'">'.$pos.'</a>&nbsp;';

?>

</div>

<h2>PHP Error Log</h2>
<a id="linkPHP" href="javascript:openClose('PHP')">close</a>
<div id="boxPHP" >

<?php
if( isset($_SESSION['PHPLOG']) )
{

  echo "<table cellspacing=\"0\">\n";

  foreach( $_SESSION['PHPLOG'] as $Line => $message )
  {

    switch( $message['1'] )
    {

      case 'STRICT':
      {
        $class = "trace";
        break;
      }
      case 'NOTICE':
      case 'USER_NOTICE':
      {
        $class = "debug";
        break;
      }
      case 'USER_WARNING':
      {
        $class  = "verbose";
        break;
      }
      case 'WARNING':
      case 'COMPILE_WARNING':
      case 'CORE_WARNING':
      {
        $class    = "warn";
        break;
      }
      case 'COMPILE_ERROR':
      case 'ERROR':
      case 'CORE_ERROR':
      {
        $class     = "error";
        break;
      }
      case 'USER_ERROR':
      case 'PARSE':
      {
        $class      = "fatal";
        break;
      }
    }
    echo "<tr>\n<td class=\"key\" width=\"70\" >$Line :</td>\n";
    foreach( $message as $Key => $part )
    {
      echo "<td class=\"$class\" width=\"".$Width[$Key]."\" >$part</td>\n";
    }
    echo "</tr>\n";
  }

  echo "</table>\n";

}
?>
</div>


<h2>List of Files</h2>
<a id="linkFILES" href="javascript:openClose('FILES')">close</a>
<div class="dumpText" id="boxFILES" >
<p>Es wurden <%=count($_SESSION['FILES'])  %> eingebunden:</p>
<ul>
<?php
  if( isset($_SESSION['FILES']) )
    foreach( $_SESSION['FILES'] as $file )
      echo "<li>$file</li>\n";

?>
</ul>
</div>

<h2>Debug Traces</h2>
<a id="linkTRACES" href="javascript:openClose('TRACES')">close</a>
<div class="dumpText" id="boxTRACES" >
<?php
  if( isset($_SESSION['TRACES']) )
  {
    foreach( $_SESSION['TRACES'] as $Line => $Trace )
    {
      echo "<h3>Trace: $Line</h3>\n";
      echo '<p><a id="linkTRACES'.$Line.'" href="javascript:openClose(\'TRACES'.$Line.'\')">open</a></p>';
      echo '<div id="boxTRACES'.$Line.'" style="display:none;">';
      echo '<pre>'.$Trace.'</pre>';
      echo '</div>';

    }
  }
?>
</div>



<h2>Dumps</h2>

<a id="linkDUMPS" href="javascript:openClose('DUMPS')">close</a>
<div class="dumpText" id="boxDUMPS" >

<?php
// Ausgaben der gedumpten Dateien
if( isset($_SESSION['DUMPS']) )
{

  foreach( $_SESSION['DUMPS'] as $Line => $Dump )
  {
    echo "<h3>Dump: $Line</h3>\n";
    echo "<p>".$Dump['message']."</p>";
    echo '<p><a id="linkDUMPS'.$Line.'" href="javascript:openClose(\'DUMPS'.$Line.'\')">open</a></p>';
    echo '<div id="boxDUMPS'.$Line.'" style="display:none;">';

    if(DEBUGGER)
      echo $Dump['dump'];
    else
      echo "<pre>".htmlentities($Dump['dump'])."</pre>";

    echo "</div>";
  }


}
?>
</div>

<h2>Session Dump</h2>

<?php
$sessionData = serialize($_SESSION);
$dumpSize = strlen(serialize($_SESSION['DUMPS']));
$traceSize = strlen(serialize($_SESSION['TRACES']));
$fileSize = strlen(serialize($_SESSION['FILES']));
$bufferdOutSize = strlen(serialize($_SESSION['BUFFERD_OUT']));
$screenlogSize = strlen(serialize($_SESSION['SCREENLOG']));

$debugSize = $dumpSize + $traceSize + $bufferdOutSize + $screenlogSize;

$sessionSize = strlen($sessionData);

echo "<h3>Sessionsize = ".round( ($sessionSize / 1024 ) , 2 )." Kb</h3>";

echo "<ul>
<li>Size Debug: ".round( $debugSize / 1024 , 2)." Kb</li>
<li>Size Persistence Data: ".round( ($sessionSize - $debugSize)  / 1024 , 2)." Kb</li>
<li>Size Dumps: ".round( $dumpSize / 1024 , 2)." Kb</li>
<li>Size Traces: ".round( $traceSize / 1024 , 2)." Kb</li>
<li>Size Files: ".round( $fileSize / 1024 , 2)." Kb</li>
<li>Size Bufferd Output: ".round( $bufferdOutSize / 1024 , 2)." Kb</li>
<li>Size Logdata: ".round( $screenlogSize / 1024 , 2)." Kb</li>
</ul>";

?>

</div>


</body>
</html>