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
 * class WgtMenuEntryAbstract
 * Objekt zum generieren des Mainmenus eines Users
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class WgtMenuEntryAbstract
  extends WgtItemAbstract
{

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $title   = null;

  /**
   * Enter description here...
   *
   * @var string
   */
  public $text    = null;

  /**
   * Enter description here...
   *
   * @var string
   */
  public $icon    = null;

  /**
   * @var string
   */
  public $seperator = '&gt;';

  /**
   * @var string
   */
  public $class = 'ajax';

////////////////////////////////////////////////////////////////////////////////
// Getter and Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   * @param String $data
   */
  public function setUrl( $data )
  {
    $this->data = $data;
  }//end public function setUrl

  /**
   * Enter description here...
   *
   * @param string $title
   */
  public function setTitle( $title )
  {
    $this->title = $title;
  }//end public function setTitle

  /**
   * Enter description here...
   *
   * @param unknown_type $class
   */
  public function setClass( $class )
  {
    $this->class = $class;
  }//end public function setClass

  /**
   * Enter description here...
   *
   * @param string $text
   */
  public function setText( $text )
  {
    $this->text = $text;
  }//end public function setText

  /**
   * Enter description here...
   *
   * @param string $text
   */
  public function setIcon( $icon )
  {
    $this->icon = $icon;
  }//end public function setIcon( $icon )

  /**
   * Enter description here...
   *
   * @param string $text
   */
  public function setSeperator( $sep )
  {
    $this->seperator = $sep;
  }//end public function setSeperator( $icon )


} // end WgtMenuEntryAbstract

