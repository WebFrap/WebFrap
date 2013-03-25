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
class LibValidator
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  const VALIDATE_MAIL = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";

  const VALIDATE_URL = '@((https?|ftp|file|fish):((//)|(\\\\))+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@';

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var array
   */
  public $data      = array();

  /**
   * array for saving if a value ist valid or invalid
   *
   * @var array
   */
  public $invalid     = array();

/*//////////////////////////////////////////////////////////////////////////////
// Static Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var LibValidator
   */
  private static $instance = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function __construct()
  {

  }//end protected function __construct

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return array
   */
  public function getData($key = null)
  {

    if (!is_null($key)) {
      $data = isset($this->data[$key])?$this->data[$key]:null;

      return $data;
    } else {
      return $this->data;
    }

  }//end public function getData

  /**
   * @return array
   */
  public function isInvalid($key = null)
  {
    if ($key) {
      if (!isset($this->invalid[$key])) {
        return 'empty';
      } else {
        return $this->invalid[$key];
      }
    } else {
      return $this->invalid;
    }

  }//end public function isValid

  /**
   * Enter description here...
   *
   */
  public function clean()
  {
    $this->data = array();
    $this->invalid = array();

  }//end public function clean()

/*//////////////////////////////////////////////////////////////////////////////
// Add Validator
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   * @return String
   */
  public static function validate($filter , $key, $value, $notNull = false, $maxSize = null, $minSize = null  )
  {
    Log::warn('Empty Validator! Fallback to quoted');

    if (!$notNull and trim($value) == '') {
      $filter->data[$key]     = null;
      $filter->invalid[$key]  = true;

      return false;
    }

    $filter->data[$key] = $value;

    if ($maxSize) {
      if (strlen($value) > $maxSize) {

        $filter->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $filter->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $filter->invalid[$key]  = false;

    return false;

  }//end public static function validate($filter , $key, $value, $notNull = false, $maxSize = null, $minSize = null  )

  /**
   * Warning will deliver unfilterd Userinput
   * Only Use this if you really know what you do!!
   * REALY KNOW!!
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   * @return String
   */
  public function addRaw($key, $value, $notNull = false, $maxSize = null, $minSize = null  )
  {
    if (!$notNull and trim($value) == '') {

      $this->data[$key]   = null;
      $this->invalid[$key]  = true;

      return false;
    }

    $this->data[$key] = stripslashes($value);

    if ($notNull and trim($value) == '') {

      $this->invalid[$key]  = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end public function addRaw

  /**
   * Warning will deliver unfilterd Userinput
   * Only Use this if you really know what you do!!
   * REALY KNOW!!
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   * @return String
   */
  public function addBitmask($key, $value, $notNull = false, $maxSize = null, $minSize = null  )
  {
    if (!is_array($value) and !is_null($value)) {
      $this->invalid[$key]  = 'wrong';

      return 'wrong';
    }

    if (!$notNull && count($value) == 0) {
      $this->data[$key]   = null;
      $this->invalid[$key]  = true;

      return false;
    }

    $this->data[$key] = new TBitmask($value);
    $this->invalid[$key]  = false;

    return false;

  }//end public function addBitmask($key, $value, $notNull = false, $maxSize = null, $minSize = null  )

  /**
   *
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   * @return String
   */
  public function addQuoted($key, $value, $notNull = false, $maxSize = null, $minSize = null  )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key]   = null;
      $this->invalid[$key]  = true;

      return false;
    }

    $this->data[$key] = $value;

    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end public function addQuoted

  /**
   *
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   * @return String
   */
  public function addNotags($key, $value, $notNull = false, $maxSize = null, $minSize = null  )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key]   = null;
      $this->invalid[$key]  = true;

      return false;
    }

    $this->data[$key] = strip_tags($value);

    if ($notNull and trim($value) == '') {
      $this->invalid[$key]  = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end public function addNotags

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addInt($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key]  = false;

      return false;
    }

    $this->data[$key] = (int) $value;

    if (!is_numeric($value)) {
      $this->invalid[$key]  = 'wrong';

      return 'wrong';
    }

    if ($maxSize) {
      if ($this->data[$key] > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if ($this->data[$key] < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end function addInt

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addRowid($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key]  = false;

      return false;
    }

    $this->data[$key] = (int) $value;

    if (!is_numeric($value)) {
      $this->invalid[$key]  = 'wrong';

      return 'wrong';
    }

    if ($maxSize) {
      if ($this->data[$key] > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if ($this->data[$key] < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end public function addRowid($key, $value, $notNull = false, $maxSize = null, $minSize = null   )

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addFloat($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key]  = false;

      return false;
    }

    $formatter = LibFormatterNumeric::getActive();
    $formatter->setNumericLanguage($value);

    $this->data[$key] = (float) $formatter->formatToEnglish();

    if ($notNull) {
      if (trim($value) == ''  ) {
        return 'empty';
      }
    }

    if (!is_numeric($this->data[$key])  ) {
      $this->invalid[$key]  = 'wrong';

      return 'wrong';
    }

    if ($maxSize) {
      if ($this->data[$key] > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if ($this->data[$key] < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end function addFloat

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addBoolean($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (is_null($value)) {
      $value = false;
    }

    // litle hack for search fields
    /*
    if ($value == '0') {
      $this->data[$key] = '-1';
    } else {
      $this->data[$key] = $value ? '1':'0';
    }
    */

    $this->data[$key] = $value ? '1':'0';

    $this->invalid[$key]  = false;

    return false;

  }//end function addBoolean

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addText($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key]     = null;
      $this->invalid[$key]  = false;

      return false;
    }

    $this->data[$key] = htmlspecialchars(stripslashes($value),ENT_QUOTES,'UTF-8');

    if ($notNull) {
      if (trim($value) == ''  ) {
        return 'empty';
      }
    }

    if ($maxSize) {
      if (strlen($this->data[$key]) > $maxSize) {
        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($this->data[$key]) < $minSize) {
        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end function addText

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addFulltext($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key]     = null;
      $this->invalid[$key]  = false;

      return false;
    }

    // musn't start with a number
    if (is_numeric($value[0])  ) {
      $this->invalid[$key]  = 'wrong';

      return 'wrong';
    }

    $this->data[$key] = htmlspecialchars(stripslashes($value),ENT_QUOTES,'UTF-8');

    if ($notNull) {
      if (trim($value) == ''  ) {
        return 'empty';
      }
    }

    if ($maxSize) {
      if (strlen($this->data[$key]) > $maxSize) {
        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($this->data[$key]) < $minSize) {
        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end function addText

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addHtml($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key]     = null;
      $this->invalid[$key]  = false;

      return false;
    }

    if ($notNull) {
      if (trim($value) == ''  ) {
        return 'empty';
      }
    }

    if ($maxSize) {
      if (strlen($this->data[$key]) > $maxSize) {
        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($this->data[$key]) < $minSize) {
        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end function addHtml

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addDate($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key]     = null;
      $this->invalid[$key]  = false;

      return false;
    }

    $formatter = LibFormatterDate::getActive();

    if (!$formatter->setDateLanguage($value)) {
      $this->invalid[$key]  = 'wrong';

      return 'wrong';
    }

    $this->data[$key] = $formatter->formatToEnglish();


    if ($notNull and trim($value) == '') {
      $this->invalid[$key]  = 'emtpy';

      return 'emtpy';
    }



    /*
    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }
    */

    $this->invalid[$key]  = false;

    return false;

  }//end function addDate

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addTime($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key]   = null;
      $this->invalid[$key]  = false;

      return false;
    }

    //TODO add a correct filter
    $this->data[$key] = $value;

    if ($notNull and trim($value) == '') {
      $this->invalid[$key]  = 'emtpy';

      return 'emtpy';
    }

    /*
    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }
    */

    $this->invalid[$key]  = false;

    return false;

  }//end function addTime

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addTimestamp($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key]   = null;
      $this->invalid[$key]  = false;

      return false;
    }

    //TODO add a correct filter
    $this->data[$key] = $value;

    if ($notNull and trim($value) == '') {
      $this->invalid[$key]  = 'emtpy';

      return 'emtpy';
    }

    /*
    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }
    */

    $this->invalid[$key]  = false;

    return false;

  }//end function addTimestamp

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addUrl($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key]   = null;
      $this->invalid[$key]  = false;

      return false;
    }

    $this->data[$key] = $value;

    if (!preg_match(self::VALIDATE_URL ,$value)  ) {
      $this->invalid[$key]  = 'wrong';

      return 'wrong';
    }

    if ($notNull and trim($value) == '') {
      $this->invalid[$key]  = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end function addUrl

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addEmail($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key]   = null;
      $this->invalid[$key]  = false;

      return false;
    }

    $this->data[$key] = $value;

    if (!preg_match(self::VALIDATE_MAIL, $value)) {
      $this->invalid[$key]  = 'wrong';

      return 'wrong';
    }

    if ($notNull and trim($value) == '') {
      $this->invalid[$key]  = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end function addEmail

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addUsername($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key]   = null;
      $this->invalid[$key]  = false;

      return false;
    }

    $this->data[$key] = $value;

    // musn't start with a number
    if (is_numeric($value[0])  ) {
      $this->invalid[$key]  = 'wrong';

      return 'wrong';
    }

    if ($notNull and trim($value) == '') {
      $this->invalid[$key]  = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end function addUsername

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addPassword($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      //$this->data[$key]     = null;
      $this->invalid[$key]  = false;

      return false;
    }

    if ($notNull and trim($value) == '') {
      $this->invalid[$key]  = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->data[$key] = SEncrypt::passwordHash($value);

    $this->invalid[$key]  = false;

    return false;

  }//end function addPassword

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addCname($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key]     = null;
      $this->invalid[$key]  = false;

      return false;
    }

    $this->data[$key] = $value;

    // remove all __
    $testVal = str_replace('_','',$value);

    // musn't start with a number
    if (!ctype_alnum($testVal)) {
      $this->invalid[$key]  = 'wrong';

      return 'wrong';
    }

    if ($notNull and trim($value) == '') {
      $this->invalid[$key]  = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end function addCname

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addFilename($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key]   = null;
      $this->invalid[$key]  = false;

      return false;
    }

    // here we just get the filename
    $this->data[$key] = SFiles::getFilename($value);

    if ($notNull and trim($value) == '') {
      $this->invalid[$key]  = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end function addFilename

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addFullname($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key]   = null;
      $this->invalid[$key]  = false;

      return false;
    }

    //TODO add a correct filter
    $this->data[$key] = $value;

    if ($notNull and trim($value) == '') {
      $this->invalid[$key]  = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end function addFullname

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addFoldername($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key]   = null;
      $this->invalid[$key]  = false;

      return false;
    }

    $this->data[$key] = SFiles::getPath($value);

    if ($notNull and trim($value) == '') {
      $this->invalid[$key]  = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (strlen($value) > $maxSize) {
        $this->invalid[$key]  = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (strlen($value) < $minSize) {
        $this->invalid[$key]  = 'min';

        return 'min';
      }
    }

    $this->invalid[$key]  = false;

    return false;

  }//end function addFoldername

} // end class LibValidatorUserinput

