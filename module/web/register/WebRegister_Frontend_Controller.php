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
class WebRegister_Frontend_Controller extends ControllerFrontend
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
  protected $options = array
  (
    'listing' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'html' )
    ),
    'addarticle' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'removearticle' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'clear' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'update' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function service_listing( )
  {

    $view    = $this->getView();
    $request = $this->getRequest();

    /* @var $model ShopFront_Model */
    $model = $this->loadModel( 'ShopFront' );

    $storeId = $request->param('store', Validator::EID );

    if ($storeId )
      $model->setStoreId($storeId );
    else
      $storeId = $model->getDefStoreId();

    $body = new ShopBasket_Table_Body();
    /* @var $model ShopBasket_Model */
    $body->model = $this->loadModel( 'ShopBasket' );

    $frontend = new ShopFront_Frontend();
    $frontend->setModel($model );

    $frontend->render($view, $body );

  }//end public function service_listing */

  /**
   * @return void
   */
  public function service_addArticle( )
  {

    $view    = $this->getView();
    $request = $this->getRequest();

    /* @var $model ShopFront_Model */
    $model = $this->loadModel( 'ShopFront' );

    $storeId = $request->param('store', Validator::EID );

    if ($storeId )
      $model->setStoreId($storeId );
    else
      $storeId = $model->getDefStoreId();

    /* @var $view ShopBasket_Ajax_View */
    $view   = $response->loadView
    (
      'shop-basket-ajax',
      'ShopBasket',
      'displayAdd',
      View::AJAX
    );

    $articleId = $request->data( 'article', Validator::INT );
    $numOrder  = $request->data( 'int', Validator::INT );

    /* @var $shopBasket ShopBasket_Model */
    $shopBasket = $this->loadModel( 'ShopBasket' );

    $shopBasket->addArticle($articleId, $numOrder );
    $shopBasket->save( );

    $view->displayAddArticle($articleId, $numOrder );

  }//end public function service_addArticle */

  /**
   * @return void
   */
  public function service_removeArticle( )
  {

    $view    = $this->getView();
    $request = $this->getRequest();

    /* @var $model ShopFront_Model */
    $model = $this->loadModel( 'ShopFront' );

    $storeId = $request->param('store', Validator::EID );

    if ($storeId )
      $model->setStoreId($storeId );
    else
      $storeId = $model->getDefStoreId();

    /* @var $view ShopBasket_Ajax_View */
    $view   = $response->loadView
    (
      'shop-basket-ajax',
      'ShopBasket',
      'displayAdd',
      View::AJAX
    );

    $articleId = $request->data( 'article', Validator::INT );

    /* @var $shopBasket ShopBasket_Model */
    $shopBasket = $this->loadModel( 'ShopBasket' );

    $shopBasket->removeArticle($articleId );
    $shopBasket->save( );

    $view->displayAddArticle($articleId, $numOrder );

  }//end public function service_removeArticle */

  /**
   * @return void
   */
  public function service_clear( )
  {

    $view    = $this->getView();
    $request = $this->getRequest();

    /* @var $model ShopFront_Model */
    $model = $this->loadModel( 'ShopFront' );

    $storeId = $request->param('store', Validator::EID );

    if ($storeId )
      $model->setStoreId($storeId );
    else
      $storeId = $model->getDefStoreId();

    /* @var $view ShopBasket_Ajax_View */
    $view   = $response->loadView
    (
      'shop-basket-ajax',
      'ShopBasket',
      'displayClear',
      View::AJAX
    );

    $articleId = $request->data( 'article', Validator::INT );
    $numOrder  = $request->data( 'int', Validator::INT );

    /* @var $shopBasket ShopBasket_Model */
    $shopBasket = $this->loadModel( 'ShopBasket' );

    $shopBasket->clear( );
    $shopBasket->save( );

    $view->displayClear($articleId, $numOrder );

  }//end public function service_category */

  /**
   * @return void
   */
  public function service_update( )
  {

    $view    = $this->getView();
    $request = $this->getRequest();

    /* @var $model ShopFront_Model */
    $model = $this->loadModel( 'ShopFront' );

    $storeId = $request->param('store', Validator::EID );

    if ($storeId )
      $model->setStoreId($storeId );
    else
      $storeId = $model->getDefStoreId();

    /* @var $view ShopBasket_Ajax_View */
    $view   = $response->loadView
    (
      'shop-basket-ajax',
      'ShopBasket',
      'displayUpdate',
      View::AJAX
    );

     /* @var $shopBasket ShopBasket_Model */
    $shopBasket = $this->loadModel( 'ShopBasket' );

    $articles = $request->validateMultiData
    (
      array(
        'article' => array( Validator::INT, true ),
        'amount'  => array( Validator::INT, true ),
      ),
      'basket'
    );

    if ($articles )
      $shopBasket->updateArticles($articles );

    $shopBasket->save( );

    $view->displayUpdate( );

  }//end public function service_update */

}//end class ShopFront_Controller

