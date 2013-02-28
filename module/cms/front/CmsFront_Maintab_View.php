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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class CmsFront_Maintab_View extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

/*//////////////////////////////////////////////////////////////////////////////
// form export methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param WbfsysDocuPage $helpPage
  * @param TFlag $params
  */
  public function displayPage($key, $params )
  {

    $page    = $this->model->getPage($key );

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      'Preview: {@label@}',
      'wbf.label',
      array
      (
        'label' => $page->title
      )
    );

    // set the window title
    $this->setTitle($i18nText );

    // set the window status text
    $this->setLabel($i18nText );

    $tplNode = $this->model->getTemplate($page );

    $this->texts->addData($this->model->getTexts($tplNode ) );
    $this->menus->addData($this->model->getMenus($tplNode ) );

    $this->setIndex('cms/default');
    $this->setTemplate( 'cms/'.$tplNode->access_key );

    $this->addVar( 'page', $page->parsed_content );

    $this->addMenu($params );

    // kein fehler aufgetreten
    return null;

  }//end public function displayPage */

 /**
  * @param WbfsysDocuPage $helpPage
  * @param TFlag $params
  */
  public function displayPreview($key, $params )
  {

    $page    = $this->model->getPage($key );

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      'Preview: {@label@}',
      'wbf.label',
      array
      (
        'label' => $page->title
      )
    );

    // set the window title
    $this->setTitle($i18nText );

    // set the window status text
    $this->setLabel($i18nText );

    $tplNode = $this->model->getTemplate($page );

    $this->texts = $this->model->getTexts($tplNode );
    $this->menus = $this->model->getMenus($tplNode );

    $this->setIndex( 'cms/default' );
    $this->setTemplate( 'cms/'.$tplNode->access_key );

    $this->addVar( 'page', $page->parsed_content );

    $this->addMenu($params );

    // kein fehler aufgetreten
    return null;

  }//end public function displayPreview */

/*//////////////////////////////////////////////////////////////////////////////
// protocol for entities
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * add a drop menu to the create window
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addMenu($params )
  {

    $i18n         = $this->getI18n();

    $iconMenu     = '<i class="icon-reorder" ></i>';
    $iconSupport  = $this->icon( 'control/support.png'      ,'Support');
    $iconHelp     = $this->icon( 'control/help.png'      ,'Help');
    $iconClose    = $this->icon( 'control/close.png'      ,'Close');
    $iconEdit     = $this->icon( 'control/edit.png'      ,'Edit');
    $iconBug      = $this->icon( 'control/bug.png'      ,'Bug');

    $menu          = $this->newMenu($this->id.'_dropmenu' );
    $menu->content = <<<HTML
<ul class="wcm wcm_ui_dropmenu wgt-dropmenu" id="{$this->id}_dropmenu" >
  <li class="wgt-root" >
    <button class="wcm wcm_ui_button" >{$iconMenu} {$i18n->l('Menu','wbf.label')}</button>
    <ul style="margin-top:-10px;" >
      <li class="current" >
        <p>{$iconSupport} {$i18n->l('Support','wbf.label')}</p>
        <ul>
          <li>
            <a class="wcm wcm_req_ajax" href="modal.php?c=Webfrap.Bug.create&amp;context=webfrap_docu-create" >
              {$iconBug} {$i18n->l('Bug','wbf.label')}
            </a>
          </li>
        </ul>
      </li>
      <li>
        <p class="wgtac_close" >{$iconClose} {$i18n->l('Close','wbf.label')}</p>
      </li>
    </ul>
  </li>
</ul>
HTML;

  }//end public function addMenu */

  /**
   * this method is for adding the buttons in a create window
   * per default there is only one button added: save with the action
   * to save the window onclick
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addActions($helpPage, $params )
  {

  }//end public function addActions */

}//end class WebfrapDocu_Subwindow_View

