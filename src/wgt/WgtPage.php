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
 * class WgtItemAbstract
 * Abstraktes Factory class
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtPage
{
/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @return string
   */
  public function __toString()
  {
    return $this->build();
  }//end public function __toString()

  /**
   * Enter description here...
   *
   * @return string
   */
  public function toHtml()
  {

  }//end public function toHtml()

  /**
   * Enter description here...
   *
   * @return string
   */
  public function toXml()
  {

  }//end public function toXml()

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @return string
   */
  public function build()
  {
    return '';
  }//end public function build()

} // end class WgtPage

