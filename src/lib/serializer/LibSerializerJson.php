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
 * serializer to json
 * @package WebFrap
 * @subpackage core/serializer
 */
class LibSerializerJson
  extends LibSerializerAbstract
{
////////////////////////////////////////////////////////////////////////////////
// constaten
////////////////////////////////////////////////////////////////////////////////

  const ARRAY_START = '[';

  const ARRAY_END = ']';

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * instance of the serializer
   *
   * @var LibSerializerJson
   */
  private static $instance = null;

////////////////////////////////////////////////////////////////////////////////
// Singleton
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return LibSerializerJson
   * @deprecated
   */
  public static function getInstance()
  {

    if (is_null(self::$instance)) {
      self::$instance = new LibSerializerJson();
    }

    return self::$instance;

  }//end public static function getInstance */
  /**
   * @return LibSerializerJson
   */
  public static function getActive()
  {

    if (is_null(self::$instance)) {
      self::$instance = new LibSerializerJson();
    }

    return self::$instance;

  }//end public static function getActive */

////////////////////////////////////////////////////////////////////////////////
// serializer
////////////////////////////////////////////////////////////////////////////////

  /**
   * serialize to json
   * @return string
   */
  public function serializeJson( $data )
  {

    $serialized = self::ARRAY_START;

    if ( (is_array( $data ) || (is_object($data) && $data instanceof Iterator))  ) {
      $serialized .= $this->serializeArray($data);
    } else {
      $serialized .= '"'.urlencode($data).'"';
    }

    $serialized .= self::ARRAY_END;

    return $this->serialized = $serialized;

  }//end public function serializeJson($data)

  /**
   * serialize to json
   * @return string
   */
  public function serializeArray( $data )
  {

    $serialized = '';

    foreach ($data as $val) {
      if ( (is_array( $val ) || (is_object($val) && $val instanceof Iterator)) ) {
        $serialized .= self::ARRAY_START.$this->serializeArray($val).self::ARRAY_END.',';
      } else {
        $serialized .= '"'.urlencode($val).'",';
      }
    }

    return substr( $serialized , 0 , -1 );

  }//end public function serializeArray */

  /**
   * serializer method
   * just serializes a php array to phpcode
   * @param array
   * @return string
   */
  public function serialize($data = null)
  {

    if ( !is_null( $data ) ) {
      $this->toSerialize = $data;
    }

    if ( !(is_array( $this->toSerialize ) || (is_object($this->toSerialize) && $this->toSerialize instanceof Iterator)) ) {
      throw new LibSerializerException('Invalid data to Serialize');
    }

    $this->serializeJson($this->toSerialize);

    return $this->serialized;

  }//end public function serialize  */

} // end class LibSerializerJson
