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
class WgtSelectboxWebfrapServerOs extends WgtSelectboxHardcoded
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   */
  public function load()
  {

    $this->firstFree = ' ';

    $this->data =  array
    (
    ECoreServerOs::WINDOWS => array( 'value' => ECoreServerOs::$text[ECoreServerOs::WINDOWS] ),
    ECoreServerOs::LINUX   => array( 'value' => ECoreServerOs::$text[ECoreServerOs::LINUX] ),
    ECoreServerOs::SOLARIS => array( 'value' => ECoreServerOs::$text[ECoreServerOs::SOLARIS] ),
    ECoreServerOs::BSD     => array( 'value' => ECoreServerOs::$text[ECoreServerOs::BSD] ),
    ECoreServerOs::MAC     => array( 'value' => ECoreServerOs::$text[ECoreServerOs::MAC] )
    );

  }//end public function load()

} // end class WgtSelectboxCoreServerOs

