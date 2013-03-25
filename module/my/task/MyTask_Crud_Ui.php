<?php
/*******************************************************************************
          _______          ______    _______      ______    _______
         |   _   | ______ |   _  \  |   _   \    |   _  \  |   _   |
         |   1___||______||.  |   \ |.  1   / __ |.  |   \ |.  1___|
         |____   |        |.  |    \|.  _   \|__||.  |    \|.  __)_
         |:  1   |        |:  1    /|:  1    \   |:  1    /|:  1   |
         |::.. . |        |::.. . / |::.. .  /   |::.. . / |::.. . |
         `-------'        `------'  `-------'    `------'  `-------'
                             __.;:-+=;=_.
                                    ._=~ -...    -~:
                     .:;;;:.-=si_=s%+-..;===+||=;. -:
                  ..;::::::..<mQmQW>  :::.::;==+||.:;        ..:-..
               .:.:::::::::-_qWWQWe .=:::::::::::::::   ..:::-.  . -:_
             .:...:.:::;:;.:jQWWWE;.+===;;;;:;::::.=ugwmp;..:=====.  -
           .=-.-::::;=;=;-.wQWBWWE;:++==+========;.=WWWWk.:|||||ii>...
         .vma. ::;:=====.<mWmWBWWE;:|+||++|+|||+|=:)WWBWE;=liiillIv; :
       .=3mQQa,:=====+==wQWBWBWBWh>:+|||||||i||ii|;=$WWW#>=lvvvvIvv;.
      .--+3QWWc:;=|+|+;=3QWBWBWWWmi:|iiiiiilllllll>-3WmW#>:IvlIvvv>` .
     .=___<XQ2=<|++||||;-9WWBWWWWQc:|iilllvIvvvnvvsi|\'\?Y1=:{IIIIi+- .
     ivIIiidWe;voi+|illi|.+9WWBWWWm>:<llvvvvnnnnnnn}~     - =++-
     +lIliidB>:+vXvvivIvli_."$WWWmWm;:<Ilvvnnnnonnv> .          .- .
      ~|i|IXG===inovillllil|=:"HW###h>:<lIvvnvnnvv>- .
        -==|1i==|vni||i|i|||||;:+Y1""'i=|IIvvvv}+-  .
           ----:=|l=+|+|+||+=:+|-      - --++--. .-
                  .  -=||||ii:. .              - .
                       -+ilI+ .;..
                         ---.::....

********************************************************************************
*
* @author      : Dominik Bonsch <db@s-db.de>
* @date        :
* @copyright   : s-db.de (Softwareentwicklung Dominik Bonsch) <contact@s-db.de>
* @distributor : s-db.de <contact@s-db.de>
* @project     : S-DB Modules
* @projectUrl  : http://s-db.de
* @version     : 1
* @revision    : 1
*
* @licence     : S-DB Business <contact@s-db.de>
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
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <db@s-db.de>
 */
class MyTask_Crud_Ui extends MvcUi
{

  /**
  * the default model for this ui class
  * @var MyTask_Crud_Model
  */
  protected $model = null;

/*//////////////////////////////////////////////////////////////////////////////
// form methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * create fill all ui elements in the view for a model specific form
   *
   * @param TFlag $params named parameters
   * @return null / Error im Fehlerfall
   */
  public function createForm($params)
  {

    $view  = $this->getView();
    $orm   = $this->getOrm();

    //management wbfsys_task src wbfsys_task
    $fields = $this->model->getCreateFields();

    if (!$params->fieldsMyTask) {
      if (isset($fields['my_task']))
        $params->fieldsMyTask = $fields['my_task'];
      else
        $params->fieldsMyTask = array();
    }

    $entityMyTask = $this->model->getEntityMyTask();

    $formMyTask = $view->newForm('WbfsysTask');
    $formMyTask->setNamespace($params->namespace);
    $formMyTask->setPrefix('MyTask');
    $formMyTask->setKeyName('my_task');
    $formMyTask->setSuffix('create');
    $formMyTask->setAssignedForm($params->formId);
    $formMyTask->createForm
    (
      $entityMyTask,
      $params->fieldsMyTask
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
  public function editForm( $objid, $params)
  {

    $view = $this->getView();

    $entityMyTask = $this->model->getEntityWbfsysTask($objid);

    $fields = $this->model->getEditFields();

    if (!$params->fieldsMyTask) {
      if (isset($fields['wbfsys_task']))
        $params->fieldsMyTask = $fields['wbfsys_task'];
      else
        $params->fieldsMyTask = array();
    }

    $formMyTask = $view->newForm('WbfsysTask');
    $formMyTask->setNamespace($params->namespace);
    $formMyTask->setAssignedForm($params->formId);
    $formMyTask->setPrefix('WbfsysTask');
    $formMyTask->setKeyName('wbfsys_task');
    $formMyTask->setSuffix($entityMyTask->getid());
    if ($params->readOnly) {
      $formMyTask->setReadOnly(true);
    }

    $formMyTask->createForm
    (
      $entityMyTask,
      $params->fieldsMyTask
    );

    return true;

  }//end public function editForm */

  /**
   * create an ajax form
   *
   * @param WbfsysTask_Entity $entityMyTask
   * @param TFlag $params named parameters
   * @return void
   */
  public function ajaxForm($entityMyTask, $params  )
  {

    // laden der benötigten resourcen
    $view  = $this->getView();
    $orm   = $this->getOrm();

    // the ajax view should send the inputs as adressed values
    $params->refresh  = true;

    if (!$params->categories)
      $params->categories = array();

    if (!$params->fieldsMyTask)
      $params->fieldsMyTask = $entityMyTask->getCols($params->categories);

    $formMyTask = $view->newForm('WbfsysTask');

    if ($params->keyName)
      $formMyTask->setKeyName($params->keyName);

    if ($params->suffix)
      $formMyTask->setSuffix($params->suffix);

    if ($params->input)
      $formMyTask->setTarget($params->input);

    $formMyTask->createForm
    (
      $entityMyTask,
      $params->fieldsMyTask,
      $params
    );

    return true;

  }//end public function ajaxForm */

/*//////////////////////////////////////////////////////////////////////////////
// value methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * fetch the text value for an entity and deploy it to a given input element
   *
   *
   * @param WbfsysTask_Entity $entityMyTask
   * @param TFlag $params named parameters
   * @return void
   */
  public function textByKey($entityMyTask, $params)
  {

    // laden der benötigten resourcen
    $view = $this->getView();

    // push the to string information to the text field
    $replaceItemText = $view->newInput('textWbfsysTask', 'Text');
    $replaceItemText->addAttributes(array
    (
      'id'    => 'wgt-input-'.$params->input.'-tostring',
      'value' => $entityMyTask->text()
    ));

    // value means, that only the values of the ui elements are replaced
    // and not the complete ui element
    $replaceItemText->refresh = 'value';

    $replaceItem = $view->newInput('idWbfsysTask', 'Text');
    $replaceItem->addAttributes(array
    (
      'id'    => 'wgt-input-'.$params->input,
      'value' => $entityMyTask->getId()
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
  public function item($view, $field, $params)
  {

    $entityMyTask = new WbfsysTask_Entity();

    $formMyTask = $view->newForm('WbfsysTask');
    $formMyTask->createForm
    (
      $entityMyTask,
      array($field),
      $params
    );

  }//end public function item */

}//end class WbfsysTask_Crud_Ui

