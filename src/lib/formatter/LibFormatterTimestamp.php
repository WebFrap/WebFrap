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
class LibFormatterTimestamp
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * 
   * @var LibFormatterTimestamp
   */
  protected static $instance  = null;

  /**
   *
   */
  protected $timeOrigin   = null;

  /**
   *
   */
  protected $timeRaw      = array();

  /**
   *
   */
  protected $timeEnglish  = null;

  /**
   *
   */
  protected $format       = 'd.m.Y<\b\r />H:i:s';

  /**
   *
   */
  protected $formatRaw    = array();

  /**
   *
   */
  protected $separatorDate    = '.';

  /**
   *
   */
  protected $separatorTime    = ':';

////////////////////////////////////////////////////////////////////////////////
// Magic
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function __construct
  (
  $time = null,
  $format = 'd.m.Y<\b\r />H:i:s',
  $separator = ':'
  )
  {

    if( $time )
    {
      $this->setTime( $time );
    }

    $this->setFormat( $format );
    $this->seperator = $separator;

  }//end public function __construct

  /**
   * @return string
   */
  public function __toString()
  {
    
    return $this->formatToEnglish();
    
  }//end public function __toString */

////////////////////////////////////////////////////////////////////////////////
// Singleton
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return LibFormatterTimestamp
   */
  public static function getInstance()
  {
    if( is_null( self::$instance) )
    {
      self::$instance = new LibFormatterTimestamp();
    }

    return self::$instance;

  }//end public static function getInstance */

////////////////////////////////////////////////////////////////////////////////
// Getter and Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function setFormat( $format )
  {
    $length = strlen($format);

    $this->format = $format;
    $open = false;
    for( $pos = 0 ; $pos < $length ; ++$pos )
    {

      if($format[$pos] == '<')
      {
        $open = true;
        continue;
      }
      if($format[$pos] == '>')
      {
        $open = false;
        continue;
      }

      if( ctype_alpha( $format[$pos]) and !$open )
      {
        $this->formatRaw[] =  $format[$pos];
      }

    }
  }//end public function setFormat( $format )

  /**
   *
   */
  public function setSeperator( $separatorDate , $separatorTime  )
  {
    $this->separatorDate = $separatorDate;
    $this->separatorTime = $separatorTime;
  }//end public function setSeperator( $separatorDate , $separatorTime  )

  /**
   *
   */
  public function setTimeLanguage( $time )
  {

    if( trim($time) == '' )
    {
      $this->timeOrigin  = null;
      $this->timeEnglish = null;
      return;
    }

    $this->timeOrigin = $time;

    // Explode Date and Time
    $raw = explode( ' ' , $time );

    $date = $raw[0];
    $time = $raw[1];

    $rawDate = explode( $this->separatorDate , $date );
    $rawTime = explode( $this->separatorTime , $time );


    $raw = $rawDate;
    foreach( $rawTime as $times )
    {
      $raw[] = $times;
    }

    //$raw = array_merge( $rawDate , $rawTime );

    foreach( $this->formatRaw as $key => $value )
    {
      $this->timeRaw[$value] = isset($raw[$key]) ? $raw[$key] : '00'  ;
    }

    $this->timeEnglish = $this->dateRaw['Y'].'-'.$this->dateRaw['m'].'-'
      .$this->dateRaw['d'] .' '. $this->timeRaw['H'].':'.$this->timeRaw['i'].':'
      .$this->timeRaw['s'];

  }//end public function setTimeLanguage( $time )

  /**
   *
   */
  public function setTimeEnglish( $time )
  {

    if( trim( $time ) != '' )
    {
      $this->timeEnglish = $time;
    }
    else
    {
      $this->timeEnglish = null;
    }
  }//end public function setTimeEnglish( $time )

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function formatToEnglish()
  {
    return $this->timeEnglish;
  }//end public function formatToEnglish()

  /**
   *
   */
  public function formatToLanguage()
  {
    if( trim($this->timeEnglish) == '' )
    {
      return null;
    }

    return date( $this->format , strtotime( $this->timeEnglish ) );
  }//end public function formatToLanguage()

} // end class LibFormatterTimestamp

