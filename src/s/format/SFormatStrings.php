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
class SFormatStrings
{

  /** Abschneiden einer bestimmten Anzahl von Zeichen am Ende eines Strings
   *
   * @param string Folder Der Pfad zum Ordner desse Inhalt man haben möchte
   * @return array
   */
  public static function cutLastChars( $String , $Anz = 1 )
  {
    return substr( $String , 0 , -$Anz  );
  } // end public static function cutLastChars( $String , $Anz = 1 )

  /** Abschneiden einer bestimmten Anzahl von Zeichen am Ende eines Strings
   *  und hinzufügen von Punkten falls eine bestimmte Anzahl von Zeichen
   *  überschritten wird.
   *
   * @param string Folder Der Pfad zum Ordner desse Inhalt man haben möchte
   * @param int Mlength Maximallänge des Strings
   * @return array
   */
  public static function cuttingAndDotting( $string , $Mlength = 35 )
  {

    $Length = strlen($string);
    $dot = $Length > $Mlength ? '...': '';

    return substr( $string , 0 , $Mlength ).$dot;

  } // end of member function cuttingAndDotting

  /** Abschneiden einer bestimmten Anzahl von Zeichen am Ende eines Strings
   *  und hinzufügen von Punkten falls eine bestimmte Anzahl von Zeichen
   *  überschritten wird.
   *
   * @param string Folder Der Pfad zum Ordner desse Inhalt man haben möchte
   * @param int Mlength Maximallänge des Strings
   * @return array
   */
  public static function getClassPackages( $className )
  {

    $length = strlen($className);

    $parts = array();
    $start = 0;
    $end = 1;

    // Bei 1 Starten um den ersten Buchstaben zu Überpringen
    for( $pos = 1 ; $pos < $length ; ++$pos )
    {
      if(ctype_upper($className[$pos]) )
      {
        $parts[] = strtolower(substr( $className, $start, $end  ));
        $start = $end;
        $end = 0;

      }
      ++$end;
    }

    $parts[] = $className;

    return $parts;


  } // end of member function cuttingAndDotting

  /**
   * format a longer text that all collumns are shorter than $lenght chars
   */
  public static function toMaxColumLength( $text , $lenght = 80 , $asArray = false )
  {

    // First remove als new lines from the text
    $text = str_replace( array("\n","\r"),array('',''), $text );
    $words = explode( ' ' , $text  );

    $size = 0;

    if( $asArray )
    {
      $formatedText = '';
      foreach( $words as $word );
      {
        if( ($size + strlen($word)) > $lenght  )
        {
          $size = 0;
          $formatedText .= NL;
        }
        $formatedText .= $word;
      }
    }
    else
    {
      $formatedText = array();

      $tmpText = '';
      foreach( $words as $word );
      {
        if( ($size + strlen($word)) > $lenght  )
        {
          $size = 0;
          $formatedText[] = $tmpText;
          $tmpText = '';
        }
        $tmpText .= $word;
      }
    }

    return $formatedText;

  }//end public static function toMaxColumLength
  
  
  /** 
   * Url & Json save encodieren
   * @param string $value 
   * @return string
   */
  public static function cleanCC( $value )
  {
    return str_replace( array('&','<','>','"',"'"), array('&amp;','&lt;','&gt;','&quot;','&#039;'), $value );
  } // end public static function cleanCC */

  /**
   * Einen Namen in einen valide Access Key für die Datenbank umbauen
   * @param string $name
   * @return string
   */
  public static function nameToAccessKey( $name )
  {
    
    /*
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
      '__' => '_',
      '.'  => '_',
      ','  => '_',
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
    */

    return substr( preg_replace('/[^a-zA-Z0-9_-]/', '', $name ), 0, 35  );
    
  }//end public static function nameToAccessKey */

  /**
   * Array to CSV.
   * @param array $data
   * @param string $delimiter
   * @param string $enclosure
   */
  public static function arrayToCsv( $data, $delimiter = ',', $enclosure = '"') 
  {
     $handle = fopen('php://temp', 'r+');
     foreach( $data as $row ) 
     {
       fputcsv( $handle, $row, $delimiter, $enclosure );
     }
     
     $contents = '';
     
     rewind($handle);
     while (!feof($handle)) 
     {
       $contents .= fread($handle, 8192);
     }
     fclose($handle);
     
     return $contents;
  }//end function arrayToCsv */
  
  /**
   * @param string $str
   * @param boolean $firstSmall
   */
  public static function subToCamelCase( $str , $firstSmall = false )
  {
    
    /*
    if(!strpos($str, '_'))
    {
      if( $firstSmall )
      {
        return $str;
      }
      else
      {
        return ucfirst($str);
      }
    }
    */

    $tmp = explode( '_' , trim($str) );
    $camelCase = '';

    foreach( $tmp as $case )
    {
      $camelCase .= ucfirst($case);
    }

    $tmp2       = explode( '-' , trim($camelCase) );
    $camelCase2 = array();

    foreach( $tmp2 as $case2 )
    {
      $camelCase2[] = ucfirst($case2);
    }

    $camelCase = implode( '_', $camelCase2 );

    if( $firstSmall && isset( $camelCase[0] ) )
      $camelCase[0] = mb_strtolower( $camelCase[0] );

    return $camelCase;

  }//end public static function subToCamelCase */
  
  
  /**
   * @param string $str
   */
  public static function mNameToUrl( $str )
  {
    
    $tmp1 = explode( ':', $str );
    
    $tmp   = explode( '_' , trim($tmp1[0]) );

    $mod   = ucfirst( array_shift($tmp) ) ;
    $contr = '';
    
    foreach( $tmp as $node )
    {
      $contr .= ucfirst($node);
    }
    
    $contr = str_replace('-', '_', $contr);

    return "{$mod}.{$contr}.{$tmp1[1]}";


  }//end public static function mNameToUrl */
  
} // end class SFormatStrings

