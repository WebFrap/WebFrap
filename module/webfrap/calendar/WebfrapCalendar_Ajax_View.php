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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapCalendar_Ajax_View extends LibTemplatePlain
{
/*//////////////////////////////////////////////////////////////////////////////
// display methodes
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * 
   * @var WebfrapCalendar_Model
   */
  public $model = null;

  
  /**
   * Übergabe der Suchergebnisse
   * @param array $entries
   */
  public function displaySearch( $params )
  {
  
    $tpl = $this->getTplEngine();
    
    
    $entries = $this->model->searchEvents( $params );
    
    
    $tpl->setRawJsonData($entries);

  
  }//end public function displaySearch */  


  /**
   * Autocomplete für User
   *
   * @param string $key
   * @param TArray $params
   */
  public function displayUserAutocomplete($key, $params)
  {

    $view = $this->getTpl();
    $view->setRawJsonData($this->model->getUserListByKey($key, $params));

  }//end public function displayUserAutocomplete */
  
  
  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $elementId
   */
  public function displayAddRef($refId, $msgId)
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = '#wgt-list-show-msg-ref-'.$msgId;
    $pageFragment->action = 'append';

    $msgRef = $this->model->loadRefById($refId);

    $pageFragment->setContent(<<<HTML
  <li><a 
    class="wcm wcm_req_ajax" 
    href="maintab.php?c={$msgRef['edit_link']}&objid={$msgRef['vid']}" 
    >{$msgRef['name']}:{$msgRef['title']}</a></li>
HTML

);

    $tpl->setArea('new_ref', $pageFragment);

  }//end public function displayAddRef */
  
  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param int $linkId
   */
  public function displayDelRef($linkId)
  {

    $tpl = $this->getTplEngine();
    $tpl->addJsCode("\$S('li#wgt-entry-msg-ref-".$linkId."').remove();");

  }//end public function displayDelRef */

} // end class WebfrapMessage_Ajax_View */

