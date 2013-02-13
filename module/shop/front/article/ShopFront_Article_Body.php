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
class ShopFront_Article_Body
  extends WgtTemplate
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var int
   */
  public $articleId = null;
  
  /**
   * @var ShopFront_Model
   */
  public $model = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Render Logik
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @return string
   */
  public function render()
  {
    
    
    $article = $this->model->getArticleData( $this->articleId );

    if( !$article )
    {
      $codeArticle = '<div class="wgt-box error" >Sorry, the requested Article not exists</div>';
    }
    else 
    {
      
      $codeArticles = $this->renderArticle( $article );
      
    }

    return $codeArticles;
    
  }//end public function render */

  /**
   * @param array $article
   * @return string
   */
  public function renderArticle( array $article )
  {
    
    $artNum = base64_encode( $article['article_number'] );
    $price = SFormatNumber::formatMoney( $article['price'] );
    
    $icons = array();
    $icons[] = $this->icon( 'shop/art_flags/new.png', 'New' );
    $icons[] = $this->icon( 'shop/art_flags/popular.png', 'Popular' );
    $icons[] = $this->icon( 'shop/art_flags/our_tip.png', 'Our Tip' );
    $icons[] = $this->icon( 'shop/art_flags/price_tip.png', 'Price Tip' );
    $icons[] = $this->icon( 'shop/art_flags/test_winner.png', 'Test Winner' );
    
    $codeIcons = implode( NL, $icons );
    
    return <<<HTML
    
<div id="wgt-box-article-{$article['article_id']}" class="wgt-box-article" >

  <!-- main content for the article -->
  <div class="wgt-space wgt-border main" >
    
    <!-- head top -->
    <div class="head" >
      <label>{$article['title']}</label>
      <div class="tags" >
      {$codeIcons}
      </div>
      <div class="art_num" >
        <span>Atr.Nr. {$article['article_number']}, Herst. Nr.: fuu</span>
      </div>
    </div>
    
    <!-- image left -->
    <div class="image" >
      <a href="image.php?f=wbfsys_file-name-{$article['image']}&s=medium&n={$artNum}" alt="Article {$article['article_number']}" >
        <img 
          src="thumb.php?f=wbfsys_file-name-{$article['image']}&s=medium&n={$artNum}" 
          alt="Article {$article['article_number']}" 
          style="max-width:100px;max-height:100px;" />
      </a>
    </div>
    
    <!-- content in the middle -->
    <div class="content" >
      {$article['short_desc']}
    </div>
    
    <!-- menu on the right side of the article -->
    <div class="menu" >
      
      <div class="price" >
        {$price} €
      </div>
      <div class="distribution" >
        ab 4,99 € <span class="action" >Versandkosten</span>
      </div>
      <div class="availability" >
        availability
      </div>
      
      <ul>
        <li>
          <button class="wgt-button" onclick="\$R.post( 'ajax.php?c=Shop.Basket.addArticle' );"  >In den Warenkorb</button>
        </li>
        <li>
          &gt; <span class="wgt-action" onclick="\$R.post( 'ajax.php?c=Shop.Compare.addArticle' );"  >Vergleichen</span>
        </li>
        <li>
          &gt; <span class="wgt-action" onclick="\$R.post( 'ajax.php?c=Shop.Compare.addArticle' );"  >Merken</span>
        </li>
        <li>
          &gt; <span class="wgt-action" onclick="\$R.post( 'ajax.php?c=Shop.Compare.addArticle' );"  >Benachrichtigung</span>
        </li>
        <li>
          &gt; <span class="wgt-action" onclick="\$R.post( 'ajax.php?c=Shop.Compare.addArticle' );"  >Angebot anfordern</span>
        </li>
        <li>
          &gt; <span class="wgt-action" onclick="\$R.post( 'ajax.php?c=Shop.Compare.addArticle' );"  >Frage stellen</span>
        </li>
      </ul>
      
    </div>
    
    <div class="foot" >
      <div>
      </div>
    </div>
    
    <div class="wgt-clear" >&nbsp;</div>
  </div>
  
  <!-- Image Slider Gallery -->
  <div class="gallery wgt-border wgt-space" >
    <img src="thumb.php?f=wbfsys_file-name-{$article['image']}&s=medium&n={$artNum}" alt="Article {$article['article_number']}" style="max-width:70px;max-height:70px;">
  </div>
  
  <!-- Details Tab -->
  <div class="details wgt-space" style="position:relative;" >
  
    <div id="wgt-box-article_details-{$article['article_id']}" class="wcm wcm_ui_tab wgt-border"  >
      
      <!-- tab head -->
      <div id="wgt-box-article_details-{$article['article_id']}-head" class="wgt_tab_head" >
  
        <div class="wgt-container-controls">
          <div class="tab_outer_container">
            <div class="tab_scroll" >
              <div class="tab_container"></div>
            </div>
          </div>
        </div>
        
      </div>
      
      <!-- tab body -->
      <div id="wgt-box-article_details-{$article['article_id']}-body" class="wgt_tab_body" >
        
        <!-- tab dataheet -->
        <div 
          id="wgt-box-article_details-{$article['article_id']}-datasheet"  
          title="Datasheet"  
          class="wgt_tab wgt-box-article_details-{$article['article_id']}" >
          <fieldset  class="wgt-space" >
            <legend>Datasheet</legend>
          </fieldset>
        </div>
        
        <!-- tab accessoires -->
        <div 
          id="wgt-box-article_details-{$article['article_id']}-accessoires"  
          title="Accessoires"  
          class="wgt_tab wgt-box-article_details-{$article['article_id']}" >
          <fieldset class="wgt-space"  >
            <legend>Accessoires</legend>
          </fieldset>
          <fieldset class="wgt-space"  >
            <legend>Bought else</legend>
          </fieldset>
        </div>

        
        <!-- tab tests -->
        <div 
          id="wgt-box-article_details-{$article['article_id']}-tests"  
          title="Product Tests"  
          class="wgt_tab wgt-box-article_details-{$article['article_id']}" >
          <fieldset  class="wgt-space"  >
            <legend>Product Tests</legend>
          </fieldset>
        </div>
        
        <!-- tab comments & ratings -->
        <div 
          id="wgt-box-article_details-{$article['article_id']}-questions"  
          title="Questions &amp; Feedback"  
          class="wgt_tab wgt-box-article_details-{$article['article_id']}" >
          <fieldset  class="wgt-space"  >
            <legend>Questions &amp; Feedback</legend>
          </fieldset>
        </div>
    
      </div>
      
      <!-- tab footer -->
      <div class="bar" >Article</div>
      
      <div class="wgt-clear xxsmall" ></div>
      
    </div>
  
    <div class="wgt-clear xxsmall" ></div>
  </div>
  
  <!-- Similar Products -->
  <div class="smiliar" >
    <div class="wcm wcm_req_action" wgt_src="ajax.php?c=Shop.BaseArticle." ></div>
  </div>
  
</div>

<!-- Abstand zum Boden -->
<div class="wgt-clear medium" ></div>

HTML;


  }//end public function renderArticle */

}//end class ShopArticle_Body

