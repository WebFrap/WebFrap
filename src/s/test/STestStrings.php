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
final class STestStrings
{

  /** Privater Konstruktor zum Unterbinde von Instanzen
   */
  private function __construct(){}

  /** Funktion zum maskieren von Strings und Arrays
   *
   * @param string PotFolder Die potentielle Pfadangabe
   * @return array
   */
  public static function escape($data )
  {

    // Wenns nur ein String is alles ok
    if (!is_array($data)){
      return addslashes($data);
    }
    else{

      $back = array();
      foreach($data as $key => $value )
      {
        if (!is_array($value) )
        {
          $back[$key] = addslashes($value);
        }
        else
        {
          $back[$key] = self::escape($value);
        }
      }

      return $back;
    }// Ende Else

  } // end of member function escape

  /** Funktion zum demaskieren von Strings und Arrays
   *
   * @param string $data Die potentielle Pfadangabe
   * @return array
   */
  public static function deEscape($data )
  {

    // Wenns nur ein String is alles ok
    if (!is_array($data))
    {
      return stripslashes($data);
    } else {
      $back = array();
      foreach($data as $key => $value )
      {
        if (!is_array($value) )
        {
          $back[$key] = stripslashes($value);
        }
        else
        {
          $back[$key] = self::deEscape($value);
        }
      }
      return $back;
    }// Ende Else

  } // end of member function deEscape

  /** Methode zum convertieren aller Sonderzeichen zu HTML
   *
   * @param array/string $data Die Postdaten die convertiert werden müssen
   * @return array
   */
  public static function convertToHtml($data )
  {

    // Wenns nur ein String is alles ok
    if (!is_array($data) )
    {
      return htmlentities($data , ENT_QUOTES  );
    } else {
      $back = array();
      foreach($data as $key => $value )
      {
        if (!is_array($value) )
        {
          $back[$key] = htmlentities($value , ENT_QUOTES );
        }
        else
        {
          $back[$key] = self::convertToHtml($value);
        }
      }
      return $back;
    }// Ende Else

  } // end of member function convertToHtml

  /** Methode zum entfernen von alles was nach Code aussieht
   *
   * @param array/string $data Die Postdaten die convertiert werden müssen
   * @return array
   */
  public static function removeCode($data )
  {

    // Wenns nur ein String is alles ok
    if (!is_array($data))
    {
      return strip_tags($data );
    } else {
      $back = array();
      foreach($data as $key => $value )
      {
        if (!is_array($value) )
        {
          $back[$key] = strip_tags($value );
        }
        else
        {
          $back[$key] = self::removeCode($value);
        }
      }
      return $back;
    }// Ende Else

  } // end of member function removeCode

  /** Funktion zum auslesen von Ordnerinhalten
   *
   * @param array/string $data Die potentielle Pfadangabe
   * @return array
   */
  public static function noFolderAllowed(  $data )
  {

    // Wenns nur ein String is alles ok
    if (!is_array($data))
    {

      if ($vorhanden = stripos($data, ".." ) !== false )
      {
        return false;
      }

      if ($vorhanden = stripos($data, "/" ) !== false )
      {
        return false;
      }

      return $data;
    }// Ende If
    else
    {
      $back = array();
      foreach($data as $key => $value )
      {
        if (!is_array($value) )
        {

          if ($vorhanden = stripos($value, ".." ) !== false )
          {
          }
          elseif ($vorhanden = stripos($value, "/" ) !== false )
          {
            $back[$key] = false;
          }
          else
          {
            $back[$key] = $value;
          }

        }// Ende If is_array
        else
        {
          $back[$key] = self::noFolderAllowed($value);
        }
      }// Ende Foreach

      return $back;
    }// Ende Else

  } // end of member function noFolderAllowed

  /** Funktion zum auslesen von Ordnerinhalten
   *
   * @param string $data Die potentielle Pfadangabe
   * @return array
   */
  public static function noDotAllowed(  $data )
  {

    // Wenns nur ein String is alles ok
    if (!is_array($data))
    {

      if ($vorhanden = stripos($data, "." ) !== false )
      {
        return false;
      }
      return $data;

    }// Ende If
    else
    {
      $back = array();
      foreach($data as $key => $value )
      {
        if (!is_array($value) )
        {

          if ($vorhanden = stripos($value, "." ) !== false )
          {
            $back[$key] = false;
          }
          else
          {
            $back[$key] = $value;
          }

        }// Ende If is_array
        else
        {
          $back[$key] = self::noDotAllowed($value);
        }
      }// Ende Foreach

      return $back;
    }// Ende Else

  } // end of member function noDotAllowed

  /** Funktion zum auslesen von Ordnerinhalten
   *
   * @param string PotFolder Die potentielle Pfadangabe
   * @return array
   */
  public static function removeDots(  $data )
  {

    // Wenns nur ein String is alles ok
    if (!is_array($data))
    {
      return str_replace("." , "" ,  $data );

    }// Ende If
    else
    {
      $back = array();
      foreach($data as $key => $value )
      {
        if (!is_array($value) )
        {

          if ($vorhanden = stripos($value, "." ) !== false )
          {
            $back[$key] = false;
          }
          else
          {
            $back[$key] = $value;
          }

        }// Ende If is_array
        else
        {
          $back[$key] = self::removeDots($value);
        }
      }// Ende Foreach

      return $back;
    }// Ende Else

  } // end public static function removeDots(  $data )

  /** Methode zum auslesen ob ein String ein MD5 Hash ist
   *
   * @param string PotFolder Die potentielle Pfadangabe
   * @return boolean
   */
  public static function isMd5($value )
  {

    return (  (strlen($value) == 32) && preg_match('/^[a-f0-9]+$/', $value))
      ? true : false;
  } // public static function isMd5($value )

  public static function isSha1($value )
  {

    return (  (strlen($value) == 32) && preg_match('/^[a-f0-9]+$/', $value))
      ? true : false;
  } // end public static function isSha1($value )

} // end final class STestStrings

