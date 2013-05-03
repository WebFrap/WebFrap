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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage ModEnterprise
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class Example_Json_View extends LibTemplateServiceView
{

  /**
   * Die Breite des Modal Elements
   * @var int in px
   */
  public $width   = 950 ;

  /**
   * Die Höhe des Modal Elements
   * @var int in px
   */
  public $height   = 650 ;

/*//////////////////////////////////////////////////////////////////////////////
// Display Methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * the default edit form
  * @param DomainNode $domainNode
  * @param TFlag $params
  * @return boolean
  */
  public function displayEntity($domainNode, $params)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      $domainNode->label.' Protocol',
      $domainNode->domainI18n.'.label'
    );

    // set the window title
    $this->setTitle($i18nText);

    // set the window status text
    $this->setLabel($i18nText);

    // set the from template
    $this->setTemplate('maintenance/modal/entity/protocol_entity');

    // create
    $table = new WebfrapProtocol_Table_Element('tableProtocol', $this);
    $table->setData($this->model->getEntityProtocol($domainNode, $params));


    $table->setPagingId('wgt-from-'.$domainNode->domainName.'-maint-search');

    // create panel
    $tabPanel = new WgtPanelTable($table);

    $tabPanel->title = $this->i18n->l($domainNode->label, $domainNode->domainI18n.'.label') ;
    $tabPanel->searchKey = $domainNode->domainName.'-maint-search';

    $table->buildProtocolEntityHtml();
    $this->addElement('tableProtocol', $table  );
    //$this->addMenuProtocolEntity($params);
    //$this->addActionsProtocolEntity($params);

    $this->addVar('context', 'protocol');

    // ok kein fehler aufgetreten
    return null;

  }//end public function displayEntity */

}//end class Example_Json_View

