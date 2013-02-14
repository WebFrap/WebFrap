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
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyMessage_Crud_Create_Form extends WgtCrudForm
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * namespace for the actual form
   * @setter WgtCrudForm::setNamespace()
   * @getter WgtCrudForm::getNamespace()
   * @var string 
   */
  public $namespace  = 'MyMessage';

  /**
   * prename for the ui elements to avoid redundant names in the forms
   * normally the entity key (the tablename), is used
   *
   * @setter WgtCrudForm::setPrefix()
   * @getter WgtCrudForm::getPrefix()
   * @var string 
   */
  public $prefix      = 'MyMessage';

  /**
   * suffixes are used to create multiple instances of forms for diffrent
   * datasets, normaly the suffix is the id of a dataset or "-new" for
   * create forms
   *
   * @setter WgtCrudForm::setSuffix()
   * @getter WgtCrudForm::getSuffix()
   * @var string 
   */
  public $suffix      = null;
 
  /**
   * Standard Liste der Felder die angezeigt werden sollen
   *
   * @var array
   */
  protected $fields      = array
  (
      'my_message' => array
      (
        'id_sender' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'id_status' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'id_refer' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'priority' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'deliver_date' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'deliver_time' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'title' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '400',
        ),
        'message' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'rowid' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'm_time_created' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'm_role_create' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'm_time_changed' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'm_role_change' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'm_version' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'm_uuid' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
      ),

  );

  /**
   * Die Haupt Entity für das Formular
   *
   * @var WbfsysMessage_Entity 
   */
  public $entity      = null;
  
  /**
  * Erfragen der Haupt Entity 
  * @param int $objid
  * @return WbfsysMessage_Entity
  */
  public function getEntity( )
  {

    return $this->entity;

  }//end public function getEntity */
    
  /**
  * Setzen der Haupt Entity 
  * @param WbfsysMessage_Entity $entity
  */
  public function setEntity( $entity )
  {

    $this->entity = $entity;
    $this->rowid  = $entity->getId();
    
  }//end public function setEntity */


  /**
   * request all fields that have to be fetched from the request
   * @return array
   */
  public function getSaveFields()
  {

    return array
    (
      'my_message' => array
      (
        'id_sender',
        'id_status',
        'id_refer',
        'priority',
        'deliver_date',
        'deliver_time',
        'title',
        'message',
        'm_version',
      ),

    );

  }//end public function getSaveFields */

/*//////////////////////////////////////////////////////////////////////////////
// Form Methodes
//////////////////////////////////////////////////////////////////////////////*/
    
 /**
  * create an IO form for the WbfsysMessage entity
  *
  * @param Entity $entity the entity object
  * @param array $fields list with all elements that shoul be shown in the ui
  * @namedParam TFlag $params named parameters
  * {
  *   string prefix     : prefix for the inputs;
  *   string target     : target for;
  *   boolean readOnly  : set all elements to readonly;
  *   boolean refresh   : refresh the elements in an ajax request ;
  *   boolean sendElement : if true, then the system will send the elements in
  *   ajax requests als serialized html and not only just as value
  * }
  */
  public function renderForm( $params = null  )
  {

    $params  = $this->checkNamedParams( $params );
    $i18n     = $this->view->i18n;

    // add the entity to the view
    $this->view->addVar( 'entity', $this->entity );
    $this->view->addVar( 'entityMyMessage', $this->entity );


    $this->db     = $this->getDb();
    
    if (!$this->suffix )
    {
      $this->suffix = $this->rowid?:'';
    }

    if( $this->target )
      $sendTo = 'wgt-input-'.$this->target.'-tostring';
    else
      $sendTo = 'wgt-input-my_message'.($this->suffix?'-'.$this->suffix:'').'-tostring';

    $inputToString = $this->view->newInput( 'input'.$this->prefix.'ToString' , 'Text' );
    $inputToString->addAttributes
    (
      array
      (
        'name'  => 'my_message[id_my_message-tostring]',
        'id'    => $sendTo,
        'value' => $this->entity->text(),
      )
    );

    $inputToString->setReadOnly( $this->readOnly );
    $inputToString->refresh = $this->refresh;


    // attribute my_message : id_sender
    if
    (
      isset( $this->fields['my_message']['id_sender'] )
        && Webfrap::classLoadable( 'WbfsysRoleUser_Entity' )
     )
    {


      //p: Window
      $objidWbfsysRoleUser = $this->entity->getData( 'id_sender' ) ;

      // entity ids can never be 0 so thats ok
      if
      (
        !$objidWbfsysRoleUser
          || !$entityWbfsysRoleUser = $this->db->orm->get
          (
            'WbfsysRoleUser',
            $objidWbfsysRoleUser
          )
      )
      {
        $entityWbfsysRoleUser = $this->db->orm->newEntity( 'WbfsysRoleUser' );
      }

      $inputIdSender = $this->view->newInput( 'inputMyMessageIdSender', 'Window' );
      $this->items['my_message-id_sender'] = $inputIdSender;
      $inputIdSender->addAttributes(array
      (
        'readonly'  => 'readonly',
        'name'      => 'my_message[id_sender]',
        'id'        => 'wgt-input-my_message_id_sender'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title'     => $i18n->l( 'Insert value for Sender (Message)', 'wbfsys.message.label' ),
      ));

      if( $this->assignedForm )
        $inputIdSender->assignedForm = $this->assignedForm;

      $inputIdSender->setWidth( 'medium' );

      $inputIdSender->setData( $this->entity->getData( 'id_sender' )  );
      $inputIdSender->setReadonly( $this->fieldReadOnly( 'my_message', 'id_sender' ) );
      $inputIdSender->setRequired( $this->fieldRequired( 'my_message', 'id_sender' ) );
      $inputIdSender->setLabel( $i18n->l( 'Sender', 'wbfsys.message.label' ) );


      $listUrl = 'modal.php?c=Wbfsys.RoleUser.selection'
        .'&amp;suffix='.$this->suffix.'&input=my_message_id_sender'.($this->suffix?'-'.$this->suffix:'');

      $inputIdSender->setListUrl ( $listUrl );
      $inputIdSender->setListIcon( 'webfrap/connect.png' );
      $inputIdSender->setEntityUrl( 'maintab.php?c=Wbfsys.RoleUser.edit' );
      $inputIdSender->conEntity         = $entityWbfsysRoleUser;
      $inputIdSender->refresh           = $this->refresh;
      $inputIdSender->serializeElement  = $this->sendElement;



      $inputIdSender->view = $this->view;
      $inputIdSender->buildJavascript( 'wgt-input-my_message_id_sender'.($this->suffix?'-'.$this->suffix:'') );
      $this->view->addJsCode( $inputIdSender );

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


    }

    // attribute my_message : id_refer
    if
    (
      isset( $this->fields['my_message']['id_refer'] )
        && Webfrap::classLoadable( 'WbfsysMessage_Entity' )
     )
    {


      //p: Window
      $objidWbfsysMessage = $this->entity->getData( 'id_refer' ) ;

      // entity ids can never be 0 so thats ok
      if
      (
        !$objidWbfsysMessage
          || !$entityWbfsysMessage = $this->db->orm->get
          (
            'WbfsysMessage',
            $objidWbfsysMessage
          )
      )
      {
        $entityWbfsysMessage = $this->db->orm->newEntity( 'WbfsysMessage' );
      }

      $inputIdRefer = $this->view->newInput( 'inputMyMessageIdRefer', 'Window' );
      $this->items['my_message-id_refer'] = $inputIdRefer;
      $inputIdRefer->addAttributes(array
      (
        'readonly'  => 'readonly',
        'name'      => 'my_message[id_refer]',
        'id'        => 'wgt-input-my_message_id_refer'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title'     => $i18n->l( 'Insert value for Refer (Message)', 'wbfsys.message.label' ),
      ));

      if( $this->assignedForm )
        $inputIdRefer->assignedForm = $this->assignedForm;

      $inputIdRefer->setWidth( 'medium' );

      $inputIdRefer->setData( $this->entity->getData( 'id_refer' )  );
      $inputIdRefer->setReadonly( $this->fieldReadOnly( 'my_message', 'id_refer' ) );
      $inputIdRefer->setRequired( $this->fieldRequired( 'my_message', 'id_refer' ) );
      $inputIdRefer->setLabel( $i18n->l( 'Refer', 'wbfsys.message.label' ) );


      $listUrl = 'modal.php?c=Wbfsys.Message.selection'
        .'&amp;suffix='.$this->suffix.'&input=my_message_id_refer'.($this->suffix?'-'.$this->suffix:'');

      $inputIdRefer->setListUrl ( $listUrl );
      $inputIdRefer->setListIcon( 'webfrap/connect.png' );
      $inputIdRefer->setEntityUrl( 'maintab.php?c=Wbfsys.Message.edit' );
      $inputIdRefer->conEntity         = $entityWbfsysMessage;
      $inputIdRefer->refresh           = $this->refresh;
      $inputIdRefer->serializeElement  = $this->sendElement;



      $inputIdRefer->view = $this->view;
      $inputIdRefer->buildJavascript( 'wgt-input-my_message_id_refer'.($this->suffix?'-'.$this->suffix:'') );
      $this->view->addJsCode( $inputIdRefer );

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


    }

    // attribute my_message : priority
    if( isset( $this->fields['my_message']['priority'] ) )
    {

      //tpl: class ui:priority
      $inputPriority = $this->view->newInput( 'inputMyMessagePriority' , 'Priority' );
      $this->items['my_message-priority'] = $inputPriority;
      $inputPriority->addAttributes
      (
        array
        (
          'name'      => 'my_message[priority]',
          'id'        => 'wgt-input-my_message_priority'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Priority (Message)', 'wbfsys.message.label' ),
        )
      );
      $inputPriority->setWidth( 'medium' );

      $inputPriority->setReadonly( $this->fieldReadOnly( 'my_message', 'priority' ) );
      $inputPriority->setRequired( $this->fieldRequired( 'my_message', 'priority' ) );
      $inputPriority->setActive( $this->entity->getSecure('priority') );
      $inputPriority->setLabel( $i18n->l( 'Priority', 'wbfsys.message.label' ) );

      $inputPriority->refresh           = $this->refresh;
      $inputPriority->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


    }

    // attribute my_message : deliver_date
    if( isset( $this->fields['my_message']['deliver_date'] ) )
    {

      //tpl: class ui:date
      $inputDeliverDate = $this->view->newInput( 'inputMyMessageDeliverDate' , 'Date' );
      $this->items['my_message-deliver_date'] = $inputDeliverDate;
      $inputDeliverDate->addAttributes
      (
        array
        (
          'name'      => 'my_message[deliver_date]',
          'id'        => 'wgt-input-my_message_deliver_date'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Deliver Date (Message)', 'wbfsys.message.label' ),
          'maxlength' => $this->entity->maxSize( 'deliver_date' ),
        )
      );
      $inputDeliverDate->setWidth( 'small' );

      $inputDeliverDate->setReadonly( $this->fieldReadOnly( 'my_message', 'deliver_date' ) );
      $inputDeliverDate->setRequired( $this->fieldRequired( 'my_message', 'deliver_date' ) );
      $inputDeliverDate->setData( $this->entity->getDate( 'deliver_date' ) );
      $inputDeliverDate->setLabel( $i18n->l( 'Deliver Date', 'wbfsys.message.label' ) );

      $inputDeliverDate->refresh           = $this->refresh;
      $inputDeliverDate->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


    }

    // attribute my_message : deliver_time
    if( isset( $this->fields['my_message']['deliver_time'] ) )
    {

      //tpl: class ui:time
      $inputDeliverTime = $this->view->newInput( 'inputMyMessageDeliverTime' , 'Time' );
      $this->items['my_message-deliver_time'] = $inputDeliverTime;
      $inputDeliverTime->addAttributes
      (
        array
        (
          'name'      => 'my_message[deliver_time]',
          'id'        => 'wgt-input-my_message_deliver_time'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Deliver Time (Message)', 'wbfsys.message.label' )
        )
      );
      $inputDeliverTime->setWidth( 'small' );

      $inputDeliverTime->setReadonly( $this->fieldReadOnly( 'my_message', 'deliver_time' ) );
      $inputDeliverTime->setRequired( $this->fieldRequired( 'my_message', 'deliver_time' ) );
      $inputDeliverTime->setData( $this->entity->getTime( 'deliver_time' ) );
      $inputDeliverTime->setLabel( $i18n->l( 'Deliver Time', 'wbfsys.message.label' ) );

      $inputDeliverTime->refresh           = $this->refresh;
      $inputDeliverTime->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


    }

    // attribute my_message : title
    if( isset( $this->fields['my_message']['title'] ) )
    {

      //tpl: class ui:text
      $inputTitle = $this->view->newInput( 'inputMyMessageTitle' , 'Text' );
      $this->items['my_message-title'] = $inputTitle;
      $inputTitle->addAttributes
      (
        array
        (
          'name'      => 'my_message[title]',
          'id'        => 'wgt-input-my_message_title'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip xxlarge'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Title (Message)', 'wbfsys.message.label' ),
          'maxlength' => $this->entity->maxSize( 'title' ),
        )
      );
      $inputTitle->setWidth( 'xxlarge' );

      $inputTitle->setReadonly( $this->fieldReadOnly( 'my_message', 'title' ) );
      $inputTitle->setRequired( $this->fieldRequired( 'my_message', 'title' ) );
      $inputTitle->setData( $this->entity->getSecure('title') );
      $inputTitle->setLabel( $i18n->l( 'Title', 'wbfsys.message.label' ) );

      $inputTitle->refresh           = $this->refresh;
      $inputTitle->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


    }

    // attribute my_message : message
    if( isset( $this->fields['my_message']['message'] ) )
    {

      //p: textarea
      $inputMessage = $this->view->newInput( 'inputMyMessageMessage', 'Wysiwyg' );
      $inputMessage->addAttributes
      (
        array
        (
          'name'  => 'my_message[message]',
          'id'    => 'wgt-input-my_message_message'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip full large-height'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $i18n->l( 'Insert value for Message (Message)', 'wbfsys.message.label' ),
        )
      );
      $inputMessage->setWidth( 'full' );

      $inputMessage->full = true;
      $inputMessage->setData( $this->entity->getData( 'message' ) );
      $inputMessage->setReadonly( $this->fieldReadOnly( 'my_message', 'message' ) );
      $inputMessage->setRequired( $this->fieldRequired( 'my_message', 'message' ) );
      $inputMessage->setLabel( $i18n->l( 'Message', 'wbfsys.message.label' ) );

      $inputMessage->refresh           = $this->refresh;
      $inputMessage->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

    }

    // attribute my_message : rowid
    if( isset( $this->fields['my_message']['rowid'] ) )
    {

      //tpl: class ui: guess
      $inputRowid = $this->view->newInput( 'inputMyMessageRowid' , 'int' );
      $this->items['my_message-rowid'] = $inputRowid;
      $inputRowid->addAttributes
      (
        array
        (
          'name'      => 'my_message[rowid]',
          'id'        => 'wgt-input-my_message_rowid'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip valid_required medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Rowid (Message)', 'wbfsys.message.label' ),
        )
      );
      $inputRowid->setWidth( 'medium' );

      $inputRowid->setReadonly( $this->fieldReadOnly( 'my_message', 'rowid' ) );
      $inputRowid->setRequired( $this->fieldRequired( 'my_message', 'rowid' ) );
      $inputRowid->setData( $this->entity->getId() );
      $inputRowid->setLabel( $i18n->l( 'Rowid', 'wbfsys.message.label' ) );

      $inputRowid->refresh           = $this->refresh;
      $inputRowid->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );



    }

    // attribute my_message : m_time_created
    if( isset( $this->fields['my_message']['m_time_created'] ) )
    {

      //tpl: class ui:date
      $inputMTimeCreated = $this->view->newInput( 'inputMyMessageMTimeCreated' , 'Date' );
      $this->items['my_message-m_time_created'] = $inputMTimeCreated;
      $inputMTimeCreated->addAttributes
      (
        array
        (
          'name'      => 'my_message[m_time_created]',
          'id'        => 'wgt-input-my_message_m_time_created'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Time Created (Message)', 'wbfsys.message.label' ),
          'maxlength' => $this->entity->maxSize( 'm_time_created' ),
        )
      );
      $inputMTimeCreated->setWidth( 'small' );

      $inputMTimeCreated->setReadonly( $this->fieldReadOnly( 'my_message', 'm_time_created' ) );
      $inputMTimeCreated->setRequired( $this->fieldRequired( 'my_message', 'm_time_created' ) );
      $inputMTimeCreated->setData( $this->entity->getDate( 'm_time_created' ) );
      $inputMTimeCreated->setLabel( $i18n->l( 'Time Created', 'wbfsys.message.label' ) );

      $inputMTimeCreated->refresh           = $this->refresh;
      $inputMTimeCreated->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );


    }

    // attribute my_message : m_role_create
    if
    (
      isset( $this->fields['my_message']['m_role_create'] )
        && Webfrap::classLoadable( 'WbfsysRoleUser_Entity' )
     )
    {


      //p: Window
      $objidWbfsysRoleUser = $this->entity->getData( 'm_role_create' ) ;

      // entity ids can never be 0 so thats ok
      if
      (
        !$objidWbfsysRoleUser
          || !$entityWbfsysRoleUser = $this->db->orm->get
          (
            'WbfsysRoleUser',
            $objidWbfsysRoleUser
          )
      )
      {
        $entityWbfsysRoleUser = $this->db->orm->newEntity( 'WbfsysRoleUser' );
      }

      $inputMRoleCreate = $this->view->newInput( 'inputMyMessageMRoleCreate', 'Window' );
      $this->items['my_message-m_role_create'] = $inputMRoleCreate;
      $inputMRoleCreate->addAttributes(array
      (
        'readonly'  => 'readonly',
        'name'      => 'my_message[m_role_create]',
        'id'        => 'wgt-input-my_message_m_role_create'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title'     => $i18n->l( 'Insert value for Role Create (Message)', 'wbfsys.message.label' ),
      ));

      if( $this->assignedForm )
        $inputMRoleCreate->assignedForm = $this->assignedForm;

      $inputMRoleCreate->setWidth( 'medium' );

      $inputMRoleCreate->setData( $this->entity->getData( 'm_role_create' )  );
      $inputMRoleCreate->setReadonly( $this->fieldReadOnly( 'my_message', 'm_role_create' ) );
      $inputMRoleCreate->setRequired( $this->fieldRequired( 'my_message', 'm_role_create' ) );
      $inputMRoleCreate->setLabel( $i18n->l( 'Role Create', 'wbfsys.message.label' ) );


      $listUrl = 'modal.php?c=Wbfsys.RoleUser.selection'
        .'&amp;suffix='.$this->suffix.'&input=my_message_m_role_create'.($this->suffix?'-'.$this->suffix:'');

      $inputMRoleCreate->setListUrl ( $listUrl );
      $inputMRoleCreate->setListIcon( 'webfrap/connect.png' );
      $inputMRoleCreate->setEntityUrl( 'maintab.php?c=Wbfsys.RoleUser.edit' );
      $inputMRoleCreate->conEntity         = $entityWbfsysRoleUser;
      $inputMRoleCreate->refresh           = $this->refresh;
      $inputMRoleCreate->serializeElement  = $this->sendElement;



      $inputMRoleCreate->view = $this->view;
      $inputMRoleCreate->buildJavascript( 'wgt-input-my_message_m_role_create'.($this->suffix?'-'.$this->suffix:'') );
      $this->view->addJsCode( $inputMRoleCreate );

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );


    }

    // attribute my_message : m_time_changed
    if( isset( $this->fields['my_message']['m_time_changed'] ) )
    {

      //tpl: class ui:date
      $inputMTimeChanged = $this->view->newInput( 'inputMyMessageMTimeChanged' , 'Date' );
      $this->items['my_message-m_time_changed'] = $inputMTimeChanged;
      $inputMTimeChanged->addAttributes
      (
        array
        (
          'name'      => 'my_message[m_time_changed]',
          'id'        => 'wgt-input-my_message_m_time_changed'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Time Changed (Message)', 'wbfsys.message.label' ),
          'maxlength' => $this->entity->maxSize( 'm_time_changed' ),
        )
      );
      $inputMTimeChanged->setWidth( 'small' );

      $inputMTimeChanged->setReadonly( $this->fieldReadOnly( 'my_message', 'm_time_changed' ) );
      $inputMTimeChanged->setRequired( $this->fieldRequired( 'my_message', 'm_time_changed' ) );
      $inputMTimeChanged->setData( $this->entity->getDate( 'm_time_changed' ) );
      $inputMTimeChanged->setLabel( $i18n->l( 'Time Changed', 'wbfsys.message.label' ) );

      $inputMTimeChanged->refresh           = $this->refresh;
      $inputMTimeChanged->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );


    }

    // attribute my_message : m_role_change
    if
    (
      isset( $this->fields['my_message']['m_role_change'] )
        && Webfrap::classLoadable( 'WbfsysRoleUser_Entity' )
     )
    {


      //p: Window
      $objidWbfsysRoleUser = $this->entity->getData( 'm_role_change' ) ;

      // entity ids can never be 0 so thats ok
      if
      (
        !$objidWbfsysRoleUser
          || !$entityWbfsysRoleUser = $this->db->orm->get
          (
            'WbfsysRoleUser',
            $objidWbfsysRoleUser
          )
      )
      {
        $entityWbfsysRoleUser = $this->db->orm->newEntity( 'WbfsysRoleUser' );
      }

      $inputMRoleChange = $this->view->newInput( 'inputMyMessageMRoleChange', 'Window' );
      $this->items['my_message-m_role_change'] = $inputMRoleChange;
      $inputMRoleChange->addAttributes(array
      (
        'readonly'  => 'readonly',
        'name'      => 'my_message[m_role_change]',
        'id'        => 'wgt-input-my_message_m_role_change'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title'     => $i18n->l( 'Insert value for Role Change (Message)', 'wbfsys.message.label' ),
      ));

      if( $this->assignedForm )
        $inputMRoleChange->assignedForm = $this->assignedForm;

      $inputMRoleChange->setWidth( 'medium' );

      $inputMRoleChange->setData( $this->entity->getData( 'm_role_change' )  );
      $inputMRoleChange->setReadonly( $this->fieldReadOnly( 'my_message', 'm_role_change' ) );
      $inputMRoleChange->setRequired( $this->fieldRequired( 'my_message', 'm_role_change' ) );
      $inputMRoleChange->setLabel( $i18n->l( 'Role Change', 'wbfsys.message.label' ) );


      $listUrl = 'modal.php?c=Wbfsys.RoleUser.selection'
        .'&amp;suffix='.$this->suffix.'&input=my_message_m_role_change'.($this->suffix?'-'.$this->suffix:'');

      $inputMRoleChange->setListUrl ( $listUrl );
      $inputMRoleChange->setListIcon( 'webfrap/connect.png' );
      $inputMRoleChange->setEntityUrl( 'maintab.php?c=Wbfsys.RoleUser.edit' );
      $inputMRoleChange->conEntity         = $entityWbfsysRoleUser;
      $inputMRoleChange->refresh           = $this->refresh;
      $inputMRoleChange->serializeElement  = $this->sendElement;



      $inputMRoleChange->view = $this->view;
      $inputMRoleChange->buildJavascript( 'wgt-input-my_message_m_role_change'.($this->suffix?'-'.$this->suffix:'') );
      $this->view->addJsCode( $inputMRoleChange );

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );


    }

    // attribute my_message : m_version
    if( isset( $this->fields['my_message']['m_version'] ) )
    {

      //tpl: class ui: guess
      $inputMVersion = $this->view->newInput( 'inputMyMessageMVersion' , 'int' );
      $this->items['my_message-m_version'] = $inputMVersion;
      $inputMVersion->addAttributes
      (
        array
        (
          'name'      => 'my_message[m_version]',
          'id'        => 'wgt-input-my_message_m_version'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip valid_int medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Version (Message)', 'wbfsys.message.label' ),
        )
      );
      $inputMVersion->setWidth( 'medium' );

      $inputMVersion->setReadonly( $this->fieldReadOnly( 'my_message', 'm_version' ) );
      $inputMVersion->setRequired( $this->fieldRequired( 'my_message', 'm_version' ) );
      $inputMVersion->setData( $this->entity->getSecure( 'm_version' ) );
      $inputMVersion->setLabel( $i18n->l( 'Version', 'wbfsys.message.label' ) );

      $inputMVersion->refresh           = $this->refresh;
      $inputMVersion->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );



    }

    // attribute my_message : m_uuid
    if( isset( $this->fields['my_message']['m_uuid'] ) )
    {

      //tpl: class ui: guess
      $inputMUuid = $this->view->newInput( 'inputMyMessageMUuid' , 'Text' );
      $this->items['my_message-m_uuid'] = $inputMUuid;
      $inputMUuid->addAttributes
      (
        array
        (
          'name'      => 'my_message[m_uuid]',
          'id'        => 'wgt-input-my_message_m_uuid'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Uuid (Message)', 'wbfsys.message.label' ),
        )
      );
      $inputMUuid->setWidth( 'medium' );

      $inputMUuid->setReadonly( $this->fieldReadOnly( 'my_message', 'm_uuid' ) );
      $inputMUuid->setRequired( $this->fieldRequired( 'my_message', 'm_uuid' ) );
      $inputMUuid->setData( $this->entity->getSecure( 'm_uuid' ) );
      $inputMUuid->setLabel( $i18n->l( 'Uuid', 'wbfsys.message.label' ) );

      $inputMUuid->refresh           = $this->refresh;
      $inputMUuid->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );



    }


  }//end public function renderForm */

/*//////////////////////////////////////////////////////////////////////////////
// Validate Methodes
//////////////////////////////////////////////////////////////////////////////*/
    
  /**
   * Wenn die Formularmaske per POST Request aufgerufen wird können default
   * Parameter mitübergeben werden
   *
   * @param LibRequestHttp $request 
   * @throws Wgt_Exception
   */
  public function fetchDefaultData( $request )
  {
    
    // prüfen ob alle nötigen objekte vorhanden sind
    if (!$this->entity )
    {
      throw new Wgt_Exception
      ( 
        "To call fetchDefaultData in a CrudFrom an entity object is required!" 
       );
    }
    
    // laden aller nötigen system resourcen
    $orm      = $this->getOrm();
    $response = $this->getResponse();
    
    // extrahieren der Daten für die Hauptentity
    $filter = $request->checkFormInput
    (
      $orm->getValidationData( 'WbfsysMessage', array_keys( $this->fields['my_message']), true ),
      $orm->getErrorMessages( 'WbfsysMessage' ),
      'my_message'
    );
    
    $tmp  = $filter->getData();
    $data = array();
    
    // es werden nur daten gesetzt die tatsächlich übergeben wurden, sonst
    // würden default werte in den entities überschrieben werden
    foreach( $tmp as $key => $value   )
    {
      if (!is_null( $value ) )
        $data[$key] = $value;
    }

    $this->entity->addData( $data );


  }//end public function fetchDefaultData */


}//end class WbfsysMessage_Crud_Create_Form */


