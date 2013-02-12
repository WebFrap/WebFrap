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
abstract class LibSerializerAbstract
{

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Data to serialize
   *
   * @var mixed
   */
  protected $toSerialize = null;

  /**
   *
   * @var array
   */
  protected $serialized   = null;

////////////////////////////////////////////////////////////////////////////////
// Magic
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function __construct( $toSerialize = null )
  {

    $this->toSerialize = $toSerialize;

  }//end protected function __construct

////////////////////////////////////////////////////////////////////////////////
// Getter and Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * set data to serialize
   *
   * @param unknown_type $toSerialize
   */
  public function setToSerialize($toSerialize)
  {
    $this->toSerialize = $toSerialize;
  }//end public function setToSerialize */

  /**
   * set Data to serialize
   *
   * @param mixed $toSerialize
   */
  public function setData($toSerialize)
  {
    $this->toSerialize = $toSerialize;
  }//end public function setData */

  /**
   * getter for serialized data
   *
   * @return string
   */
  public function getSerialized()
  {
    return $this->serialized;
  }//end public function getSerialized */

  /**
   * abstract serializer method
   */
  abstract public function serialize( $data = null );

} // end abstract class LibSerializerAbstract
