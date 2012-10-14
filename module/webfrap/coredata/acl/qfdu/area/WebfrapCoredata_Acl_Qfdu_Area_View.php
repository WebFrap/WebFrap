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
 * This Class was generated with a Cartridge based on the WebFrap GenF Framework
 * This is the final Version of this class.
 * It's not expected that somebody change the Code via Hand.
 *
 * You are allowed to change this code, but be warned, that you'll loose
 * all guarantees that where given for this project, for ALL Modules that
 * somehow interact with this file.
 * To regain guarantees for the code please contact the developer for a code-review
 * and a change of the security-hash.
 *
 * The developer of this Code has checksums to proof the integrity of this file.
 * This is a security feature, to check if there where any malicious damages
 * from attackers against your installation.
 *
 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapCoredata_Acl_Qfdu_Area_View
  extends LibTemplateAreaView
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

   /**
    * @var WebfrapCoredata_Acl_Model
    */
    public $model = null;

////////////////////////////////////////////////////////////////////////////////
// display methodes
////////////////////////////////////////////////////////////////////////////////

 /**
  * display the Quallified users tab
  *
  * @param int $areaId
  * @param TFlag $params
  *
  * @return boolean
  */
  public function displayTab( $areaId, $params )
  {

    // create the form action
    if( !$params->searchFormAction )
      $params->searchFormAction = 'index.php?c=Webfrap.Coredata_Acl.searchQfdUsers&area_id='.$areaId;

    // add the id to the form
    if( !$params->searchFormId )
      $params->searchFormId = 'wgt-form-table-project_iteration-acl-qfdu-search';

    // fill the relevant data for the search form
    $this->setSearchFormData( $params );

    // add the id to the form
    if( !$params->formId )
      $params->formId = 'wgt-form-project_iteration-acl-update';

     // create the form action
    if( !$params->formActionAppend )
      $params->formActionAppend = 'ajax.php?c=Webfrap.Coredata_Acl.appendQfdUser';

    // add the id to the form
    if( !$params->formIdAppend )
      $params->formIdAppend = 'wgt-form-project_iteration-acl-qfdu-append';

    // append form actions
    $this->setFormData( $params->formActionAppend, $params->formIdAppend, $params, 'Append' );

    // set the path to the template
    $this->setTemplate( 'project/iteration/maintab/acl/tab_qualified_users' );

    $this->addVar( 'areaId', $areaId );

    // create the ui helper object
    $ui = $this->loadUi( 'WebfrapCoredata_Acl_Qfdu' );

    // inject needed resources in the ui object
    $ui->setModel( $this->model );
    $ui->setView( $this );

    $ui->createListItem
    (
      $this->model->searchQualifiedUsers( $areaId, $params ),
      $areaId,
      $params->access,
      $params
    );

    //add selectbox
    $selectboxGroups = new WgtSelectbox( 'selectboxGroups', $this );
    $selectboxGroups->setData( $this->model->getAreaGroups( $areaId, $params ) );
    $selectboxGroups->addAttributes( array(
      'id'    => 'wgt-input-project_iteration-acl-qfdu-id_group',
      'name'  => 'wbfsys_group_users[id_group]',
      'class' => 'medium'
    ));

    $jsCode = <<<JSCODE

  \$S('input#wgt-input-project_iteration-acl-qfdu-id_user-tostring').data('assign',function( objid ){
    \$S('input#wgt-input-project_iteration-acl-qfdu-id_user').val(objid);
    \$R.get( 'ajax.php?c=Wbfsys.RoleUser.data&amp;objid='+objid );
  });

  \$S('input#wgt-input-project_iteration-acl-qfdu-vid-tostring').data('assign',function( objid ){
    \$S('input#wgt-input-project_iteration-acl-qfdu-vid').val(objid);
    \$R.get( 'ajax.php?c=Webfrap.Coredata.data&amp;objid='+objid );
  });

JSCODE;

    $this->addJsCode( $jsCode );

    // kein fehler alles klar
    return null;

  }//end public function displayTab */

} // end class WebfrapCoredata_Acl_Qfdu_Area_View */

