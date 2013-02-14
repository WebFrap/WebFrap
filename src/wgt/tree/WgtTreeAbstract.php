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
 * class WgtTreeAbstract
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class WgtTreeAbstract extends WgtAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  public $startPos      = 0;

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $icon       = null;

  /**
   * params for show url
   *
   * @var array
   */
  public $newUrl        = array();

  /**
   * params for tree url
   *
   * @var array
   */
  public $treeUrl        = array();

  /**
   * params for edit url
   *
   * @var array
   */
  public $editUrl        = array();

  /**
   * params for delete url
   *
   * @var array
   */
  public $deleteUrl      = array();

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function setStart($start )
  {
    $this->startPos = $start;
  }//end public function setStart */

  /**
   *
   */
  public function getStart()
  {
    return $this->startPos;
  }//end public function getStart */


  /**
   * set the icon for the tree
   *
   * @param string $icon
   */
  public function setIcon($icon  )
  {
    $this->icon = View::$iconsWeb.'xsmall/'.$icon;
  }//end public function setIcon */


}// end abstract class WgtTreeAbstract

