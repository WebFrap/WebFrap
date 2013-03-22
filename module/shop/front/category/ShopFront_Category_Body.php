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
class ShopFront_Category_Body extends WgtTemplate
{

  /**
   * @var string
   */
  public $category = null;

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

    $articles = $this->model->getCategoryArticles($this->category);

    $size = count($articles);

    if (!$size) {
      $codeArticles = '<p>Found no Articles for this Category</p>';
    } else {

      $codeArticles = <<<CODE
  <div class="wgt-crumb wgt-box slide" style="margin-top:5px;" >
    <span>Start</span> / <span>Fuu</span>
  </div>
CODE;

      foreach ($articles as $article) {
        $codeArticles .= $this->renderArticle($article);
      }

    }

    return $codeArticles;

  }//end public function render */

  /**
   * @param array $article
   * @return string
   */
  public function renderArticle(array $article)
  {

    $artNum = base64_encode($article['article_number']);
    $price = SFormatNumber::formatMoney($article['price']);

    $icons = array();
    $icons[] = $this->icon('shop/art_flags/new.png', 'New');
    $icons[] = $this->icon('shop/art_flags/popular.png', 'Popular');
    $icons[] = $this->icon('shop/art_flags/our_tip.png', 'Our Tip');
    $icons[] = $this->icon('shop/art_flags/price_tip.png', 'Price Tip');
    $icons[] = $this->icon('shop/art_flags/test_winner.png', 'Test Winner');

    $codeIcons = implode(NL, $icons);

    return <<<HTML

<div class="wgt-border wgt-box-article list" >

    <div class="head" >
      <label><a href="frontend.php?c=Shop.Front.article&id={$article['article_id']}" >{$article['title']}</a></label>
      <div class="tags" >
      {$codeIcons}
      </div>
      <div class="art_num" >
        <span>Atr.Nr. {$article['article_number']}, Herst. Nr.: fuu</span>
      </div>
    </div>

    <div class="image" >
      <a href="image.php?f=wbfsys_file-name-{$article['image']}&s=medium&n={$artNum}" alt="Article {$article['article_number']}" >
        <img src="thumb.php?f=wbfsys_file-name-{$article['image']}&s=medium&n={$artNum}" alt="Article {$article['article_number']}" style="max-width:100px;max-height:100px;">
      </a>
    </div>

    <div class="content" >
      {$article['short_desc']}
    </div>

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
          <button class="wgt-button" onclick="\$R.post('ajax.php?c=Shop.Basket.addArticle');"  >In den Warenkorb</button>
        </li>
        <li>
          <a  href="frontend.php?c=Shop.Front.article&id={$article['article_id']}"  >Details anzeigen</a>
        </li>
        <li>
          &gt; <span class="wgt-action" onclick="\$R.post('ajax.php?c=Shop.Compare.addArticle');"  >Vergleichen</span>
        </li>
        <li>
          &gt; <span class="wgt-action" onclick="\$R.post('ajax.php?c=Shop.Compare.addArticle');"  >Merken</span>
        </li>
        <li>
          &gt; <span class="wgt-action" onclick="\$R.post('ajax.php?c=Shop.Compare.addArticle');"  >Benachrichtigung</span>
        </li>
        <li>
          &gt; <span class="wgt-action" onclick="\$R.post('ajax.php?c=Shop.Compare.addArticle');"  >Angebot anfordern</span>
        </li>
        <li>
          &gt; <span class="wgt-action" onclick="\$R.post('ajax.php?c=Shop.Compare.addArticle');"  >Frage stellen</span>
        </li>
      </ul>

    </div>

    <div class="foot" >
      <div>
      </div>
    </div>

    <div class="wgt-clear" >&nbsp;</div>
</div>

HTML;

  }//end public function renderArticle */

}//end class ShopFront_Category_Body

