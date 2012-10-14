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
class Webfrap_Acl_Ui
  extends Ui
{
////////////////////////////////////////////////////////////////////////////////
// CRUD Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * create an edit formular
   * @param int $objid,
   * @param TFlowFlag $params named parameters
   * @return void
   */
  public function editForm( $objid, $params )
  {

    $entityWbfsysSecurityArea = $this->model->getEntityWbfsysSecurityArea( $objid );

    $fields = $this->model->getEditFields();
    $fields['wbfsys_security_area'][] = 'rowid';

    $params->fieldsWbfsysSecurityArea = $fields['wbfsys_security_area'];

    $formWbfsysSecurityArea = $this->view->newForm('WbfsysSecurityArea');
    $formWbfsysSecurityArea->setNamespace($params->namespace);
    $formWbfsysSecurityArea->setAssignedForm($params->formId);
    $formWbfsysSecurityArea->setPrefix('WbfsysSecurityArea');
    $formWbfsysSecurityArea->setKeyName('wbfsys_security_area');
    $formWbfsysSecurityArea->setSuffix($entityWbfsysSecurityArea->getid());
    $formWbfsysSecurityArea->createForm
    (
      $entityWbfsysSecurityArea,
      $params->fieldsWbfsysSecurityArea
    );

    return true;

  }//end public function editForm */

////////////////////////////////////////////////////////////////////////////////
// Listing Methodes
////////////////////////////////////////////////////////////////////////////////


  /**
   * fill the elements in a search form
   *
   * @return void
   */
  public function searchForm()
  {

    $entityWbfsysSecurityAccess  = $this->model->getEntityWbfsysSecurityAccess();
    $fieldsWbfsysSecurityAccess  = $entityWbfsysSecurityAccess->getSearchCols();

    $formWbfsysSecurityAccess    = $this->view->newForm('WbfsysSecurityAccess');
    $formWbfsysSecurityAccess->setNamespace('WbfsysSecurityAccess');
    $formWbfsysSecurityAccess->setPrefix('WbfsysSecurityAccess');
    $formWbfsysSecurityAccess->setKeyName('wbfsys_security_access');
    $formWbfsysSecurityAccess->createSearchForm
    (
      $entityWbfsysSecurityAccess,
      $fieldsWbfsysSecurityAccess
    );

  }//end public function searchForm */

} // end class WebFrap_Acl_Ui */

