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
 * @subpackage Acl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclUser_Area_View extends LibTemplateAreaView
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

   /**
    * @var AclMgmt_Model
    */
    public $model = null;

   /**
    * @var DomainNode
    */
    public $domainNode = null;

/*//////////////////////////////////////////////////////////////////////////////
// display methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * display the Quallified users tab
  *
  * @param int $areaId
  * @param TFlag $params
  *
  * @return boolean
  */
  public function displayTab($areaId, $params )
  {

    // create the form action
    $params->searchFormAction = 'index.php?c=Acl.Mgmt_Qfdu.searchListUsers&dkey='
      .$this->domainNode->domainName.'&area_id='.$areaId;

    // add the id to the form
    $params->searchFormId = 'wgt-form-table-'.$this->domainNode->aclDomainKey.'-acl-tuser-search';

    // fill the relevant data for the search form
    $this->setSearchFormData($params );

    // add the id to the form
    $params->formId = 'wgt-form-'.$this->domainNode->aclDomainKey.'-acl-update';

     // create the form action
    $params->formActionAppend = 'ajax.php?c=Acl.Mgmt_Qfdu.appendUser&dkey='.$this->domainNode->domainName;

    // add the id to the form
    $params->formIdAppend = 'wgt-form-'.$this->domainNode->aclDomainKey.'-acl-tuser-append';

    // append form actions
    $this->setFormData($params->formActionAppend, $params->formIdAppend, $params, 'Append' );

    // set the path to the template
    $this->setTemplate( 'acl/mgmt/maintab/tab_list_by_users' );

    $this->addVar( 'areaId', $areaId );
    $this->addVar( 'domain', $this->domainNode );

    // create the ui helper object
    $ui = $this->loadUi( 'AclMgmt_Qfdu_User' );

    // inject needed resources in the ui object
    $ui->setModel($this->model );
    $ui->setView($this );
    $ui->domainNode = $this->domainNode;

    $ui->createListItem
    (
      $this->model->loadListByUser_Users($params ),
      $params->access,
      $params
    );

    //add selectbox
    $selectboxGroups = new WgtSelectbox( 'selectboxGroups', $this );
    $selectboxGroups->setData($this->model->getAreaGroups($areaId, $params ) );
    $selectboxGroups->addAttributes( array(
      'id'    => 'wgt-input-'.$this->domainNode->aclDomainKey.'-acl-tuser-id_group',
      'name'  => 'group_users[id_group]',
      'class' => 'medium asgd-'.$params->formIdAppend
    ));

    $jsCode = <<<JSCODE

  \$S('input#wgt-input-{$this->domainNode->aclDomainKey}-acl-tuser-id_user-tostring').data('assign',function( objid ){
    \$S('input#wgt-input-{$this->domainNode->aclDomainKey}-acl-tuser-id_user').val(objid);
    \$R.get( 'ajax.php?c=Wbfsys.RoleUser.data&amp;objid='+objid );
  });

  \$S('input#wgt-input-{$this->domainNode->aclDomainKey}-acl-tuser-vid-tostring').data('assign',function( objid ){
    \$S('input#wgt-input-{$this->domainNode->aclDomainKey}-acl-tuser-vid').val(objid);
    \$R.get( 'ajax.php?c={$this->domainNode->aclDomainKey}.data&amp;objid='+objid );
  });

JSCODE;

    $this->addJsCode($jsCode );

    // kein fehler alles klar
    return null;

  }//end public function displayTab */

} // end class AclMgmt_Qfdu_User_Area_View */

