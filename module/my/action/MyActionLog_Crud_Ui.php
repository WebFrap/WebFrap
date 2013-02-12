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
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <db@s-db.de>
 */
class MyActionLog_Crud_Ui
  extends MvcUi
{

  /**
  * the default model for this ui class
  * @var MyActionLog_Crud_Model
  */
  protected $model = null;

////////////////////////////////////////////////////////////////////////////////
// form methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * create fill all ui elements in the view for a model specific form
   *
   * @param TFlag $params named parameters
   * @return null / Error im Fehlerfall
   */
  public function createForm( $params )
  {

    $view  = $this->getView();
    $orm   = $this->getOrm();

    //management wbfsys_task src wbfsys_task
    $fields = $this->model->getCreateFields();

    if (!$params->fieldsMyActionLog) {
      if(isset($fields['my_task']))
        $params->fieldsMyActionLog = $fields['my_task'];
      else
        $params->fieldsMyActionLog = array();
    }

    $entityMyActionLog = $this->model->getEntityMyActionLog();

    $formMyActionLog = $view->newForm('WbfsysActionLog');
    $formMyActionLog->setNamespace($params->namespace);
    $formMyActionLog->setPrefix('MyActionLog');
    $formMyActionLog->setKeyName('my_task');
    $formMyActionLog->setSuffix('create');
    $formMyActionLog->setAssignedForm($params->formId);
    $formMyActionLog->createForm
    (
      $entityMyActionLog,
      $params->fieldsMyActionLog
    );

    return null;

  }//end public function createForm */

  /**
   * create an edit formular
   *
   * @param int $objid,
   * @param TFlag $params named parameters
   * @return void
   */
  public function editForm(  $objid, $params )
  {

    $view = $this->getView();

    $entityMyActionLog = $this->model->getEntityWbfsysActionLog( $objid );

    $fields = $this->model->getEditFields();

    if (!$params->fieldsMyActionLog) {
      if(isset($fields['wbfsys_task']))
        $params->fieldsMyActionLog = $fields['wbfsys_task'];
      else
        $params->fieldsMyActionLog = array();
    }

    $formMyActionLog = $view->newForm('WbfsysActionLog');
    $formMyActionLog->setNamespace($params->namespace);
    $formMyActionLog->setAssignedForm($params->formId);
    $formMyActionLog->setPrefix('WbfsysActionLog');
    $formMyActionLog->setKeyName('wbfsys_task');
    $formMyActionLog->setSuffix($entityMyActionLog->getid());
    if ($params->readOnly) {
      $formMyActionLog->setReadOnly(true);
    }

    $formMyActionLog->createForm
    (
      $entityMyActionLog,
      $params->fieldsMyActionLog
    );

    return true;

  }//end public function editForm */

  /**
   * create an ajax form
   *
   * @param WbfsysActionLog_Entity $entityMyActionLog
   * @param TFlag $params named parameters
   * @return void
   */
  public function ajaxForm( $entityMyActionLog, $params  )
  {

    // laden der benötigten resourcen
    $view  = $this->getView();
    $orm   = $this->getOrm();

    // the ajax view should send the inputs as adressed values
    $params->refresh  = true;

    if( !$params->categories )
      $params->categories = array();

    if( !$params->fieldsMyActionLog )
      $params->fieldsMyActionLog = $entityMyActionLog->getCols( $params->categories );

    $formMyActionLog = $view->newForm('WbfsysActionLog');

    if($params->keyName)
      $formMyActionLog->setKeyName($params->keyName);

    if($params->suffix)
      $formMyActionLog->setSuffix($params->suffix);

    if($params->input)
      $formMyActionLog->setTarget($params->input);

    $formMyActionLog->createForm
    (
      $entityMyActionLog,
      $params->fieldsMyActionLog,
      $params
    );

    return true;

  }//end public function ajaxForm */

////////////////////////////////////////////////////////////////////////////////
// value methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * fetch the text value for an entity and deploy it to a given input element
   *
   *
   * @param WbfsysActionLog_Entity $entityMyActionLog
   * @param TFlag $params named parameters
   * @return void
   */
  public function textByKey( $entityMyActionLog, $params )
  {

    // laden der benötigten resourcen
    $view = $this->getView();

    // push the to string information to the text field
    $replaceItemText = $view->newInput( 'textWbfsysActionLog', 'Text' );
    $replaceItemText->addAttributes(array
    (
      'id'    => 'wgt-input-'.$params->input.'-tostring',
      'value' => $entityMyActionLog->text()
    ));

    // value means, that only the values of the ui elements are replaced
    // and not the complete ui element
    $replaceItemText->refresh = 'value';

    $replaceItem = $view->newInput( 'idWbfsysActionLog', 'Text' );
    $replaceItem->addAttributes(array
    (
      'id'    => 'wgt-input-'.$params->input,
      'value' => $entityMyActionLog->getId()
    ));

    // value means, that only the values of the ui elements are replaced
    // and not the complete ui element
    $replaceItem->refresh = 'value';

  }//end public function textByKey */

  /**
   *
   * @param ViewTemplateWindow $view
   * @param string $field
   * @param TFlag $params named parameters
   * @return void
   */
  public function item( $view, $field, $params )
  {

    $entityMyActionLog = new WbfsysActionLog_Entity();

    $formMyActionLog = $view->newForm('WbfsysActionLog');
    $formMyActionLog->createForm
    (
      $entityMyActionLog,
      array($field),
      $params
    );

  }//end public function item */

}//end class WbfsysActionLog_Crud_Ui
