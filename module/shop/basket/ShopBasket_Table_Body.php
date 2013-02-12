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
 *
 * @package WebFrap
 * @subpackage ModShop
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class ShopBasket_Table_Body
  extends WgtTemplate
{

  
  /**
   * @var ShopFront_Model
   */
  public $model = null;
  
////////////////////////////////////////////////////////////////////////////////
// Render Logik
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @return string
   */
  public function render()
  {
    
    
    $codeBasket = '<p>No articles yet</p>';

    return $codeBasket;
    
  }//end public function render */

  /**
   * @param array $article
   * @return string
   */
  public function renderArticle( array $article )
  {
    
    return <<<HTML

<div class="nearly_full wgt-space wgt-border wgt-box-article" >
  <h3>{$article['title']}</h3>
  <div class="image" >
    <a href="image.php?f=wbfsys_file-name-137205&s=medium&n=Q0lNRzAxNDcuSlBH" alt="CIMG0147.JPG" >
      <img src="thumb.php?f=wbfsys_file-name-137205&s=medium&n=Q0lNRzAxNDcuSlBH" alt="CIMG0147.JPG" style="max-width:100px;max-height:100px;">
    </a>
  </div>
  <div class="content" >
    <div><label>Price:</label>{$article['price']}</div>
    <div>
      <label>Desc:</label><br />
      {$article['description']}
    </div>
  </div>
  <div class="menu" >
    <button 
      class="wgt-button"
      onclick="\$R.post( 'ajax.php?c=Shop.Basket.addArticle' );"  >In den Warenkorb</button>
  </div>
  <div class="wgt-clear" >&nbsp;</div>
</div>
    
HTML;

    /*
<div id="wgt-shop-article-menu" class="wcm wcm_ui_tab" style="height:100%;height:100%;" >
      <div id="wgt-shop-article-menu-head" class="wgt_tab_head" style="padding-top:7px;" ></div>
      <div id="wgt-shop-article-menu-body" class="wgt_tab_body" >
        <div id="{$tabId}" class="wgt_tab wgt-shop-article-menu" title="Project All Projects"  >
          <p>FUUU</p>
          <div class="wgt-clear small" ></div>
    
        </div>
      </div>
    </div>
     */
    
  }//end public function renderArticle */

}//end class ShopBasket_Table_Body

