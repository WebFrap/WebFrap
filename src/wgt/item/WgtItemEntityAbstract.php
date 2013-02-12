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
abstract class WgtItemEntityAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the entity Name
   *
   * @var string
   */
  public $entity = null;

  /**
   * the virtual id to map to a dataset
   * (optional)
   * @var int
   */
  public $vid = null;

  /**
   * the namespace of the data entity
   *
   * @var string
   */
  public $nameSpace = 'webfrap';

  public $saveUrl = '';

  /**
   * should all comments be loaded or only the comments with the users lang
   *
   * @var boolean
   */
  public $multiLingual = true;

  /**
   * Enter description here...
   *
   * @var set the comment tree editable
   */
  public $editAble = false;

  /**
   * the pre id for the item
   *
   * @var string
   */
  public $preId = null;

  /**
   * the data array
   *
   * @var array
   */
  public $data = array();

////////////////////////////////////////////////////////////////////////////////
// Getter, Setter, Adder, Remover
////////////////////////////////////////////////////////////////////////////////

  /**
   * set the entity name for the comment
   *
   * @param string $entity
   */
  public function setEntity($entity)
  {
    if(Log::$levelDebug)
      Log::start( __file__ , __line__ ,__method__ ,array($entity) );

    $this->entity = $entity;
  }//end public function setTable($table)

  /**
   * set the virtual id
   *
   * @param int $vid
   */
  public function setVid($vid)
  {
    if(Log::$levelDebug)
      Log::start( __file__ , __line__ ,__method__ ,array($vid) );

    $this->vid = $vid;
  }//end public function setVid($vid)

  /**
   * Enter description here...
   *
   * @param unknown_type $nameSpace
   */
  public function setNameSpace($nameSpace)
  {
    if(Log::$levelDebug)
      Log::start( __file__ , __line__ ,__method__ ,array($nameSpace) );

    $this->nameSpace = $nameSpace;
  }//end public function setNameSpace($nameSpace)

  /**
   * Enter description here...
   *
   * @param boolean $flag
   */
  public function setMultiLingual( $flag = true )
  {

    $this->multiLingual = $flag;

  }//end public function setMultiLingual( $flag = true )

  /**
   * Enter description here...
   *
   */
  public function setEditAble( $flag = true )
  {
    $this->editAble = $flag;
  }//end public function setEditAble( $flag = true )

  /**
   * set
   *
   */
  public function setPreId( $preId )
  {
    $this->preId = $preId;
  }//end public function setPreId( $preId )

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   */
  abstract protected function load();

  /**
   * build the item to html
   *
   * @return string
   */
  public function toHtml()
  {
    return $this->build();
  }//end public function toHtml()

  /**
   * build the item to html
   *
   * @return string
   */
  public function __toString()
  {
    return $this->build();
  }//end public function __toString()

  /**
   * public function build the tabs
   * @return string
   */
  abstract public function build( );

} // end class WgtItemEntityAbstract
