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
 * @subpackage webfrap/groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapContact_Ajax_View extends LibTemplatePlain
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $menuName
   * @return void
   */
  public function displayNew( $params = null )
  {


    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#webfrap-desktop-contact-form';
    $pageFragment->action = 'html';
    $pageFragment->setModel($this->loadModel('WebfrapContact'));

    $pageFragment->setTemplate( 'webfrap/contact/tpl/form_new', true);

    $tpl->setArea('new_contact', $pageFragment);

    $tpl->addJsCode("\$S('#webfrap-desktop-contact-form').show();");

  }//end public function displayNew */

}//end class WebfrapContact_Ajax_View

