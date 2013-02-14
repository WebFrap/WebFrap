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
 *  Basisklassen für handgeschriebene listenbasierte Masken
 * 
 * @package WebFrap
 * @subpackage wgt
 * @since 0.9.2
 */
class WgtModalRich extends WgtModal
{
/*//////////////////////////////////////////////////////////////////////////////
// Public Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var WgtListMenu
   */
  protected $listBuilder = null;
  
  /**
   * @var WgtFormBuilder
   */
  protected $formBuilder = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Public Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param array $actions
   */
  protected function setupListMenu( $actions )
  {
    
    $this->listBuilder = new WgtListMenu( $actions );
    
  }//end protected function setupListMenu */
  
  /**
   * @param array $row
   * @param array $actions
   */
  protected function renderActions( $row, $actions = null )
  {
    
    return $this->listBuilder->renderActions( $row, $actions );
    
  }//end rotected function renderActions */
  
  /**
   * @param string $action
   * @param string $domainKey
   * @param string $method
   * @param boolean $cout
   */
  protected function newFormBuilder( $action, $domainKey, $method = 'post', $cout = true )
  {
    
    return new WgtFormBuilder( $this, $action, $domainKey, $method, $cout );
    
  }//end protected function newFormBuilder */


} // end class WgtMaintabList

