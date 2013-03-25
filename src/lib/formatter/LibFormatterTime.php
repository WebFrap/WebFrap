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
class LibFormatterTime
{

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

      /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected static $instance  = null;

  protected $timeOrigin   = null;

  protected $timeRaw      = array();

  protected $timeEnglish  = null;

  protected $format       = 'H:i:s';

  protected $formatRaw    = array();

  protected $separator    = ':';

  /**
   *
   */
  public function __construct
  (
  $time = null,
  $format = 'H:i:s',
  $separator = ':'
  )
  {

    if ($time) {
      $this->setTime($time);
    }

    $this->setFormat($format);
    $this->seperator = $separator;

  }//end public function __construct

  /**
   *
   */
  public function __toString()
  {
    return $this->formatToEnglish();
  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Singleton
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public static function getInstance()
  {

    if (is_null(self::$instance)) {
      self::$instance = new LibFormatterTime();
    }

    return self::$instance;

  }//end public static function getInstance

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function setFormat($format)
  {
    $length = strlen($format);

    $this->format = $format;
    for ($pos = 0 ; $pos < $length ; ++$pos) {
      if (ctype_alpha($format[$pos])) {
        $this->formatRaw[] =  $format[$pos];
      }
    }
  }//end public function setFormat($format)

  public function setSeperator($separator)
  {
    $this->separator = $separator;
  }//end public function setSeperator($separator)

  /**
   *
   */
  public function setTimeLanguage($time)
  {
    if (trim($time) == '') {
      $this->timeOrigin  = null;
      $this->timeEnglish = null;

      return;
    }

    $this->timeOrigin = $time;
    $raw = explode($this->separator , $time);

    foreach ($this->formatRaw as $key => $value) {
      $this->timeRaw[$value] = isset($raw[$key]) ? $raw[$key] : '00'  ;
    }

    $this->timeEnglish = $this->timeRaw['H'].':'.$this->timeRaw['i'].':'.$this->timeRaw['s'];

  }//end public function setTimeLanguage($time)

  public function setTimeEnglish($time)
  {
    if (trim($time) != '') {
      $this->timeEnglish = $time;
    } else {
      $this->timeEnglish = null;
    }
  }//end public function setTimeEnglish($time)

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

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
    if (trim($this->timeEnglish) == '') {
      return null;
    }

    //return $this->timeEnglish;
    return date($this->format , strtotime($this->timeEnglish));
  }//end public function formatToLanguage()

} // end class LibFormatterTime

