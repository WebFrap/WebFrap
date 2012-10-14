<?php
/*******************************************************************************
*
* @author      : Ralf Kronen <ralf.krnone@webfrap.net>
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
 * @subpackage Daidalos
 * @author Ralf Kronen <ralf.krnone@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosPayment_Maintab_View
  extends WgtMaintab
{
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  
  /**
   * @param TFlag $params
   * @return void
   */
  public function displayForm( $params )
  {

    $this->setLabel( 'Payment Tester' );
    $this->setTitle( 'Payment Tester');

    $this->setTemplate( 'daidalos/payment/maintab/form_test' );

    $params = new TArray();
    $this->addMenu( $params  );

  }//end public function displayForm */
  
 

  /**
   * add a drop menu to the create window
   *
   * @param TFlowFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu( $params  )
  {

    $menu     = $this->newMenu
    (
      $this->id.'_dropmenu',
      'DaidalosPayment'
    );
    
    $menu->id = $this->id.'_dropmenu';
    $menu->buildMenu( $params );
    
    $menu->injectActions( $this, $params );

  }//end public function addMenu */

}//end class DaidalosPayment_Maintab_View

