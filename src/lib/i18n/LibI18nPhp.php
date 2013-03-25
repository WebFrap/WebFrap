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
  * Php Backend für die Internationalisierungsklasse
  * @package WebFrap
  * @subpackage tech_core
  */
class LibI18nPhp
  implements ArrayAccess
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * in l werden alle key value paare für die internationalisierung gespeichert
   * l wird mit den Daten der Dateien in den i18n foldern befüllt
   * @var array
   */
  protected $l = array();

  /**
   * Kürzel der aktuell aktiven klasse
   *
   * @var string
   */
  protected $lang = null;

  /**
   * Pfad zu den Sprachdaten
   *
   * @var String the language Package in use
   */
  protected $lPackage = null;

  /**
   * Path to the language files
   * @var string
   */
  protected $folder = null;

  /**
   *
   * @var unknown_type
   */
  protected $changed = false;

  /**
   * die Aktive Sprache
   *
   * @var string
   */
  public $short = 'en';

  /**
   * Trenner für das Datum
   * @var string
   */
  public $dateSeperator = '-';

  /**
   * Format für das Datum
   * @var string
   */
  public $dateFormat  = 'Y-m-d';

  /**
   * Format für Zeiten
   * @var string
   */
  public $timeFormat  = 'H:i:s';

  /**
   * Trenner für Zeiten
   * @var string
   */
  public $timeSteperator = ':';

  /**
   * Format für Timestamps
   * @var string
   */
  public $timeStampFormat  = 'Y-m-d H:i:s';

  /**
   *
   * @var string
   */
  public $numberMil  = ',';

  /**
   *
   * @var string
   */
  public $numberDec  = '.';

/*//////////////////////////////////////////////////////////////////////////////
// Magic Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param $conf
   */
  public function __construct($conf = array() , $def = false)
  {

    $this->setLangByConf($conf , $def);

  }//end public function __construct

  public function setLangByKey($key , $def = false)
  {

    $conf = Conf::get('i18n');

    $this->lang     = $key;
    //$this->lPackage = $conf['lang_path'];

    ///TODO add better error handling
    $langConf = $conf[$key];

    $this->short            = $langConf['short'];
    $this->dateSeperator    = $langConf['dateSeperator'];
    $this->dateFormat       = $langConf['dateFormat'];
    $this->timeFormat       = $langConf['timeFormat'];
    $this->timeSteperator   = $langConf['timeSteperator'];
    $this->timeStampFormat  = $langConf['timeStampFormat'];
    $this->numberMil        = $langConf['numberMil'];
    $this->numberDec        = $langConf['numberDec'];

    if ($def) {
      I18n::$short            = $langConf['short'];
      I18n::$dateSeperator    = $langConf['dateSeperator'];
      I18n::$dateFormat       = $langConf['dateFormat'];
      I18n::$timeFormat       = $langConf['timeFormat'];
      I18n::$timeSteperator   = $langConf['timeSteperator'];
      I18n::$timeStampFormat  = $langConf['timeStampFormat'];
      I18n::$numberMil        = $langConf['numberMil'];
      I18n::$numberDec        = $langConf['numberDec'];
    }

    $this->folder   = $this->lang.'/' ;

    $this->loadCache();

  }//end public function setLangByKey */

  /**
   *
   */
  public function setLangByConf($conf = array() , $def = false)
  {

    if (!$conf) {
      $conf = Conf::get('i18n');
    }

    $this->lang     = Conf::status('activ.language');
    //$this->lPackage = $conf['lang_path'];

    ///TODO add better error handling
    $langConf = $conf[$this->lang];

    $this->short            = $langConf['short'];
    $this->dateSeperator    = $langConf['dateSeperator'];
    $this->dateFormat       = $langConf['dateFormat'];
    $this->timeFormat       = $langConf['timeFormat'];
    $this->timeSteperator   = $langConf['timeSteperator'];
    $this->timeStampFormat  = $langConf['timeStampFormat'];
    $this->numberMil        = $langConf['numberMil'];
    $this->numberDec        = $langConf['numberDec'];

    if ($def) {
      I18n::$short            = $langConf['short'];
      I18n::$dateSeperator    = $langConf['dateSeperator'];
      I18n::$dateFormat       = $langConf['dateFormat'];
      I18n::$timeFormat       = $langConf['timeFormat'];
      I18n::$timeSteperator   = $langConf['timeSteperator'];
      I18n::$timeStampFormat  = $langConf['timeStampFormat'];
      I18n::$numberMil        = $langConf['numberMil'];
      I18n::$numberDec        = $langConf['numberDec'];
    }

    $this->folder   = $this->lang.'/' ;

    $this->loadCache();

  }//end public  function setLangByConf */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: ArrayAccess
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * (non-PHPdoc)
   * @see ArrayAccess#offsetSet()
   */
  public function offsetSet($offset, $value)
  {
    $this->l[$offset] = $value;
  }//end public function offsetSet */

  /**
   * (non-PHPdoc)
   * @see ArrayAccess#offsetGet()
   */
  public function offsetGet($offset)
  {

    if (!isset($this->l[$offset]))
      $this->includeLang($offset);

    return $this->getLang($offset);

  }//end public function offsetGet */

  /**
   * (non-PHPdoc)
   * @see ArrayAccess#offsetUnset()
   */
  public function offsetUnset($offset)
  {
    unset($this->l[$offset]);
  }//end public function offsetUnset */

  /**
   * (non-PHPdoc)
   * @see ArrayAccess#offsetExists
   */
  public function offsetExists($offset)
  {

    if (!isset($this->l[$offset]))
      $this->includeLang($offset);

    return isset($this->l[$offset])?true:false;

  }//end public function offsetExists */

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function loadCache()
  {

    $keyPath = str_replace('.' , '/' , Webfrap::$indexKey  );
    $file = PATH_GW.'cache/i18n/'.$this->lang.'/'.$keyPath.'/'.Webfrap::$indexKey.'.php';

    if (file_exists($file))
      include $file;

  }//end public function loadCache */

  /**
   *
   */
  public function saveCache()
  {

    if (!$this->changed)
      return;

    // append class index
    $index = '<?php
  $this->l = array
  ('.NL;

    foreach ($this->l as $repo => $values) {
      if (is_array($values)) {
        $index .= " '$repo' => array(".NL;
        foreach ($values as $key => $value) {
          $index .= "    '$key' => '$value',".NL;
        }
        $index .= "),".NL;
      }
    }

    $index .= NL.');'.NL;

    $keyPath = str_replace('.' , '/' , Webfrap::$indexKey  );
    $path = PATH_GW.'cache/i18n/'.$this->lang.'/'.$keyPath.'/';
    $file = $path.Webfrap::$indexKey.'.php';

    if (!is_dir($path)  )
      if (!SFilesystem::createFolder($path))
        return;

    file_put_contents($file , $index);

  }//end public function saveCache */

  /**
   * setzten der aktiven sprache
   *
   * @param string $lang aktive sprache
   */
  public function setLang($lang, $def = false)
  {

    $this->setLangByKey($lang, $def);

  }//end public function setLang */

  /**
   * setzen des aktuel aktiven sprachpakets
   *
   * @param string $lang aktive sprache
   */
  public function setLPackage($lPackage)
  {

    $this->lPackage   = $lPackage;
    $this->folder = $this->lang.'/' ;

  }//end public function setLPackage */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   */
  public function getChanged()
  {
    return $this->changed;
  }//end public function getChanged */

  /**
   * eine sprachdatei laden
   *
   * @param string $key
   */
  public function includeLang($key)
  {

    if (!is_string($key))
      return;

    $folders = explode('.' , $key);

    //array_pop($folders); // last element away

    $fileName = array_pop($folders); // get the filename
    $folder   = implode('/',$folders).'/'.$fileName.".php";

    foreach (I18n::$i18nPath as $path) {
      if (file_exists($path.$this->folder.$folder)) {

        if (DEBUG)
          Debug::console('Load I18N File: '.$path.$this->folder.$folder);

        $this->changed = true;

        include $path.$this->folder.$folder;
      }
    }

  }//end public function includeLang */

  /**
   *
   * @param string $text der Text in der Standard Sprache
   * @param string $key Key zum internationalsieren
   * @param string $data
   * @return string
   */
  public function l($text, $key, $data = array())
  {

    //2 Parameter Syntax ummappen
    if (is_array($key)) {
      $data = $key;
      $key  = $text;
    }

    if (!isset($this->l[$key]))
      $this->includeLang($key);

    if (!isset($this->l[$key][$text])) {
      Debug::console('MISSING I18N: repo: '.$key.' key: '.$text);
      if ($data) {

        $keys = array();

        foreach(array_keys($data) as $keyData)
          $keys[] = '{@'.$keyData.'@}';

        return str_replace( $keys, array_values($data), $text);

      } else {
        return $text;
      }
    }

    if ($data) {

      $keys = array();

      foreach(array_keys($data) as $keyData)
        $keys[] = '{@'.$keyData.'@}';

      return str_replace( $keys, array_values($data), $this->l[$key][$text]);

    } else {
      return $this->l[$key][$text];
    }

  }//end public function l */

/*//////////////////////////////////////////////////////////////////////////////
// i18n Formatters
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param string $date
   * @return string
   */
  public function date($date = null)
  {
    return date($this->dateFormat, strtotime($date));
  }//end public function date */

  /**
   *
   * @param string $time
   * @return string
   */
  public function time($time = null)
  {
    return date($this->timeFormat, strtotime($time));
  }//end public function time */

  /**
   *
   * @param string $time
   * @return string
   */
  public function timestamp($time = null)
  {
    return date($this->timeStampFormat, strtotime($time));
  }//end public function timestamp */

  /**
   *
   * @param float $number
   * @param int $decimals
   */
  public function number($number, $decimals = 2)
  {
    return number_format($number, $decimals, $this->numberDec, $this->numberMil);
  }//end public function number */

} // end class LibI18nPhp

