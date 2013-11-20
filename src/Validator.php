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
class Validator
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Validatormapping
   * @var string
   */
  const RAW = 'Raw';

  /**
   * Validatormapping
   * @var string
   */
  const NOTAGS = 'Notags';

  /**
   * Validatormapping
   * @var string
   */
  const INT = 'Int';

  /**
   * Validatormapping
   * @var string
   */
  const SMALLINT = 'Smallint';

  /**
   * Validatormapping
   * @var string
   */
  const EID = 'Eid';

  /**
   * Validatormapping
   * @var string
   */
  const NUMERIC = 'Numeric';

  /**
   * Validatormapping
   * @var string
   */
  const BOOLEAN = 'Boolean';

  /**
   * Validatormapping
   * @var string
   */
  const BOOLEAN3 = 'Boolean3';

  /**
   * Validatormapping
   * @var string
   */
  const TEXT = 'Text';

  /**
   * Validatormapping
   * @var string
   */
  const SEARCH = 'Search';

  /**
   * Validatormapping
   * @var string
   */
  const HTML = 'Html';

  /**
   * Validatormapping
   * @var string
   */
  const HTML_PUBLISH = 'HtmlPublish';

  /**
   * Validatormapping
   * @var string
   */
  const HTML_FULL = 'HtmlFull';

  /**
   * Validatormapping
   * @var string
   */
  const JSON = 'Json';

  /**
   * Validatormapping
   * @var string
   */
  const DATE = 'Date';

  /**
   * Validatormapping
   * @var string
   */
  const TIME = 'Time';

  /**
   * Validatormapping
   * @var string
   */
  const TIMESTAMP = 'Timestamp';

  /**
   * Validatormapping
   * @var string
   */
  const URL = 'Url';

  /**
   * Validatormapping
   * @var string
   */
  const LINK = 'Link';

  /**
   * Validatormapping
   * @var string
   */
  const EMAIL = 'Email';

  /**
   * Validatormapping
   * @var string
   */
  const USERNAME = 'Username';

  /**
   * Validatormapping
   * @var string
   */
  const PASSWORD = 'Password';

  /**
   * Validatormapping
   * @var string
   */
  const CNAME = 'Cname';

  /**
   * Validatormapping
   * @var string
   */
  const CKEY = 'Ckey';

  /**
   * Validatormapping
   * @var string
   */
  const FILENAME = 'Filename';

  /**
   * Validatormapping
   * @var string
   */
  const FILE = 'File';

  /**
   * Validatormapping
   * @var string
   */
  const IMAGE = 'Image';

  /**
   * Validatormapping
   * @var string
   */
  const FULLNAME = 'Fullname';

  /**
   * Validatormapping
   * @var string
   */
  const FOLDERNAME = 'Foldername';

  /**
   * Validatormapping
   * @var string
   */
  const BITMASK = 'Bitmask';

  /**
   * Validatormapping
   * @var string
   */
  const UUID = 'Uuid';

  /**
   * Validatormapping
   * @var string
   */
  const NETWORKSHARE = 'Networkshare';

  /**
   *
   * @var unknown_type
   */
  const VALIDATE_MAIL = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_-]+([.][A-z0-9_-]+)*[.][A-z]{2,4}$/";

  /**
   *
   * @var unknown_type
   */
  const VALIDATE_URL = '@((https?|ftp|file|fish|ssh|torrent|apt):((//)|(\\\\))+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@';

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var array
   */
  public $data = array();

  /**
   * array for saving if a value ist valid or invalid
   *
   * @var array
   */
  public $invalid = array();

  /**
   *
   * @var string
   */
  public $lastError = null;

  /**
   *
   * @var scalar
   */
  public $lastValue = null;

  /**
   *
   * @var scalar
   */
  public $validatorPool = array();

  /**
   * list with secific error messages
   * @var array
   */
  public $errorMessages = null;

/*//////////////////////////////////////////////////////////////////////////////
// Static Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var Validator
   */
  private static $instance = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return Validator
   * @deprecated
   */
  public static function getInstance()
  {
    self::$instance = self::$instance ? self::$instance: new Validator;

    return self::$instance;
  }//end public static function getInstance */

  /**
   *
   * @return Validator
   */
  public static function getActive()
  {

    self::$instance = self::$instance
      ? self::$instance
      : new Validator;

    return self::$instance;

  }//end public static function getActive */

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param unknown_type $message
   * @return void
   */
  public function addErrorMessage($message)
  {
    $this->errorMessages[] = $message;
  }//end public function addErrorMessage */

  /**
   *
   */
  public function getErrorMessages()
  {
    return $this->errorMessages;
  }//end public function getErrorMessages */

  /**
   * @return boolean
   */
  public function hasErrors()
  {
    return (boolean) count($this->errorMessages);
  }//end public function hasErrors */

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
  public function appendCleanData($key, $value)
  {

    $this->data[$key] = $value;
    $this->invalid[$key] = false;

  }//end public function appendCleanData */

  /**
   * @return array
   */
  public function getError()
  {
    return $this->lastError;
  }//end public function getError

  /**
   * @return array
   */
  public function getValue()
  {
    return $this->lastValue;
  }//end public function getValue

  /**
   * @return array
   */
  public function isInvalid($key = null)
  {

    if ($key) {
      if (!isset($this->invalid[$key]))
        return 'empty';
      else
        return $this->invalid[$key];
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
    $this->errorMessages = array();

  }//end public function clean

  /**
   * @param string name
   */
  public function getValidator($name)
  {

    if (isset($this->validatorPool[$name]))
      return $this->validatorPool[$name];

    $classname = 'LibValidator'.ucfirst($name);

    if (!Webfrap::classExists($classname)  ) {
      Error::addError('Requested nonexisting Validator: '.$name.'. Please check the existing Validator Classes');

      return null;
    }

    $validator = new $classname();
    $this->validatorPool[$name] = $validator;

    return $validator;

  }//end public function getValidator */

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
  public function checkRequired($key, $notNull = false)
  {

    if ($notNull) {
      $this->invalid[$key] =  'emtpy';

      return 'emtpy';
    } else {
      $this->invalid[$key] = false;

      return false;
    }

  }//end public function checkRequired

/*//////////////////////////////////////////////////////////////////////////////
// Static Validator
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
  public function validate($filter , $value, $notNull = false, $maxSize = null, $minSize = null  )
  {

    $method = 'add'.ucfirst($filter);

    $this->lastError = $this->$method('tmp', $value, $notNull = false, $maxSize = null, $minSize = null);
    $this->lastValue = $this->data['tmp'];

    $this->clean();

    return !$this->lastError;

  }//end public static function validate

/*//////////////////////////////////////////////////////////////////////////////
// Add Validator
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function add($validator, $key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    if (!$valObj = $this->getValidator($validator)) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    $conclusion = $valObj->validate($key, $value, $notNull, $maxSize, $minSize);
    $this->data[$key] = $valObj->getSecure();

    $this->invalid[$key] = $conclusion;

    return $conclusion;

  }//end public function add */

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
      $this->data[$key] = null;
      $this->invalid[$key] = true;

      return false;
    }

    $this->data[$key] = stripslashes($value);

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

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
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    if (!$notNull and count($value) == 0) {

      $this->data[$key] = null;
      $this->invalid[$key] = true;

      return false;
    }

    $this->data[$key] = new TBitmask($value);
    $this->invalid[$key] = false;

    return false;

  }//end public function addBitmask

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
      $this->data[$key] = null;
      $this->invalid[$key] = true;

      return false;
    }

    $this->data[$key] = strip_tags($value);

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

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
      $this->invalid[$key] = false;

      return false;
    }

    $this->data[$key] = (int) $value;

    if (!is_numeric($value)) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    if ($maxSize) {
      if ($this->data[$key] > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if ($this->data[$key] < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end function addInt

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addSmallint($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $this->data[$key] = (int) $value;

    if (!is_numeric($value)) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    if ($maxSize) {
      if ($this->data[$key] > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if ($this->data[$key] < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end function addSmallint

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addBigInt($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $this->data[$key] = (int) $value;

    if (!is_numeric($value)) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    if ($maxSize) {
      if ($this->data[$key] > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if ($this->data[$key] < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end function addBigInt

  /**
   * check if the value is a valid EID  Entity id:
   *
   * must be a int and bigger than 0
   *
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addEid($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $this->data[$key] = (int) $value;

    if (!ctype_digit($value)) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    if (0 > $value) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    if ($maxSize) {
      if ($this->data[$key] > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if ($this->data[$key] < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end public function addEid */

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addNumeric($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $formatter = LibFormatterNumeric::getActive();

    $this->data[$key] = (float) $formatter->formatToEnglish($value);

    if ($notNull) {
      if (trim($value) == ''  ) {
        return 'empty';
      }
    }

    if ($maxSize) {
      if ($this->data[$key] > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if ($this->data[$key] < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end function addNumeric */

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addBoolean($key, $value, $notNull = false, $maxSize = null, $minSize = null)
  {

    $value = strtolower(trim($value));

    if ('f' == $value  || 'false' == $value || '0' == $value) {
      $value = false; //f
    } elseif ('' == $value) {
      $value = false; // f | false per default
    } else {
      $value = true; // t
    }

    // litle hack for search fields
    /*
    if ($value == '0') {
      $this->data[$key] = '-1';
    } else {
      $this->data[$key] = $value ? '1':'0';
    }
    */

    $this->data[$key] = $value;
    $this->invalid[$key] = false;

    return false;

  }//end function addBoolean

  /**
   * Boolean mit 3 Werten, true,false, null
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addBoolean3($key, $value, $notNull = false, $maxSize = null, $minSize = null)
  {

    if(is_null($value)){
      $value = null;
    } else {
      $value = strtolower(trim($value));

      if ('f' == $value  || 'false' == $value || '0' == $value) {
        $value = false; //f
      } elseif ('' == $value) {
        $value = false; // f | false per default
      } else {
        $value = true; // t
      }
    }

    // litle hack for search fields
    /*
    if ($value == '0') {
    $this->data[$key] = '-1';
    } else {
    $this->data[$key] = $value ? '1':'0';
    }
    */

    $this->data[$key] = $value;
    $this->invalid[$key] = false;

    return false;

  }//end function addBoolean

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addText($key, $value, $notNull = false, $maxSize = null, $minSize = null)
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->data[$key] = mb_substr(0, $value, $maxSize);
        return 'max';
      } else {
        $this->data[$key] = $value;
      }
    } else {
      $this->data[$key] = $value;
    }

    if ($notNull) {
      if (trim($value) == '') {
        return 'empty';
      }
    }

    if ($maxSize) {
      if (mb_strlen($this->data[$key]) > $maxSize) {
        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($this->data[$key]) < $minSize) {
        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end function addText

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addSearch($key, $value, $notNull = false, $maxSize = null, $minSize = null)
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $db = Db::getActive();
    $this->data[$key] = $db->addSlashes($value);

    if ($notNull) {
      if (trim($value) == ''  ) {
        return 'empty';
      }
    }

    if ($maxSize) {
      if (mb_strlen($this->data[$key]) > $maxSize) {
        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($this->data[$key]) < $minSize) {
        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end function addSearch

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
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    // sanitize HTML
    $sanitizer = LibSanitizer::getHtmlSanitizer();

    $purify = new LibVendorHtmlpurifier_ConfigSave();

    $sanitizer->config = $purify->getConfig();

    $value = $sanitizer->purify($value);

    $this->data[$key] = $value;

    if ($notNull) {
      if (trim($value) == ''  )
        return 'empty';
    }

    if ($maxSize) {
      if (mb_strlen($this->data[$key]) > $maxSize)
        return 'max';
    }

    if ($minSize) {
      if (mb_strlen($this->data[$key]) < $minSize)
        return 'min';
    }

    $this->invalid[$key] = false;

    return false;

  }//end function addHtml

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addHtmlPublish($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    // sanitize HTML
    $sanitizer = LibSanitizer::getHtmlSanitizer();

    $purify = new LibVendorHtmlpurifier_ConfigPublish();

    $sanitizer->config = $purify->getConfig();

    $value = $sanitizer->purify($value);

    $this->data[$key] = $value;

    if ($notNull) {
      if (trim($value) == ''  )
        return 'empty';
    }

    if ($maxSize) {
      if (mb_strlen($this->data[$key]) > $maxSize)
        return 'max';
    }

    if ($minSize) {
      if (mb_strlen($this->data[$key]) < $minSize)
        return 'min';
    }

    $this->invalid[$key] = false;

    return false;

  }

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addHtmlFull($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    // sanitize HTML
    $sanitizer = LibSanitizer::getHtmlSanitizer();

    $purify = new LibVendorHtmlpurifier_ConfigFull();

    $sanitizer->config = $purify->getConfig();

    $value = $sanitizer->purify($value);

    $this->data[$key] = $value;

    if ($notNull) {
      if (trim($value) == ''  )
        return 'empty';
    }

    if ($maxSize) {
      if (mb_strlen($this->data[$key]) > $maxSize)
        return 'max';
    }

    if ($minSize) {
      if (mb_strlen($this->data[$key]) < $minSize)
        return 'min';
    }

    $this->invalid[$key] = false;

    return false;

  }

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   * @return String
   */
  public function addJson($key, $value, $notNull = false, $maxSize = null, $minSize = null  )
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = true;

      return false;
    }

    $this->data[$key] = Db::addSlashes($value);

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end public function addJson

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
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $formatter = LibFormatterDate::getActive();

    Debug::console(I18n::$short.' '.I18n::$dateFormat .' '.  I18n::$dateSeperator  );

    $formatter->setFormat(I18n::$dateFormat);
    $formatter->setSeperator(I18n::$dateSeperator);

    if (!$formatter->setDateLanguage($value)) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    $this->data[$key] = $formatter->formatToEnglish();

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    /*
    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }
    */

    $this->invalid[$key] = false;

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
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    //TODO add a correct filter
    $this->data[$key] = $value;

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    /*
    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }
    */

    $this->invalid[$key] = false;

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
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    //TODO add a correct filter
    $this->data[$key] = $value;

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    /*
    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }
    */

    $this->invalid[$key] = false;

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
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $this->data[$key] = str_replace('\\', '\\\\', $value);

    if (!preg_match(self::VALIDATE_URL ,$value)  ) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end function addUrl

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addNetworkshare($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull && trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $this->data[$key] = str_replace('\\', '\\\\', $value);

    if (!preg_match(self::VALIDATE_URL ,$value)  ) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    if ($notNull && trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end function addNetworkshare

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addLink($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $this->data[$key] = $value;
    //$this->data[$key] = str_replace('\\', '\\\\', $value);

    /*
    if (!preg_match(self::VALIDATE_URL ,$value)  ) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }
    */

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end function addLink */

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
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $this->data[$key] = $value;

    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

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
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $this->data[$key] = $value;

    // musn't start with a number
    if (is_numeric($value[0])  ) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

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
      //$this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->data[$key] = SEncrypt::passwordHash($value);

    $this->invalid[$key] = false;

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
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $this->data[$key] = $value;

    // remove all __
    $testVal = str_replace('_','',$value);

    // musn't start with a number
    if (!ctype_alnum($testVal)) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end function addCname

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addCkey($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $this->data[$key] = $value;

    // remove all _ and -
    $testVal = str_replace(array('_','-') ,array('',''),$value);

    // musn't start with a number
    if (!ctype_alnum($testVal)) {
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end function addCkey


  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addFile($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull && !$value) {
      $this->invalid[$key] = false;

      return false;
    }

    // here we just get the filename
    if ($value) {
      $this->data[$key] = new LibUploadEntity($value,$key);
    }


    $this->invalid[$key] = false;

    return false;

  }//end function addFile

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addImage($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {

    if (!$notNull && !$value) {
      $this->invalid[$key] = false;

      return false;
    }

    // here we just get the filename
    if ($value) {
      $this->data[$key] = new LibUploadImageEntity($value,$key);
    }


    $this->invalid[$key] = false;

    return false;

  }//end function addImage

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
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    // here we just get the filename
    $this->data[$key] = SFiles::getFilename($value);

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end public function addFilename */

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
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    if (strpos('../', $value)) {
      $this->data[$key] = null;
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    //TODO add a correct filter
    $this->data[$key] = $value;

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

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
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    if (strpos('../', $value)) {
      $this->data[$key] = null;
      $this->invalid[$key] = 'wrong';

      return 'wrong';
    }

    //$this->data[$key] = SFiles::getPath($value);
    $this->data[$key] = $value;

    if ($notNull and trim($value) == '') {
      $this->invalid[$key] = 'emtpy';

      return 'emtpy';
    }

    if ($maxSize) {
      if (mb_strlen($value) > $maxSize) {
        $this->invalid[$key] = 'max';

        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($value) < $minSize) {
        $this->invalid[$key] = 'min';

        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end function addFoldername

  /**
   * @param string $key
   * @param scalar $value
   * @param boolean $notNull
   * @param int $maxSize
   * @param int $minSize
   */
  public function addUuid($key, $value, $notNull = false, $maxSize = null, $minSize = null   )
  {
    if (!$notNull and trim($value) == '') {
      $this->data[$key] = null;
      $this->invalid[$key] = false;

      return false;
    }

    $this->data[$key] = $value;

    if ($notNull) {
      if (trim($value) == ''  ) {
        return 'empty';
      }
    }

    if ($maxSize) {
      if (mb_strlen($this->data[$key]) > $maxSize) {
        return 'max';
      }
    }

    if ($minSize) {
      if (mb_strlen($this->data[$key]) < $minSize) {
        return 'min';
      }
    }

    $this->invalid[$key] = false;

    return false;

  }//end public function addUuid

/*//////////////////////////////////////////////////////////////////////////////
// Static Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *@param string $input
   */
  public static function sanitizeHtml($input)
  {

    if (is_null($input)) {
      return '';
    } elseif (is_array($input)) {
      $sant = array();

      foreach ($input as $pos => $value) {
        $sant[$pos] = self::sanitizeHtml($value);
      }

      return $sant;
    } elseif (is_scalar($input)) {
      return htmlspecialchars($input,ENT_QUOTES,'UTF-8');
    } else {
      Error::report('Got invalid datatype for santisize ' , $input);
    }

  }//end public static function santisizeHtml */

  /**
   *@param string $input
   */
  public static function sanitizeJson($input)
  {

    if (is_null($input)) {
      return '';
    } elseif (is_array($input)) {
      $sant = array();

      foreach ($input as $pos => $value) {
        $sant[$pos] = self::sanitizeJson($value);
      }

      return $sant;
    } elseif (is_scalar($input)) {
      return str_replace('"', '\"', $input);
    } else {
      Error::report('Got invalid datatype for santisize ' , $input);
    }

  }//end public static function sanitizeJson */

  /**
   *@param string $string
   */
  public static function sanitizeHtmlAttribute($input)
  {

    if (is_null($input)) {
      return '';
    } elseif (is_array($input)) {
      $sant = array();

      foreach ($input as $pos => $value) {
        $sant[$pos] = self::sanitizeJson($value);
      }

      return $sant;
    } elseif (is_scalar($input)) {
      return str_replace("'", "\'", $input);
    } else {
      Error::report('Got invalid datatype for santisize ' , $input);
    }

  }//end public static function sanitizeHtmlAttribute */

} // end class Validator

