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
class LibFormatterDate
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Standard Instanz, für den Formatter werden in der Regel nicht mehrere
   * Instantzen benötigt, daher wird eine Standard Instanz on first demand
   * abgelegt die verwendet werden kann
   * 
   * @var LibFormatterDate
   */
  protected static $instance  = null;

  /**
   *
   */
  protected $dateOrigin   = null;

  /**
   *
   */
  protected $dateRaw      = array();

  /**
   *
   */
  protected $dateEnglish  = null;

  /**
   *
   */
  protected $format       = null;

  /**
   *
   */
  protected $formatRaw    = array();

  /**
   *
   */
  protected $separator    = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function __construct( $date = null, $format = null, $separator = null  )
  {

    if( is_null($format) )
    {
      $this->setFormat( I18n::$dateFormat );
    }
    else
    {
      $this->setFormat( $format );
    }

    if( is_null($separator) )
    {
      $separator = I18n::$dateSeperator;
    }

    $this->seperator = $separator;

    if( $date )
    {
      $this->setDateLanguage( $date );
    }

  }//end public function __construct */

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->formatToEnglish();
  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Singleton
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibFormatterDate
   * @deprecated use LibFormatterDate::getActive nicht das wieder einer Singleton brüllt
   */
  public static function getInstance()
  {

    if( is_null( self::$instance) )
    {
      self::$instance = new LibFormatterDate();
    }

    return self::$instance;

  }//end public static function getInstance

  /**
   * Erfragen der Standard Instanz
   * Ist keine Singleton Implementierung, der Konstruktor ist public, es können
   * bei Bedarf weitere Instanzen erstellt werden
   * 
   * @return LibFormatterDate
   * @deprecated use LibFormatterDate::getActive nicht das wieder einer Singleton brüllt
   */
  public static function getDefault()
  {

    if( is_null( self::$instance) )
    {
      self::$instance = new LibFormatterDate();
    }

    return self::$instance;

  }//end public static function getDefault */  
  
  
  /**
   * Erfragen der Standard Instanz
   * Ist keine Singleton Implementierung, der Konstruktor ist public, es können
   * bei Bedarf weitere Instanzen erstellt werden
   * 
   * @return LibFormatterDate
   */
  public static function getActive()
  {

    if( is_null( self::$instance) )
    {
      self::$instance = new LibFormatterDate();
    }

    return self::$instance;

  }//end public static function getActive */ 
  

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string
   */
  public function setFormat( $format )
  {
    $length = strlen($format);

    $this->formatRaw = array();

    $this->format = $format;
    for( $pos = 0 ; $pos < $length ; ++$pos )
    {
      if( ctype_alpha( $format[$pos]) )
      {
        $this->formatRaw[] =  $format[$pos];
      }
    }

    if(DEBUG)
      Debug::console( 'raw', $this->formatRaw);

  }//end public function setFormat */

  /**
   * @param string $separator
   */
  public function setSeperator( $separator )
  {
    $this->separator = $separator;
  }//end public function setSeperator */

  /**
   * @param string $date
   */
  public function setDateLanguage( $date )
  {
    if( trim($date) == '' )
    {
      $this->dateOrigin  = null;
      $this->dateEnglish = null;
      return false;
    }

    if( I18n::$short == 'en' )
    {
      $this->dateEnglish = $date;
      $this->dateOrigin  = $date;
      return true;
    }

    $this->dateOrigin = $date;
    $raw = explode( $this->separator , $date );
    
    if( count($raw) < 3  )
    {
      Debug::console( 'INVALID DATE ', $date );
      return false;
    }

    $this->dateRaw = array();

    foreach( $this->formatRaw as $key => $value )
    {
      $this->dateRaw[$value] = $raw[$key] ;
    }

    if(!isset($this->dateRaw['Y']) || !isset($this->dateRaw['m']) || !isset($this->dateRaw['d']) )
    {
      ///TODO add some debug here

      Debug::console( 'raw date ', $this->dateRaw );
      return false;
    }

    if (!is_numeric($this->dateRaw['Y']) || !is_numeric($this->dateRaw['m']) )
    {
      $this->dateOrigin  = null;
      $this->dateEnglish = null;
      return false;
    }

    $this->dateEnglish = $this->dateRaw['Y'].'-'.$this->dateRaw['m'].'-'.$this->dateRaw['d'];
    //$this->dateEnglish = $this->dateRaw['Y'].$this->dateRaw['m'].$this->dateRaw['d'];

    return true;
  }

  /**
   * @param string $date
   */
  public function setDateEnglish( $date )
  {
    if( trim( $date ) != '' )
    {
      $this->dateEnglish = $date;
    }
    else
    {
      $this->dateEnglish = null;
    }
  }

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function formatToEnglish()
  {
    return $this->dateEnglish;
  }

  /**
   *
   */
  public function formatToLanguage( )
  {

    if( trim( $this->dateEnglish ) == '' )
    {
      return null;
    }

    return date( $this->format , strtotime($this->dateEnglish) );
  }

  /**
   * Enter description here...
   *
   * @param unknown_type $date
   * @return unknown
   */
  public function format( $date )
  {

    if( trim($date) == '' )
    {
      return '';
    }
    else
    {
      return date( $this->format , strtotime($date) );
    }

  }//end public function format( $date )

} // end class LibFormatterDate

