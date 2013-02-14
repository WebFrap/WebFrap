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
 * This Class was generated with a Cartridge based on the WebFrap GenF Framework
 * This is the final Version of this class.
 * It's not expected that somebody change the Code via Hand.
 *
 * You are allowed to change this code, but be warned, that you'll loose
 * all guarantees that where given for this project, for ALL Modules that
 * somehow interact with this file.
 * To regain guarantees for the code please contact the developer for a code-review
 * and a change of the security-hash.
 *
 * The developer of this Code has checksums to proof the integrity of this file.
 * This is a security feature, to check if there where any malicious damages
 * from attackers against your installation.
 *
 *
 * @package WebFrap
 * @subpackage ModShop
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class ShopCms_Frontend_Controller extends ControllerFrontend
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @var boolean
   */
  protected $fullAccess         = true;
  
  /**
   * @var array
   */
  protected $meta = array
  (
    'page' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'html' )
    ),
  );
  
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @return void
   */
  public function service_page( )
  {

    $view     = $this->getView();
    $request  = $this->getRequest();
    
    /* @var $model ShopFront_Model */
    $baseModel = $this->loadModel( 'ShopFront' );
    
    $storeId = $request->param( 'store', Validator::EID );
    
    if( $storeId )
      $baseModel->setStoreId( $storeId );
    else 
      $storeId = $baseModel->getDefStoreId();
    
    $pageKey = $request->param( 'page', Validator::CKEY ) ;
    
    $model = $this->getCmsModel( );

    $body = new ShopCms_Page_Body( $this->getView() );
    $body->pageKey = $pageKey;
    $body->setModel( $model );
    
    $frontend = new ShopFront_Frontend();
    $frontend->setModel( $baseModel );
    
    $frontend->render( $view, $body );

  }//end public function service_page */


  /**
   * @return ShopCms_Frontend_Model
   */
  public function getCmsModel()
  {
    return $this->loadModel( 'ShopCms_Frontend' );
  }//end public function getCmsModel */

}//end class ShopFront_Controller

