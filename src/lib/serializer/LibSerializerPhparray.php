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
 * @subpackage core/serializer
 */
class LibSerializerPhparray extends LibSerializerAbstract
{

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  protected $varName = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function __construct($toSerialize = null , $varName = null)
  {
    if (Log::$levelVerbose)
      Log::create(get_class($this));

    $this->toSerialize = $toSerialize;
    $this->varName = $varName;

  }//end protected function __construct

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * set the name of the serialized PHP Array
   *
   * @param String $varName
   */
  public function setVarName($varName)
  {
    $this->varName = $varName;
  }//end public function setVarName($varName)

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   */
  protected function subParser($data , $pre)
  {
   if (Log::$levelDebug)
      Log::start(__FILE__ , __LINE__ , __METHOD__ , array($data));

    $assembled = NL.$pre.'array('.NL;

    foreach ($data as $key => $value) {
      if (is_array($value)) {
        $assembled .= $pre."'".$key.'\' => '.$this->subParser($value , $pre.'  ');
      } elseif (is_object($value)) {
        throw new LibSerializerException('Invalid data to Serialize');
      } else {
        $assembled .= $pre."'".$key.'\' => \''.SParserString::quoteForSingleQuotes($value)."',".NL;
      }
    }
    $assembled .=  $pre.'),'.NL;

    return $assembled;

  }//end public function subParser($data)

  /**
   * Enter description here...
   *
   * @param array $data
   * @return string
   */
  protected function serializeArray($data)
  {
   if (Log::$levelDebug)
      Log::start(__FILE__ , __LINE__ , __METHOD__ , array($data));

    $assembled = $this->varName.' = array('.NL;

    foreach ($data as $key => $value) {
      if (is_array($value)) {
        $assembled .= "'".$key.'\' => '.$this->subParser($value , '  ');
      } elseif (is_object($value)) {
        throw new LibSerializerException('Invalid data to Serialize');
      } else {
        $assembled .= "'".$key.'\' => \''.SParserString::quoteForSingleQuotes($value)."',".NL;
      }
    }

    $assembled .=  ');'.NL;

    $this->serialized = $assembled;
  }//end public function serializeArray($data)

  /**
   * serializer method
   * just serializes a php array to phpcode
   * @param array
   * @return string
   */
  public function serialize($data = null)
  {
   if (Log::$levelDebug)
      Log::start(__FILE__ , __LINE__ , __METHOD__);

    if (!is_null($data)) {
      $this->toSerialize = $data;
    }

    if (!is_array($this->toSerialize)) {
      throw new LibSerializerException('Invalid data to Serialize');
    }

    $this->serializeArray($this->toSerialize);

    return $this->serialized;
  }//end public function serialize()

} // end class LibSerializerPhparray

