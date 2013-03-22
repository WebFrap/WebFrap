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
class ShopFront_Menu extends WgtTemplate
{

  /**
   * @var ShopFront_Model
   */
  protected $model = null;

  /**
   * @return string
   */
  public function render()
  {

    $iconEntity = $this->icon('controlls/entity.png', 'Entity');

    $user = $this->getUser();

    $catList = $this->model->getMenuCategories();
    $catCode = $this->renderRootEntry($catList);

    $userMenu = '';

    if ($user->getLogedIn()) {
      $userMenu = <<<CODE
  <h3>My Data</h3>
  <ul class="wgt-tree" >
    <li><a href="frontend.php?c=Shop.User_Frontend.myData" >My Data</a></li>
    <li><a href="frontend.php?c=Shop.Auth.logout" >Logout</a></li>
  </ul>

CODE;

    } else {

      $packageForm = new WgtRenderForm
      (
        'index.php?c=Shop.User_Frontend.login',
        'wgt-form-shop-login',
        'post',
        false
      );

      $packageForm->ajax = false;

      $userMenu = <<<HTML
<h3>Login</h3>
{$packageForm->form()}
  <div class="wgt-login-box" >
    {$packageForm->input('User', 'user')}
    {$packageForm->password('Password', 'passwd',null,array(),null,'medium',false)}
    {$packageForm->submit('Login')}
  </div>
  <ul class="wgt-tree" >
    <li><a href="frontend.php?c=Shop.User_Frontend.formRegister" >Konto eröffnen</a></li>
    <li><a href="frontend.php?c=Shop.User_Frontend.forgotPwd" >Passwort vergessen</a></li>
  </ul>
HTML;

    }

    return <<<HTML


{$userMenu}

  <h3>Bestellung</h3>
  <ul class="wgt-tree" >
    <li><a href="frontend.php?c=Shop.Basket.listing" >Shop Basket</a></li>
    <li><a href="frontend.php?c=Shop.Basket.listing" >Bestellung abschliesen</a></li>
  </ul>

  <h3>Artikel</h3>
  <ul class="wcm wcm_ui_tree" >
{$catCode}
  </ul>

  <h3>Informationen</h3>
  <ul class="wgt-tree" >
    <li><a href="frontend.php?c=Shop.Basket.listing" >AGB</a></li>
    <li><a href="frontend.php?c=Shop.Basket.listing" >Versandkosten</a></li>
    <li><a href="frontend.php?c=Shop.Basket.listing" >Zahlungsmöglichkeiten</a></li>
    <li><a href="frontend.php?c=Shop.Basket.listing" >Rücksendungen</a></li>
    <li><a href="frontend.php?c=Shop.Basket.listing" >Datenschutz</a></li>
    <li><a href="frontend.php?c=Shop.Basket.listing" >Impressum</a></li>
  </ul>

HTML;

  }//end public function render */

  /**
   * @param ShopFront_MenuCategory_Query $catList
   */
  public function renderRootEntry($catList)
  {

    $code = '';

    foreach ($catList as $listEntry) {

      $entryCode = $this->renderChildEntry($catList, $listEntry['rowid']);

      $code .= '    <li><a href="frontend.php?c=Shop.Front.category&amp;key='.$listEntry['access_key'].'" >'.$listEntry['name'].'</a>'.$entryCode.'</li>'.NL;
    }

    return $code;

  }//end public function renderRootEntry */

  /**
   * @param ShopFront_MenuCategory_Query $catList
   * @param int $key
   */
  public function renderChildEntry($catList, $key)
  {

    if (!$children = $catList->getNodeChildren($key)  )
      return '';

    $code = '      <ul>'.NL;

    foreach ($children as $listEntry) {
      $entryCode = $this->renderChildEntry($catList, $listEntry['rowid']);
      $code .= '        <li><a href="frontend.php?c=Shop.Front.category&amp;key='.$listEntry['access_key'].'" >'.$listEntry['name'].'</a>'.$entryCode.'</li>'.NL;
    }

    $code .= '      </ul>'.NL;

    return $code;

  }//end public function renderChildEntry */

}//end class ShopFront_Footer

