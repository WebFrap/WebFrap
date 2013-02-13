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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebRegister_Frontend_Ajax_View
  extends LibTemplateAjaxView
{
  
  /**
   * @var ShopBasket_Model
   */
  public $model = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param int $articleId
   * @param int $numOrder
   * @return void
   */
  public function displayAddArticle( $articleId, $numOrder )
  {
    
    $response = $this->getResponse();
    $response->addMessage( 'Added article to the shopping basket' );

  }//end public function displayAddArticle */
  
  /**
   * Löschen des Artikels 
   * @param int $idArticle
   * @return void
   */
  public function displayRemoveArticle( $articleId )
  {

    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="tr#wgt-table-shop_basket-entry-{$idArticle}" action="remove" />
XML
    );

  }//end public function displayRemoveArticle */
  
  
  /**
   * Daten zu dem Warenkorb anpassen
   * @param int $idArticle
   * @return void
   */
  public function displayUpdate(  )
  {


  }//end public function displayUpdate */
  

  /**
   * Entfernen aller Artikel aus dem Warenkorb
   * @return void
   */
  public function displayClear(  )
  {


  }//end public function displayUpdate */
  
 

}//end class ShopBasket_Ajax_View

