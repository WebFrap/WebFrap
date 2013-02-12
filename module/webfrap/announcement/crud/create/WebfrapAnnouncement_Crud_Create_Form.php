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
class WebfrapAnnouncement_Crud_Create_Form
  extends WgtCrudForm
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
    
  /**
   * namespace for the actual form
   * @setter WgtCrudForm::setNamespace()
   * @getter WgtCrudForm::getNamespace()
   * @var string 
   */
  public $namespace  = 'WebfrapAnnouncement';

  /**
   * prename for the ui elements to avoid redundant names in the forms
   * normally the entity key (the tablename), is used
   *
   * @setter WgtCrudForm::setPrefix()
   * @getter WgtCrudForm::getPrefix()
   * @var string 
   */
  public $prefix      = 'WebfrapAnnouncement';

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
      'webfrap_announcement' => array
      (
        'title' => array
        ( 
          'required'  => true, 
          'readonly'  => false, 
          'lenght'     => '400',
        ),
        'id_type' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'importance' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'message' => array
        ( 
          'required'  => true, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'date_start' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'date_end' => array
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
   * @var WbfsysAnnouncement_Entity 
   */
  public $entity      = null;
  
  /**
  * Erfragen der Haupt Entity 
  * @param int $objid
  * @return WbfsysAnnouncement_Entity
  */
  public function getEntity( )
  {

    return $this->entity;

  }//end public function getEntity */
    
  /**
  * Setzen der Haupt Entity 
  * @param WbfsysAnnouncement_Entity $entity
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
      'webfrap_announcement' => array
      (
        'title',
        'date_start',
        'id_type',
        'importance',
        'message',
        'date_end',
        'm_uuid',
      ),

    );

  }//end public function getSaveFields */

////////////////////////////////////////////////////////////////////////////////
// Form Methodes
////////////////////////////////////////////////////////////////////////////////
    
 /**
  * create an IO form for the WbfsysAnnouncement entity
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
    $this->view->addVar( 'entityWebfrapAnnouncement', $this->entity );


    $this->db     = $this->getDb();
    
    if( !$this->suffix )
    {
      $this->suffix = $this->rowid?:'';
    }

    if( $this->target )
      $sendTo = 'wgt-input-'.$this->target.'-tostring';
    else
      $sendTo = 'wgt-input-webfrap_announcement'.($this->suffix?'-'.$this->suffix:'').'-tostring';

    $inputToString = $this->view->newInput( 'input'.$this->prefix.'ToString' , 'Text' );
    $inputToString->addAttributes
    (
      array
      (
        'name'  => 'webfrap_announcement[id_wbfsys_announcement-tostring]',
        'id'    => $sendTo,
        'value' => $this->entity->text(),
      )
    );

    $inputToString->setReadOnly( $this->readOnly );
    $inputToString->refresh = $this->refresh;


    // attribute wbfsys_announcement : title
    if( isset( $this->fields['webfrap_announcement']['title'] ) )
    {

      //tpl: class ui:text
      $inputTitle = $this->view->newInput( 'inputWebfrapAnnouncementTitle' , 'Text' );
      $this->items['wbfsys_announcement-title'] = $inputTitle;
      $inputTitle->addAttributes
      (
        array
        (
          'name'      => 'webfrap_announcement[title]',
          'id'        => 'wgt-input-webfrap_announcement_title'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip xxlarge'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Title (Announcement)', 'wbfsys.announcement.label' ),
          'maxlength' => $this->entity->maxSize( 'title' ),
        )
      );
      $inputTitle->setWidth( 'xxlarge' );

      $inputTitle->setReadonly( $this->fieldReadOnly( 'webfrap_announcement', 'title' ) );
      $inputTitle->setRequired( $this->fieldRequired( 'webfrap_announcement', 'title' ) );
      $inputTitle->setData( $this->entity->getSecure('title') );
      $inputTitle->setLabel( $i18n->l( 'Title', 'wbfsys.announcement.label' ) );

      $inputTitle->refresh           = $this->refresh;
      $inputTitle->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


    }

    // attribute wbfsys_announcement : date_start
    if( isset( $this->fields['webfrap_announcement']['date_start'] ) )
    {

      //tpl: class ui:date
      $inputDateStart = $this->view->newInput( 'inputWebfrapAnnouncementDateStart' , 'Date' );
      $this->items['wbfsys_announcement-date_start'] = $inputDateStart;
      $inputDateStart->addAttributes
      (
        array
        (
          'name'      => 'webfrap_announcement[date_start]',
          'id'        => 'wgt-input-webfrap_announcement_date_start'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Start Date (Announcement)', 'wbfsys.announcement.label' ),
          'maxlength' => $this->entity->maxSize( 'date_start' ),
        )
      );
      $inputDateStart->setWidth( 'small' );

      $inputDateStart->setReadonly( $this->fieldReadOnly( 'webfrap_announcement', 'date_start' ) );
      $inputDateStart->setRequired( $this->fieldRequired( 'webfrap_announcement', 'date_start' ) );
      $inputDateStart->setData( $this->entity->getDate( 'date_start' ) );
      $inputDateStart->setLabel( $i18n->l( 'Start Date', 'wbfsys.announcement.label' ) );

      $inputDateStart->refresh           = $this->refresh;
      $inputDateStart->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


    }
    
      // attribute wbfsys_announcement : id_type, only show if the selectbox is loadable
    if
    (
      isset( $this->fields['webfrap_announcement']['id_type'] )
        && Webfrap::classLoadable( 'WbfsysAnnouncementType_Selectbox' )
    )
    {


      //p: Selectbox
      $inputIdType = $this->view->newItem( 'inputWebfrapAnnouncementIdType', 'WbfsysAnnouncementType_Selectbox' );
      $this->items['webfrap_announcement-id_type'] = $inputIdType;
      $inputIdType->addAttributes
      (
        array
        (
          'name'      => 'webfrap_announcement[id_type]',
          'id'        => 'wgt-input-webfrap_announcement_id_type'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Type (Announcement)', 'wbfsys.announcement.label' ),
        )
      );
      $inputIdType->setWidth( 'medium' );


      if( $this->assignedForm )
        $inputIdType->assignedForm = $this->assignedForm;

      $inputIdType->setActive( $this->entity->getData( 'id_type' ) );
      $inputIdType->setReadonly( $this->fieldReadOnly( 'webfrap_announcement', 'id_type' ) );
      $inputIdType->setRequired( $this->fieldRequired( 'webfrap_announcement', 'id_type' ) );


      $inputIdType->setLabel( $i18n->l( 'Type', 'wbfsys.announcement.label' ) );


      $acl = $this->getAcl();

      if( $acl->access( 'mod-wbfsys>mgmt-wbfsys_announcement_type:insert' ) )
      {
        $inputIdType->refresh           = $this->refresh;
        $inputIdType->serializeElement  = $this->sendElement;
        $inputIdType->editUrl = 'index.php?c=Wbfsys.AnnouncementType.listing&amp;target='.$this->namespace.'&amp;field=id_type&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-webfrap_announcement_id_type'.$this->suffix;
      }
      // set an empty first entry
      $inputIdType->setFirstFree( 'No Type selected' );


      $queryIdType = $this->db->newQuery( 'WbfsysAnnouncementType_Selectbox' );

      $queryIdType->fetchSelectbox();
      $inputIdType->setData( $queryIdType->getAll() );


      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


    }

    // attribute wbfsys_announcement : importance
    if( isset( $this->fields['webfrap_announcement']['importance'] ) )
    {

      //tpl: class ui:importance
      $inputImportance = $this->view->newInput( 'inputWebfrapAnnouncementImportance' , 'Importance' );
      $this->items['wbfsys_announcement-importance'] = $inputImportance;
      $inputImportance->addAttributes
      (
        array
        (
          'name'      => 'webfrap_announcement[importance]',
          'id'        => 'wgt-input-webfrap_announcement_importance'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Importance (Announcement)', 'wbfsys.announcement.label' ),
        )
      );
      $inputImportance->setWidth( 'medium' );

      $inputImportance->setReadonly( $this->fieldReadOnly( 'webfrap_announcement', 'importance' ) );
      $inputImportance->setRequired( $this->fieldRequired( 'webfrap_announcement', 'importance' ) );
      $inputImportance->setActive( $this->entity->getSecure( 'importance' ) );
      $inputImportance->setLabel( $i18n->l( 'Importance', 'wbfsys.announcement.label' ) );

      $inputImportance->refresh           = $this->refresh;
      $inputImportance->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


    }

    // attribute wbfsys_announcement : message
    if( isset( $this->fields['webfrap_announcement']['message'] ) )
    {

      //p: textarea
      $inputMessage = $this->view->newInput( 'inputWebfrapAnnouncementMessage', 'Wysiwyg' );
      $inputMessage->addAttributes
      (
        array
        (
          'name'  => 'webfrap_announcement[message]',
          'id'    => 'wgt-input-webfrap_announcement_message'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip full'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $i18n->l( 'Insert value for Message (Announcement)', 'wbfsys.announcement.label' ),
        )
      );
      $inputMessage->setWidth( 'full' );

      $inputMessage->full = true;
      $inputMessage->setData( $this->entity->getData( 'message' ) );
      $inputMessage->setReadonly( $this->fieldReadOnly( 'webfrap_announcement', 'message' ) );
      $inputMessage->setRequired( $this->fieldRequired( 'webfrap_announcement', 'message' ) );
      $inputMessage->setLabel( $i18n->l( 'Message', 'wbfsys.announcement.label' ) );
      $inputMessage->setMode( 'rich_text' );

      $inputMessage->refresh           = $this->refresh;
      $inputMessage->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

    }

    // attribute wbfsys_announcement : date_end
    if( isset( $this->fields['webfrap_announcement']['date_end'] ) )
    {

      //tpl: class ui:date
      $inputDateEnd = $this->view->newInput( 'inputWebfrapAnnouncementDateEnd' , 'Date' );
      $this->items['wbfsys_announcement-date_end'] = $inputDateEnd;
      $inputDateEnd->addAttributes
      (
        array
        (
          'name'      => 'webfrap_announcement[date_end]',
          'id'        => 'wgt-input-webfrap_announcement_date_end'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for End Date (Announcement)', 'wbfsys.announcement.label' ),
          'maxlength' => $this->entity->maxSize( 'date_end' ),
        )
      );
      $inputDateEnd->setWidth( 'small' );

      $inputDateEnd->setReadonly( $this->fieldReadOnly( 'webfrap_announcement', 'date_end' ) );
      $inputDateEnd->setRequired( $this->fieldRequired( 'webfrap_announcement', 'date_end' ) );
      $inputDateEnd->setData( $this->entity->getDate( 'date_end' ) );
      $inputDateEnd->setLabel( $i18n->l( 'End Date', 'wbfsys.announcement.label' ) );

      $inputDateEnd->refresh           = $this->refresh;
      $inputDateEnd->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


    }

    // attribute wbfsys_announcement : m_uuid
    if( isset( $this->fields['webfrap_announcement']['m_uuid'] ) )
    {

      //tpl: class ui: guess
      $inputMUuid = $this->view->newInput( 'inputWebfrapAnnouncementMUuid' , 'Text' );
      $this->items['wbfsys_announcement-m_uuid'] = $inputMUuid;
      $inputMUuid->addAttributes
      (
        array
        (
          'name'      => 'webfrap_announcement[m_uuid]',
          'id'        => 'wgt-input-webfrap_announcement_m_uuid'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Uuid (Announcement)', 'wbfsys.announcement.label' ),
        )
      );
      $inputMUuid->setWidth( 'medium' );

      $inputMUuid->setReadonly( $this->fieldReadOnly( 'webfrap_announcement', 'm_uuid' ) );
      $inputMUuid->setRequired( $this->fieldRequired( 'webfrap_announcement', 'm_uuid' ) );
      $inputMUuid->setData( $this->entity->getSecure( 'm_uuid' ) );
      $inputMUuid->setLabel( $i18n->l( 'Uuid', 'wbfsys.announcement.label' ) );

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

////////////////////////////////////////////////////////////////////////////////
// Validate Methodes
////////////////////////////////////////////////////////////////////////////////
    
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
    if( !$this->entity )
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
      $orm->getValidationData( 'WbfsysAnnouncement', array_keys( $this->fields['webfrap_announcement']), true ),
      $orm->getErrorMessages( 'WbfsysAnnouncement' ),
      'webfrap_announcement'
    );
    
    $tmp  = $filter->getData();
    $data = array();
    
    // es werden nur daten gesetzt die tatsächlich übergeben wurden, sonst
    // würden default werte in den entities überschrieben werden
    foreach( $tmp as $key => $value   )
    {
      if( !is_null( $value ) )
        $data[$key] = $value;
    }

    $this->entity->addData( $data );


  }//end public function fetchDefaultData */


}//end class WbfsysAnnouncement_Crud_Create_Form */


