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

/**
 * @package WebFrap
 * @subpackage tech_core
 */
final class SParserString
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct(){}

  /**
   *  the values of an array to a comma sperated String
   * and remove the last Comma
   *
   * @param array $arr
   * @return String
   */
  public static function arrayToComSepStr($arr )
  {

    return implode( ', ', $arr );

  }//end public static function arrayToComSepStr */

  /**
   *  the values of an array to a comma sperated String
   * and remove the last Comma
   *
   * @param Simplexml $xml
   * @param String $key
   * @return String
   */
  public static function xmlToComSepStr($xml , $key )
  {

    $ret = '';

    if (! isset($xml->$key)  )
      return '';

    foreach($xml->$key as $a )
    {
      $ret .= " ".(string)$a.",";
    }

    // remove last
    if ($ret != ''  )
    {
      $ret = substr($ret,0,-1);
    }

    return $ret;

  }//end public static function xmlToComSepStr */

  /**
   *
   * @param array $data
   * @return string
   */
  public static function arrayToArrayElements($data )
  {

    $output = '';

    foreach($data as $tmp)
    {
      if (trim($tmp) =='')
      {
        continue;
      }

      $output .= '\''.$tmp.'\', ';
    }

    return substr($output,0,-2);

  }//end public static function arrayToArrayElements */

  /**
   * Enter description here...
   *
   * @param array $data
   * @return string
   */
  public static function prioArrayToString($data )
  {
    $output = '';

    krsort($data );

    foreach($data as $tmp)
    {
      $output .= implode($tmp , NL  );
    }

    return $output;

  }//end public static function prioArrayToString */

  /**
   * @param string $str
   * @param boolean $firstSmall
   */
  public static function subToCamelCase($str , $firstSmall = false )
  {

    /*
    if (!strpos($str, '_'))
    {
      if ($firstSmall )
      {
        return $str;
      } else {
        return ucfirst($str);
      }
    }
    */

    $tmp = explode( '_' , trim($str) );
    $camelCase = '';

    foreach($tmp as $case )
    {
      $camelCase .= ucfirst($case);
    }

    $tmp2       = explode( '-' , trim($camelCase) );
    $camelCase2 = array();

    foreach($tmp2 as $case2 )
    {
      $camelCase2[] = ucfirst($case2);
    }

    $camelCase = implode( '_', $camelCase2 );

    if ($firstSmall && isset($camelCase[0] ) )
      $camelCase[0] = mb_strtolower($camelCase[0] );

    return $camelCase;

  }//end public static function subToCamelCase */

  /**
   * @param string $str
   * @param boolean $firstSmall
   */
  public static function subToModule($str, $firstSmall = false  )
  {

    if (!strpos($str, '_' ) )
    {
      if ($firstSmall )
      {
        return $str;
      } else {
        return ucfirst($str );
      }
    }

    $tmp = explode( '_' , trim($str ) );
    $tmp = explode( '-' , trim($tmp[0] ) );

    if ($firstSmall )
      return array_shift($tmp);
    else
      return ucfirst(array_shift($tmp));

  }//end public static function subToModule */

  /**
   * @param string $str
   * @param boolean $firstSmall
   */
  public static function subToPackage($str, $firstSmall = false  )
  {

    if (!strpos($str, '_'))
    {
      if ($firstSmall )
      {
        return $str;
      } else {
        return ucfirst($str);
      }
    }

    $tmp = explode( '_' , trim($str) );

    array_pop($tmp);

    return str_replace( '-', '_', implode( '.', $tmp ) ) ;

  }//end public static function subToPackage */

  /**
   * einen domainkey vom sub format in Mod.Domain umwandeln, z.B
   *
   * project_taks_employee zu Project.TaskEmployee
   *
   * @param string $str
   * @return string
   */
  public static function subToUrl($str )
  {

    if (!strpos($str, '_'))
    {
      return ucfirst($str);
    }

    $tmp   = explode( '_' , trim($str) );

    $mod   = ucfirst( array_shift($tmp) ) ;
    $contr = '';

    foreach($tmp as $node )
    {
      $contr .= ucfirst($node);
    }

    $contr = str_replace('-', '_', $contr);

    return "{$mod}.{$contr}";

  }//end public static function subToUrl */

  /**
   *
   */
  public static function subToName($str , $shift = false )
  {

    $tmp = explode( '_' , trim($str) );

    if ($shift)
    {
      // shift only if there are more than one parts
      if ( count($tmp > 1 ) )
        array_shift($tmp);
    }
    elseif ($tmp[0] == 'id' )
    {
      array_shift($tmp);
    }

    $tmp2 = array();

    foreach($tmp as $node)
      $tmp2[] = ucfirst($node);

    return implode( ' ' , $tmp2  ) ;

  }//end public static function subToName */

  /**
   *
   */
  public static function ucAll($parts )
  {

    if (!is_array($parts) )
    {
      $parts = explode(' ',$parts);
    }

    $tmp2 = array();

    foreach($parts as $node)
      $tmp2[] = ucfirst($node);

    return implode( ' ' , $tmp2  ) ;

  }//end public static function ucAll */

  /**
   *
   */
  public static function subBody($subString )
  {

    $tmp = explode( '_' , trim($subString) );

    array_shift($tmp);

    return str_replace( '-', '_', implode( '_' , $tmp  ) );

  }//end public static function subBody */

  /**
   * @param string $code
   * @param int $idention
   */
  public static function setIndentinon($code, $idention )
  {

    $lines     = explode( NL, $code );
    $indLines  = array();

    $ident     = str_repeat( '  ', $idention );

    $newCode   = '';

    foreach($lines as $line )
    {
      $indLines[] = $ident.$line;
    }

    return implode( NL, $indLines );

  }//end public static function setIndentinon */

  /**
   * @param string $subString
   * @param string $delimiter
   * @param string $backdelimiter
   */
  public static function getStringgBody($subString , $delimiter = '_' , $backdelimiter = '_' )
  {

    $tmp = explode($delimiter , trim($subString) );

    array_shift($tmp);

    return implode($delimiter , $tmp  ) ;

  }//end public static function getStringBody */

  /**
   *
   * @param string $subString
   * @param string $delimiter
   * @return mixed
   */
  public static function getStringHead($subString , $delimiter = '_' )
  {

    $tmp = explode($delimiter , trim($subString) );

    return array_shift($tmp);

  }//end public static function getStringHead */

  /**
   * Einen Namen in einen valide Access Key für die Datenbank umbauen
   * @param string $name
   * @return string
   */
  public static function nameToAccessKey($name )
  {
    $clean = array
    (
      '&'  => '_',
      '-'  => '_',
      ' '  => '_',
      '/'  => '_',
      '@'  => '_',
      "'"  => '_',
      '"'  => '_',
      ':'  => '_',
      '^'  => '_',
      '+'  => '_',
      '__'  => '_',
    );

    $tmp  = explode('(',$name);
    $tmp2 = explode(',',$tmp[0]);

    $key = mb_strtolower
    (
      str_replace
      (
        array_keys($clean) ,
        array_values($clean) ,
        trim($tmp2[0])
      )
    );

    return substr($key, 0, 35  );
  }//end public static function nameToAccessKey */

  /**
   * @param string $className
   * @return string
   */
  public static function camelCaseToSub($className  )
  {

      $start = 0;
      $end   = 1;
      $package = '';

      $length = mb_strlen($className);

      for($pos = 1 ; $pos < $length  ; ++$pos )
      {
        if ( ctype_upper($className[$pos]) )
        {
          $package .= mb_strtolower(substr($className, $start, $end  )).'_' ;
          $start += $end;
          $end = 0;
        }
        ++$end;
      }

      $package .= mb_strtolower(substr($className, $start, $end  ));

      if ( isset($package[mb_strlen($package)]) && $package[mb_strlen($package)] == '_' )
      {
        $package = substr($package,0,-1);
      }

      return $package;

  }//end public static function camelCaseToSub */

  /**
   * @param string $className
   * @return string
   */
  public static function camelCaseToDot($className  )
  {
    $start = 0;
    $end   = 1;
    $package = '';

    $length = mb_strlen($className);

    for($pos = 1 ; $pos < $length  ; ++$pos )
    {
      if (ctype_upper($className[$pos]) )
      {
        $package .= mb_strtolower(substr($className, $start, $end  )).'.' ;
        $start += $end;
        $end = 0;
      }
      ++$end;
    }

    $package .= mb_strtolower(substr($className, $start, $end  ));

    if ($package[mb_strlen($package)] == '.' )
      $package = substr($package,0,-1);

    return $package;

  }//end public static function camelCaseToDot */

  /**
   * @param string $className
   * @return String
   */
  public static function camelCaseToName($className  )
  {
    $start = 0;
    $end   = 1;
    $package = '';

    $length = mb_strlen($className);

    for($pos = 1 ; $pos < $length  ; ++$pos )
    {
      if (ctype_upper($className[$pos]) )
      {
        $package .= substr($className, $start, $end ).' ' ;
        $start += $end;
        $end = 0;
      }
      ++$end;
    }

    $package .= substr($className, $start, $end );

    if ($package[mb_strlen($package)] == '.' )
      $package = substr($package,0,-1);

    return $package;

  }//end public static function camelCaseToDot */

  /**
   * @param string $className
   * @param boolean $full
   * @return String
   *
   */
  public static function getClassPath($className , $full = true )
  {

    $level = 0;
    $start = 0;
    $end   = 1;
    $package = '';

    $length = mb_strlen($className);

    for($pos = 1 ; $pos < $length  ; ++$pos )
    {
      if (ctype_upper($className[$pos]) )
      {
        $package .= mb_strtolower( str_replace( '_', '', substr($className, $start, $end  ) ) ).'/' ;
        $start += $end;
        $end = 0;
        ++$level;
        if ($level == Webfrap::MAX_PACKAGE_LEVEL )
        {
          break;
        }
      }
      ++$end;
    }

    if ($full )
    {
      $classPath = $package.$className.'.php';
    } else {
      $classPath = $package;
    }

    return $classPath;

  }//end public static function getClassPath */

  /**
   * @param int $id
   * @return String
   *
   */
  public static function getCachePath($id  )
  {

    $pos1 =  $id % 100;
    $pos2 =  $pos1 % 10;

    return '/'.(int)($pos1/10).'/'.$pos2.'/';

  }//end public public static function getCachePath */

  /**
   * @return String
   *
   */
  public static function idToPath($id  )
  {

    $pos1 =  $id % 100;
    $pos2 =  $pos1 % 10;

    return '/'.(int)($pos1/10).'/'.$pos2.'/';

  }//end public public static function idToPath */

  /**
   * @return String
   *
   */
  public static function getFirstHump($className )
  {
    $end   = 1;

    $hump = $className;

    $length = mb_strlen($className);

    for($pos = 1 ; $pos < $length  ; ++$pos )
    {
      if (ctype_upper($className[$pos]) )
      {
        $hump = substr($className, 0, $end  );
        break;
      }
      ++$end;
    }

    return $hump;

  }//end public static function getFirstHump */

  /**
   * @return String
   *
   */
  public static function getBodyHumps($className )
  {

    $end   = 1;

    $hump = $className;

    $length = mb_strlen($className);

    for($pos = 1 ; $pos < $length  ; ++$pos )
    {

      if (ctype_upper($className[$pos]) )
      {
        $hump = substr($className, -($length-$end) );
        break;
      }
      ++$end;
    }

    return $hump;

  }//end public static function getFirstHump */

  /**
   * @return String
   *
   */
  public static function getJsClassPath($className , $full = true )
  {
    $level = 0;
    $start = 0;
    $end   = 1;
    $package = '';

    $length = mb_strlen($className);

    for($pos = 1 ; $pos < $length  ; ++$pos )
    {
      if (ctype_upper($className[$pos]) )
      {

        $package .= mb_strtolower(substr($className, $start, $end  )).'/' ;
        $start += $end;
        $end = 0;
        ++$level;

        if ($level == Webfrap::MAX_PACKAGE_LEVEL )
          break;
      }
      ++$end;
    }

    if ($full )
      $classPath = $package.$className.'.js';
    else
      $classPath = $package;

    return $classPath;

  }//end public static function getJsClassPath */

  /**
   * @return String
   *
   */
  public static function geti18nPath($name  )
  {

    $conf  = Conf::getActive();
    $lang     = $conf->getStatus('lang');
    $lPackage = $conf->getStatus('lang_path');

    $folder = PATH_GW.'i18n/'.$lPackage.'/'.$lang.'/' ;

    $folders = explode( '.' , $name );
    array_pop($folders); // last element away

    $fileName = array_pop($folders); // get the filename

    foreach($folders as $subFolder)
      $folder .= $subFolder."/";

    $folder .= $fileName.".php";

    return $folder;

  }//end public static function geti18nPath */

  /**
   * @return String
   *
   */
  public static function getEventPath($eventName , $asString = true  )
  {

    $folder = PATH_GW.'data/events/';

    $level = 0;
    $start = 0;
    $end   = 1;
    $package = '';

    $length = mb_strlen($eventName);

    for($pos = 1 ; $pos < $length  ; ++$pos )
    {
      if ( ctype_upper($eventName[$pos]) )
      {
        $package .= mb_strtolower(substr($eventName, $start, $end  )).'/' ;
        $start += $end;
        $end = 0;
        break;
      }
      ++$end;
    }

    if ($asString)
      return $folder.$package.$eventName.'.php';

    else
      return array($folder.$package, $eventName.'.php');

  }//end public static function getEventPath */

  /**
   * Enter description here...
   *
   * @param string $name
   * @param boolean $withFile
   * @return unknown
   */
  public static function geti18nBasePath($name , $withFile = true )
  {

    $folder = '/' ;

    $folders = explode( '.' , $name );
    //array_pop($folders); // last element away

    $fileName = array_pop($folders); // get the filename

    $folder .= implode( '/', $folders ).'/';

    /*foreach($folders as $subFolder)
    {
      $folder .= $subFolder."/";
    }*/

    if ($withFile)
    {
      return $folder.$fileName.".php";
    } else {
      return $folder;
    }

  }//end public static function geti18nBasePath */

  /**
   * Enter description here...
   *
   * @param unknown_type $name
   * @param unknown_type $withFile
   * @return unknown
   */
  public static function geti18nModname($name , $lower = false )
  {

    $tmp = explode( '.' , $name , 2 );

    if ($lower )
    {
      // should be lower case, but you never know
      return mb_strtolower($tmp[0]);
    } else {
      return ucfirst($tmp[0]);
    }

  }//end public static function geti18nModname */

  /**
   * @return String
   *
   */
  public static function getModname($name , $lower = false )
  {

    $tmp = explode( '_' , $name , 2 );
    $tmp = explode( '-' , $tmp[0] , 2 );

    if ($lower )
    {
      // should be lower case, but you never know
      return mb_strtolower($tmp[0]);
    } else {
      return ucfirst($tmp[0]);
    }

  }//end public static function getModname */

  /**
   * @param string $name
   * @param boolean $lower
   * @return String
   */
  public static function getDomainName($name , $lower = false )
  {

    $tmp = explode( '_' , $name , 2 );
    $tmp = explode( '-', $tmp[0], 2 );

    if ($lower )
    {
      // should be lower case, but you never know
      return mb_strtolower($tmp[0]);
    } else {
      return ucfirst($tmp[0]);
    }

  }//end public static function getDomainName */

  /**
   * cut away the filename from an file
   *
   * @param unknown_type $filename
   * @return unknown
   */
  public static function getFileFolder($filename )
  {

    return mb_substr($filename , 0 , strrpos($filename,'/')+1);
  }//end public static function getFileFolder */

  /**
   * cut away the filename from an file
   *
   * @param unknown_type $filename
   * @return unknown
   */
  public static function shiftXTokens($string, $delimiter, $x )
  {

    if ( (int)$x < 0 )
      $x = -1*(int)$x;

    if (!$x )
      return $string;

    $tmp = explode($delimiter, $string);

    if ( count($tmp) <= $x )
      return '';

    while ($x )
    {
      --$x;
      array_shift($tmp);
    }

    return implode($delimiter , $tmp) ;

  }//end public static function shiftXTokens */

  /**
   * returns the filename or the last folder
   *
   * @param unknown_type $filename
   * @return unknown
   */
  public static function getPathFileName($filename )
  {
    return mb_substr($filename , strrpos($filename,'/')+1  );
  }//end public static function getFileFolder */

  /**
   * returns the filename or the last folder
   *
   * @param string $filename
   * @return string
   */
  public static function removeFirstSub($filename )
  {
    return mb_substr($filename, (stripos($filename,'_')+1)  );
  }//end public static function removeFirstSub */

  /**
   * @param string
   * @return String
   */
  public static function getFirstSub($key )
  {

    $tmp = explode( '_' , $key , 2 );
    $tmp = explode( '-', $tmp[0], 2 );

    return $tmp[0];

  }//end public static function getFirstSub */


  /**
   * returns the filename or the last folder
   *
   * @param string $string
   * @return unknown
   */
  public static function toCname($string )
  {
    return str_replace( array('-'," ") , array('_','_') ,(string)$string );

  }//end public static function getFileFolder */

  /**
   * Ein Label auf eine Maxsize verkürzen
   *
   * @param string $string
   * @param int $size
   * @param string $append
   * @return string
   */
  public static function shortLabel($string, $size = 35, $append = '...', $reverse = false )
  {
    $length = mb_strlen($string);

    if ($length <= $size )
      return $string;

    if ($reverse )
    {
      return $append.mb_substr($string, (-1*($size - $length)), $length, 'utf-8' );
    } else {
      return mb_substr($string, 0, $size, 'utf-8' ).$append;
    }


  }//end public static function shortLabel */


  /**
   * returns the filename or the last folder
   *
   * @param unknown_type $filename
   * @return unknown
   */
  public static function removeAllWhitespace($string )
  {

    return str_replace( array(' ',"\n","\r") , array('','','') ,$string );

  }//end public static function getFileFolder */

  /**
   * Enter description here...
   *
   * @param unknown_type $data
   * @return unknown
   */
  public static function quoteForSingleQuotes($data)
  {
    return str_replace("'","\'",$data);
  }//end public static function quoteForSingleQuotes */

  /**
   * @param string $data
   * @return string
   */
  public static function deQuoteForSingleQuotes($data)
  {
    return str_replace("\'","'",$data);
  }//end public static function deQuoteForSingleQuotes */

  /**
   * @param string $data
   * @return string
   */
  public static function quoteForDoubleQuotes($data)
  {
    return str_replace('"','\"',$data);
  }//end public static function quoteForDoubleQuotes */

  /**
   * @param string $data
   * @return string
   */
  public static function deQuoteForDoubleQuotes($data)
  {
    return str_replace('\"','"',$data);
  }//end public static function deQuoteForDoubleQuotes */

  /**
   * split a string in an arrray with key value pairs
   *
   * @param String $data
   * @return array
   */
  public static function seperatedToKeyArray($data , $seperator )
  {

    $tmp = explode($seperator,$data);

    $data = array();
    for($nam = 0 ; $nam < count($tmp) ; ++$nam )
    {
      $data[$tmp[$nam]] = $tmp[++$nam];
    }

    return $data;

  }//end public static function seperatedToKeyArray */

  /**
   * make the first char to lower case
   *
   * @param string $data
   * @return string
   */
  public static function lcfirst($data )
  {

    $data = (string)$data;
    $data[0] = mb_strtolower($data[0]);

    return $data;

  }//end public static function lcfirst */

  /**
   *
   * returns an array with two key:
   * folder: the path of the file without filename
   * file: the filename without path
   *
   * @return array
   *
   */
  public static function splitFilename($filename )
  {

    if (!$pos = strrpos($filename , '/' ) )
    {
      $back['folder'] = '';
      $back['file'] = $filename;
      return $back;
    }

    $back['folder']  = substr($filename , 0 ,  $pos );
    $back['file']  = substr($filename , ($pos+1) );

    return $back;

  }//end public static function splitFilename */

  /**
   * @param string $filfile
   * @return string
   */
  public static function replaceRootFolder($file )
  {

    $search = array('{$PATH_FW}','{$PATH_GW}');
    $replace = array(PATH_FW,PATH_GW);

    return str_replace($search,$replace,$file);

  }//end public static function replaceRootFolder */

  /**
   * @param array $seperators
   * @param string $string
   *
   * @return array
   */
  public static function split($seperators, $string )
  {

    $tmp = array($string );

    foreach($seperators as $sep )
    {
      $tmp2 = array();

      foreach($tmp as $part )
      {
        $tmp3 = explode($sep, $part );
        $tmp2 = array_merge($tmp2,$tmp3);
      }

      $tmp = $tmp2;
    }

    return $tmp;

  }//end public static function split */


  /**
   * @param string $file
   * @return string
   */
  public static function getClassNameFromPath($file )
  {

    $tmp = explode( '/', $file );

    $filename = array_pop($tmp);

    $tmp = explode( '.', $filename );
    array_pop($tmp);

    // ein klassenname kann keine punkte enthalten
    return $tmp[0];

  }//end public static function getClassNameFromPath */


  /**
   */
  public static function definedUuid($key )
  {

    $tmp = md5($key);

    return substr($tmp,0,8).'-'.substr($tmp,8,4).'-'.substr($tmp,12,4)
      .'-'.substr($tmp,16,4).'-'.substr($tmp,20,12);

  }//end public static function uuid */

}// end final class SParserString


