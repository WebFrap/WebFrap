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
class MyProfile_Crud_Form extends WgtCrudForm
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
  public $namespace  = 'MyProfile';

  /**
   * prename for the ui elements to avoid redundant names in the forms
   * normally the entity key (the tablename), is used
   *
   * @setter WgtCrudForm::setPrefix()
   * @getter WgtCrudForm::getPrefix()
   * @var string 
   */
  public $prefix      = 'MyProfile';

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
      'wbfsys_role_user' => array
      (
        'name' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '250',
        ),
        'id_person' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'rowid' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'id_employee' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'm_time_created' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_role_create' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_time_changed' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_role_change' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_version' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_uuid' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'password' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '64',
        ),
        'level' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'profile' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '120',
        ),
        'inactive' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'non_cert_login' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
        'description' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '',
        ),
      ),
      'embed_person' => array
      (
        'firstname' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '250',
        ),
        'lastname' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '250',
        ),
        'academic_title' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '50',
        ),
        'noblesse_title' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '50',
        ),
        'rowid' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_time_created' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_role_create' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_time_changed' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_role_change' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_version' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_uuid' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'photo' => array
        ( 
          'required'  => false, 
          'readonly'  => false, 
          'lenght'     => '250',
        ),
      ),
      'embed_enterprise_employee' => array
      (
        'rowid' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_time_created' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_role_create' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_time_changed' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_role_change' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_version' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
        'm_uuid' => array
        ( 
          'required'  => false, 
          'readonly'  => true, 
          'lenght'     => '',
        ),
      ),

  );

  /**
   * Die Haupt Entity für das Formular
   *
   * @var WbfsysRoleUser_Entity 
   */
  public $entity      = null;
  
  /**
  * The EmbedPerson Reference Entity
  *
  * @var EmbedPerson_Entity
  */
  public $entityEmbedPerson;


  /**
  * The EmbedEnterpriseEmployee Reference Entity
  *
  * @var EmbedEnterpriseEmployee_Entity
  */
  public $entityEmbedEnterpriseEmployee;


  /**
  * Erfragen der Haupt Entity 
  * @param int $objid
  * @return WbfsysRoleUser_Entity
  */
  public function getEntity( )
  {

    return $this->entity;

  }//end public function getEntity */
    
  /**
  * Setzen der Haupt Entity 
  * @param WbfsysRoleUser_Entity $entity
  */
  public function setEntity( $entity )
  {

    $this->entity = $entity;
    $this->rowid  = $entity->getId();
    
  }//end public function setEntity */


  /**
  * returns the activ entity with data, or creates a empty one
  * and returns it instead
  *
  * @return EmbedPerson_Entity
  */
  public function getEntityEmbedPerson(  )
  {

    return $this->entityEmbedPerson;

  }//end public function getEntityEmbedPerson */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param EmbedPerson_Entity $entity
  */
  public function setEntityEmbedPerson( $entity )
  {

    $this->entityEmbedPerson = $entity ;

  }//end public function setEntityEmbedPerson */

  /**
  * returns the activ entity with data, or creates a empty one
  * and returns it instead
  *
  * @return EmbedEnterpriseEmployee_Entity
  */
  public function getEntityEmbedEnterpriseEmployee(  )
  {

    return $this->entityEmbedEnterpriseEmployee;

  }//end public function getEntityEmbedEnterpriseEmployee */

  /**
  * returns the activ main entity with data, or creates a empty one
  * and returns it instead
  * @param EmbedEnterpriseEmployee_Entity $entity
  */
  public function setEntityEmbedEnterpriseEmployee( $entity )
  {

    $this->entityEmbedEnterpriseEmployee = $entity ;

  }//end public function setEntityEmbedEnterpriseEmployee */

  /**
   * request all fields that have to be fetched from the request
   * @return array
   */
  public function getSaveFields()
  {

    return array
    (
      'wbfsys_role_user' => array
      (
        'name',
        'id_person',
        'id_employee',
        'm_version',
        'password',
        'level',
        'profile',
        'inactive',
        'non_cert_login',
        'description',
      ),
      'embed_person' => array
      (
        'firstname',
        'lastname',
        'academic_title',
        'noblesse_title',
        'm_version',
        'photo',
      ),
      'embed_enterprise_employee' => array
      (
        'm_version',
      ),

    );

  }//end public function getSaveFields */

/*//////////////////////////////////////////////////////////////////////////////
// Form Methodes
//////////////////////////////////////////////////////////////////////////////*/
    
 /**
  * create an IO form for the WbfsysRoleUser entity
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
    
    if( $params->access )
      $this->access = $params->access;

    // add the entity to the view
    $this->view->addVar( 'entity', $this->entity );
    $this->view->addVar( 'entityMyProfile', $this->entity );
    $this->view->addVar( 'entityEmbedPerson',  $this->entityEmbedPerson ) ;
    $this->view->addVar( 'entityEmbedEnterpriseEmployee',  $this->entityEmbedEnterpriseEmployee ) ;


    $this->db     = $this->getDb();
    
    if (!$this->suffix )
    {
      $this->suffix = $this->rowid?:'';
    }

    if( $this->target )
      $sendTo = 'wgt-input-'.$this->target.'-tostring';
    else
      $sendTo = 'wgt-input-wbfsys_role_user'.($this->suffix?'-'.$this->suffix:'').'-tostring';
      
    $this->customize();

    $inputToString = $this->view->newInput( 'input'.$this->prefix.'ToString' , 'Text' );
    $inputToString->addAttributes
    (
      array
      (
        'name'  => 'wbfsys_role_user[id_my_profile-tostring]',
        'id'    => $sendTo,
        'value' => $this->entity->text(),
      )
    );

    $inputToString->setReadOnly( $this->readOnly );
    $inputToString->refresh = $this->refresh;

    $this->input_EmbedPerson_Firstname( $params );
    $this->input_EmbedPerson_Lastname( $params );
    $this->input_EmbedPerson_AcademicTitle( $params );
    $this->input_EmbedPerson_NoblesseTitle( $params );
    $this->input_EmbedPerson_Photo( $params );
    $this->input_EmbedPerson_Rowid( $params );
    $this->input_EmbedPerson_MTimeCreated( $params );
    $this->input_EmbedPerson_MRoleCreate( $params );
    $this->input_EmbedPerson_MTimeChanged( $params );
    $this->input_EmbedPerson_MRoleChange( $params );
    $this->input_EmbedPerson_MVersion( $params );
    $this->input_EmbedPerson_MUuid( $params );    
    
    $this->input_EmbedEnterpriseEmployee_Rowid( $params );
    $this->input_EmbedEnterpriseEmployee_MTimeCreated( $params );
    $this->input_EmbedEnterpriseEmployee_MRoleCreate( $params );
    $this->input_EmbedEnterpriseEmployee_MTimeChanged( $params );
    $this->input_EmbedEnterpriseEmployee_MRoleChange( $params );
    $this->input_EmbedEnterpriseEmployee_MVersion( $params );
    $this->input_EmbedEnterpriseEmployee_MUuid( $params );
    
    $this->input_MyProfile_Name( $params );
    $this->input_MyProfile_IdPerson( $params );
    $this->input_MyProfile_Rowid( $params );
    $this->input_MyProfile_Password( $params );
    $this->input_MyProfile_Level( $params );
    $this->input_MyProfile_Profile( $params );
    $this->input_MyProfile_Inactive( $params );
    $this->input_MyProfile_NonCertLogin( $params );
    $this->input_MyProfile_Description( $params );
    $this->input_MyProfile_IdEmployee( $params );
    $this->input_MyProfile_MTimeCreated( $params );
    $this->input_MyProfile_MRoleCreate( $params );
    $this->input_MyProfile_MTimeChanged( $params );
    $this->input_MyProfile_MRoleChange( $params );
    $this->input_MyProfile_MVersion( $params );
    $this->input_MyProfile_MUuid( $params );


  }//end public function renderForm */

 /**
  * create the ui element for field name
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_Name( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:text
      $inputName = $this->view->newInput( 'inputWbfsysRoleUserName' , 'Text' );
      $this->items['my_profile-name'] = $inputName;
      $inputName->addAttributes
      (
        array
        (
          'name'      => 'wbfsys_role_user[name]',
          'id'        => 'wgt-input-my_profile_name'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Name (Role User)', 'wbfsys.role_user.label' ),
          'maxlength' => $this->entity->maxSize( 'name' ),
        )
      );
      $inputName->setWidth( 'medium' );

      $inputName->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'name' ) );
      $inputName->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'name' ) );
      $inputName->setData( $this->entity->getSecure('name') );
      $inputName->setLabel( $i18n->l( 'Name', 'wbfsys.role_user.label' ) );

      $inputName->refresh           = $this->refresh;
      $inputName->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


  }//end public function input_MyProfile_Name */

 /**
  * create the ui element for field id_person
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_IdPerson( $params )
  {
    $i18n     = $this->view->i18n;

    if (!Webfrap::classLoadable( 'CorePerson_Entity' ) )
    {
      if(DEBUG)
        Debug::console( 'Entity CorePerson not exists' );

      Log::warn( 'Looks like the Entity: CorePerson is missing' );

      return;
    }


      //p: Window
      $objidCorePerson = $this->entity->getData( 'id_person' ) ;

      // entity ids can never be 0 so thats ok
      if
      (
        !$objidCorePerson
          || !$entityCorePerson = $this->db->orm->get
          (
            'CorePerson',
            $objidCorePerson
          )
      )
      {
        $entityCorePerson = $this->db->orm->newEntity( 'CorePerson' );
      }

      $inputIdPerson = $this->view->newInput( 'inputMyProfileIdPerson', 'Window' );
      $this->items['my_profile-id_person'] = $inputIdPerson;
      $inputIdPerson->addAttributes(array
      (
        'readonly'  => 'readonly',
        'name'      => 'wbfsys_role_user[id_person]',
        'id'        => 'wgt-input-my_profile_id_person'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title'     => $i18n->l( 'Insert value for Person (Role User)', 'wbfsys.role_user.label' ),
      ));

      if( $this->assignedForm )
        $inputIdPerson->assignedForm = $this->assignedForm;

      $inputIdPerson->setWidth( 'medium' );

      $inputIdPerson->setData( $this->entity->getData( 'id_person' )  );
      $inputIdPerson->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'id_person' ) );
      $inputIdPerson->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'id_person' ) );
      $inputIdPerson->setLabel( $i18n->l( 'Person', 'wbfsys.role_user.label' ) );


      $listUrl = 'modal.php?c=Core.Person.selection&full_load=true'
        .'&amp;key_name=embed_person&amp;suffix='.$this->suffix.'&input=wbfsys_role_user_id_person'.($this->suffix?'-'.$this->suffix:'');

      $inputIdPerson->setListUrl ( $listUrl );
      $inputIdPerson->setListIcon( 'webfrap/connect.png' );
      $inputIdPerson->setEntityUrl( 'maintab.php?c=Core.Person.edit' );
      $inputIdPerson->conEntity         = $entityCorePerson;
      $inputIdPerson->refresh           = $this->refresh;
      $inputIdPerson->serializeElement  = $this->sendElement;



      $inputIdPerson->view = $this->view;
      $inputIdPerson->buildJavascript( 'wgt-input-my_profile_id_person'.($this->suffix?'-'.$this->suffix:'') );
      $this->view->addJsCode( $inputIdPerson );

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_MyProfile_IdPerson */

 /**
  * create the ui element for field rowid
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_Rowid( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui: guess
      $inputRowid = $this->view->newInput( 'inputMyProfileRowid' , 'int' );
      $this->items['my_profile-rowid'] = $inputRowid;
      $inputRowid->addAttributes
      (
        array
        (
          'name'      => 'wbfsys_role_user[rowid]',
          'id'        => 'wgt-input-my_profile_rowid'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip valid_required medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Rowid (Role User)', 'wbfsys.role_user.label' ),
        )
      );
      $inputRowid->setWidth( 'medium' );

      $inputRowid->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'rowid' ) );
      $inputRowid->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'rowid' ) );
      $inputRowid->setData( $this->entity->getId() );
      $inputRowid->setLabel( $i18n->l( 'Rowid', 'wbfsys.role_user.label' ) );

      $inputRowid->refresh           = $this->refresh;
      $inputRowid->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );



  }//end public function input_MyProfile_Rowid */

 /**
  * create the ui element for field firstname
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedPerson_Firstname( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:text
      $inputFirstname = $this->view->newInput( 'inputEmbedPersonFirstname' , 'Text' );
      $this->items['embed_person-firstname'] = $inputFirstname;
      $inputFirstname->addAttributes
      (
        array
        (
          'name'      => 'embed_person[firstname]',
          'id'        => 'wgt-input-embed_person_firstname'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Firstname (Person)', 'core.person.label' ),
          'maxlength' => $this->entityEmbedPerson->maxSize( 'firstname' ),
        )
      );
      $inputFirstname->setWidth( 'medium' );

      $inputFirstname->setReadonly( $this->fieldReadOnly( 'embed_person', 'firstname' ) );
      $inputFirstname->setRequired( $this->fieldRequired( 'embed_person', 'firstname' ) );
      $inputFirstname->setData( $this->entityEmbedPerson->getSecure('firstname') );
      $inputFirstname->setLabel( $i18n->l( 'Firstname', 'core.person.label' ) );

      $inputFirstname->refresh           = $this->refresh;
      $inputFirstname->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


  }//end public function input_EmbedPerson_Firstname */

 /**
  * create the ui element for field lastname
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedPerson_Lastname( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:text
      $inputLastname = $this->view->newInput( 'inputEmbedPersonLastname' , 'Text' );
      $this->items['embed_person-lastname'] = $inputLastname;
      $inputLastname->addAttributes
      (
        array
        (
          'name'      => 'embed_person[lastname]',
          'id'        => 'wgt-input-embed_person_lastname'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Lastname (Person)', 'core.person.label' ),
          'maxlength' => $this->entityEmbedPerson->maxSize( 'lastname' ),
        )
      );
      $inputLastname->setWidth( 'medium' );

      $inputLastname->setReadonly( $this->fieldReadOnly( 'embed_person', 'lastname' ) );
      $inputLastname->setRequired( $this->fieldRequired( 'embed_person', 'lastname' ) );
      $inputLastname->setData( $this->entityEmbedPerson->getSecure('lastname') );
      $inputLastname->setLabel( $i18n->l( 'Lastname', 'core.person.label' ) );

      $inputLastname->refresh           = $this->refresh;
      $inputLastname->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


  }//end public function input_EmbedPerson_Lastname */

 /**
  * create the ui element for field academic_title
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedPerson_AcademicTitle( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:text
      $inputAcademicTitle = $this->view->newInput( 'inputEmbedPersonAcademicTitle' , 'Text' );
      $this->items['embed_person-academic_title'] = $inputAcademicTitle;
      $inputAcademicTitle->addAttributes
      (
        array
        (
          'name'      => 'embed_person[academic_title]',
          'id'        => 'wgt-input-embed_person_academic_title'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Academic Title (Person)', 'core.person.label' ),
          'maxlength' => $this->entityEmbedPerson->maxSize( 'academic_title' ),
        )
      );
      $inputAcademicTitle->setWidth( 'medium' );

      $inputAcademicTitle->setReadonly( $this->fieldReadOnly( 'embed_person', 'academic_title' ) );
      $inputAcademicTitle->setRequired( $this->fieldRequired( 'embed_person', 'academic_title' ) );
      $inputAcademicTitle->setData( $this->entityEmbedPerson->getSecure('academic_title') );
      $inputAcademicTitle->setLabel( $i18n->l( 'Academic Title', 'core.person.label' ) );

      $inputAcademicTitle->refresh           = $this->refresh;
      $inputAcademicTitle->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


  }//end public function input_EmbedPerson_AcademicTitle */

 /**
  * create the ui element for field noblesse_title
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedPerson_NoblesseTitle( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:text
      $inputNoblesseTitle = $this->view->newInput( 'inputEmbedPersonNoblesseTitle' , 'Text' );
      $this->items['embed_person-noblesse_title'] = $inputNoblesseTitle;
      $inputNoblesseTitle->addAttributes
      (
        array
        (
          'name'      => 'embed_person[noblesse_title]',
          'id'        => 'wgt-input-embed_person_noblesse_title'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Noblesse Title (Person)', 'core.person.label' ),
          'maxlength' => $this->entityEmbedPerson->maxSize( 'noblesse_title' ),
        )
      );
      $inputNoblesseTitle->setWidth( 'medium' );

      $inputNoblesseTitle->setReadonly( $this->fieldReadOnly( 'embed_person', 'noblesse_title' ) );
      $inputNoblesseTitle->setRequired( $this->fieldRequired( 'embed_person', 'noblesse_title' ) );
      $inputNoblesseTitle->setData( $this->entityEmbedPerson->getSecure('noblesse_title') );
      $inputNoblesseTitle->setLabel( $i18n->l( 'Noblesse Title', 'core.person.label' ) );

      $inputNoblesseTitle->refresh           = $this->refresh;
      $inputNoblesseTitle->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


  }//end public function input_EmbedPerson_NoblesseTitle */

 /**
  * create the ui element for field id_employee
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_IdEmployee( $params )
  {
    $i18n     = $this->view->i18n;

    if (!Webfrap::classLoadable( 'EnterpriseEmployee_Entity' ) )
    {
      if(DEBUG)
        Debug::console( 'Entity EnterpriseEmployee not exists' );

      Log::warn( 'Looks like the Entity: EnterpriseEmployee is missing' );

      return;
    }


      //p: Window
      $objidEnterpriseEmployee = $this->entity->getData( 'id_employee' ) ;

      // entity ids can never be 0 so thats ok
      if
      (
        !$objidEnterpriseEmployee
          || !$entityEnterpriseEmployee = $this->db->orm->get
          (
            'EnterpriseEmployee',
            $objidEnterpriseEmployee
          )
      )
      {
        $entityEnterpriseEmployee = $this->db->orm->newEntity( 'EnterpriseEmployee' );
      }

      $inputIdEmployee = $this->view->newInput( 'inputMyProfileIdEmployee', 'Window' );
      $this->items['my_profile-id_employee'] = $inputIdEmployee;
      $inputIdEmployee->addAttributes(array
      (
        'readonly'  => 'readonly',
        'name'      => 'wbfsys_role_user[id_employee]',
        'id'        => 'wgt-input-my_profile_id_employee'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title'     => $i18n->l( 'Insert value for Employee (Role User)', 'wbfsys.role_user.label' ),
      ));

      if( $this->assignedForm )
        $inputIdEmployee->assignedForm = $this->assignedForm;

      $inputIdEmployee->setWidth( 'medium' );

      $inputIdEmployee->setData( $this->entity->getData( 'id_employee' )  );
      $inputIdEmployee->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'id_employee' ) );
      $inputIdEmployee->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'id_employee' ) );
      $inputIdEmployee->setLabel( $i18n->l( 'Employee', 'wbfsys.role_user.label' ) );


      $listUrl = 'modal.php?c=Enterprise.Employee.selection&full_load=true'
        .'&amp;key_name=embed_enterprise_employee&amp;suffix='.$this->suffix.'&input=wbfsys_role_user_id_employee'.($this->suffix?'-'.$this->suffix:'');

      $inputIdEmployee->setListUrl ( $listUrl );
      $inputIdEmployee->setListIcon( 'webfrap/connect.png' );
      $inputIdEmployee->setEntityUrl( 'maintab.php?c=Enterprise.Employee.edit' );
      $inputIdEmployee->conEntity         = $entityEnterpriseEmployee;
      $inputIdEmployee->refresh           = $this->refresh;
      $inputIdEmployee->serializeElement  = $this->sendElement;



      $inputIdEmployee->view = $this->view;
      $inputIdEmployee->buildJavascript( 'wgt-input-my_profile_id_employee'.($this->suffix?'-'.$this->suffix:'') );
      $this->view->addJsCode( $inputIdEmployee );

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_MyProfile_IdEmployee */

 /**
  * create the ui element for field m_time_created
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_MTimeCreated( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:date
      $inputMTimeCreated = $this->view->newInput( 'inputMyProfileMTimeCreated' , 'Date' );
      $this->items['my_profile-m_time_created'] = $inputMTimeCreated;
      $inputMTimeCreated->addAttributes
      (
        array
        (
          'name'      => 'wbfsys_role_user[m_time_created]',
          'id'        => 'wgt-input-my_profile_m_time_created'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Time Created (Role User)', 'wbfsys.role_user.label' ),
          'maxlength' => $this->entity->maxSize( 'm_time_created' ),
        )
      );
      $inputMTimeCreated->setWidth( 'small' );

      $inputMTimeCreated->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'm_time_created' ) );
      $inputMTimeCreated->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'm_time_created' ) );
      $inputMTimeCreated->setData( $this->entity->getDate( 'm_time_created' ) );
      $inputMTimeCreated->setLabel( $i18n->l( 'Time Created', 'wbfsys.role_user.label' ) );

      $inputMTimeCreated->refresh           = $this->refresh;
      $inputMTimeCreated->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );


  }//end public function input_MyProfile_MTimeCreated */

 /**
  * create the ui element for field m_role_create
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_MRoleCreate( $params )
  {
    $i18n     = $this->view->i18n;

    if (!Webfrap::classLoadable( 'WbfsysRoleUser_Entity' ) )
    {
      if(DEBUG)
        Debug::console( 'Entity WbfsysRoleUser not exists' );

      Log::warn( 'Looks like the Entity: WbfsysRoleUser is missing' );

      return;
    }


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

      $inputMRoleCreate = $this->view->newInput( 'inputWbfsysRoleUserMRoleCreate', 'Window' );
      $this->items['my_profile-m_role_create'] = $inputMRoleCreate;
      $inputMRoleCreate->addAttributes(array
      (
        'readonly'  => 'readonly',
        'name'      => 'wbfsys_role_user[m_role_create]',
        'id'        => 'wgt-input-my_profile_m_role_create'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title'     => $i18n->l( 'Insert value for Role Create (Role User)', 'wbfsys.role_user.label' ),
      ));

      if( $this->assignedForm )
        $inputMRoleCreate->assignedForm = $this->assignedForm;

      $inputMRoleCreate->setWidth( 'medium' );

      $inputMRoleCreate->setData( $this->entity->getData( 'm_role_create' )  );
      $inputMRoleCreate->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'm_role_create' ) );
      $inputMRoleCreate->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'm_role_create' ) );
      $inputMRoleCreate->setLabel( $i18n->l( 'Role Create', 'wbfsys.role_user.label' ) );


      $listUrl = 'modal.php?c=Wbfsys.RoleUser.selection'
        .'&amp;suffix='.$this->suffix.'&input=wbfsys_role_user_m_role_create'.($this->suffix?'-'.$this->suffix:'');

      $inputMRoleCreate->setListUrl ( $listUrl );
      $inputMRoleCreate->setListIcon( 'webfrap/connect.png' );
      $inputMRoleCreate->setEntityUrl( 'maintab.php?c=Wbfsys.RoleUser.edit' );
      $inputMRoleCreate->conEntity         = $entityWbfsysRoleUser;
      $inputMRoleCreate->refresh           = $this->refresh;
      $inputMRoleCreate->serializeElement  = $this->sendElement;


        $inputMRoleCreate->setAutocomplete
        (
        '{
          "url":"ajax.php?c=Wbfsys.RoleUser.autocomplete&amp;key=",
          "type":"entity"
          }'
        );


      $inputMRoleCreate->view = $this->view;
      $inputMRoleCreate->buildJavascript( 'wgt-input-my_profile_m_role_create'.($this->suffix?'-'.$this->suffix:'') );
      $this->view->addJsCode( $inputMRoleCreate );

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );

  }//end public function input_MyProfile_MRoleCreate */

 /**
  * create the ui element for field m_time_changed
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_MTimeChanged( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:date
      $inputMTimeChanged = $this->view->newInput( 'inputWbfsysRoleUserMTimeChanged' , 'Date' );
      $this->items['my_profile-m_time_changed'] = $inputMTimeChanged;
      $inputMTimeChanged->addAttributes
      (
        array
        (
          'name'      => 'wbfsys_role_user[m_time_changed]',
          'id'        => 'wgt-input-my_profile_m_time_changed'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Time Changed (Role User)', 'wbfsys.role_user.label' ),
          'maxlength' => $this->entity->maxSize( 'm_time_changed' ),
        )
      );
      $inputMTimeChanged->setWidth( 'small' );

      $inputMTimeChanged->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'm_time_changed' ) );
      $inputMTimeChanged->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'm_time_changed' ) );
      $inputMTimeChanged->setData( $this->entity->getDate( 'm_time_changed' ) );
      $inputMTimeChanged->setLabel( $i18n->l( 'Time Changed', 'wbfsys.role_user.label' ) );

      $inputMTimeChanged->refresh           = $this->refresh;
      $inputMTimeChanged->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );


  }//end public function input_MyProfile_MTimeChanged */

 /**
  * create the ui element for field m_role_change
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_MRoleChange( $params )
  {
    $i18n     = $this->view->i18n;

    if (!Webfrap::classLoadable( 'WbfsysRoleUser_Entity' ) )
    {
      if(DEBUG)
        Debug::console( 'Entity WbfsysRoleUser not exists' );

      Log::warn( 'Looks like the Entity: WbfsysRoleUser is missing' );

      return;
    }


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

      $inputMRoleChange = $this->view->newInput( 'inputWbfsysRoleUserMRoleChange', 'Window' );
      $this->items['my_profile-m_role_change'] = $inputMRoleChange;
      $inputMRoleChange->addAttributes(array
      (
        'readonly'  => 'readonly',
        'name'      => 'wbfsys_role_user[m_role_change]',
        'id'        => 'wgt-input-my_profile_m_role_change'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title'     => $i18n->l( 'Insert value for Role Change (Role User)', 'wbfsys.role_user.label' ),
      ));

      if( $this->assignedForm )
        $inputMRoleChange->assignedForm = $this->assignedForm;

      $inputMRoleChange->setWidth( 'medium' );

      $inputMRoleChange->setData( $this->entity->getData( 'm_role_change' )  );
      $inputMRoleChange->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'm_role_change' ) );
      $inputMRoleChange->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'm_role_change' ) );
      $inputMRoleChange->setLabel( $i18n->l( 'Role Change', 'wbfsys.role_user.label' ) );


      $listUrl = 'modal.php?c=Wbfsys.RoleUser.selection'
        .'&amp;suffix='.$this->suffix.'&input=wbfsys_role_user_m_role_change'.($this->suffix?'-'.$this->suffix:'');

      $inputMRoleChange->setListUrl ( $listUrl );
      $inputMRoleChange->setListIcon( 'webfrap/connect.png' );
      $inputMRoleChange->setEntityUrl( 'maintab.php?c=Wbfsys.RoleUser.edit' );
      $inputMRoleChange->conEntity         = $entityWbfsysRoleUser;
      $inputMRoleChange->refresh           = $this->refresh;
      $inputMRoleChange->serializeElement  = $this->sendElement;


        $inputMRoleChange->setAutocomplete
        (
        '{
          "url":"ajax.php?c=Wbfsys.RoleUser.autocomplete&amp;key=",
          "type":"entity"
          }'
        );


      $inputMRoleChange->view = $this->view;
      $inputMRoleChange->buildJavascript( 'wgt-input-my_profile_m_role_change'.($this->suffix?'-'.$this->suffix:'') );
      $this->view->addJsCode( $inputMRoleChange );

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );

  }//end public function input_MyProfile_MRoleChange */

 /**
  * create the ui element for field m_version
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_MVersion( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui: guess
      $inputMVersion = $this->view->newInput( 'inputWbfsysRoleUserMVersion' , 'int' );
      $this->items['my_profile-m_version'] = $inputMVersion;
      $inputMVersion->addAttributes
      (
        array
        (
          'name'      => 'wbfsys_role_user[m_version]',
          'id'        => 'wgt-input-my_profile_m_version'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip valid_int medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Version (Role User)', 'wbfsys.role_user.label' ),
        )
      );
      $inputMVersion->setWidth( 'medium' );

      $inputMVersion->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'm_version' ) );
      $inputMVersion->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'm_version' ) );
      $inputMVersion->setData( $this->entity->getSecure( 'm_version' ) );
      $inputMVersion->setLabel( $i18n->l( 'Version', 'wbfsys.role_user.label' ) );

      $inputMVersion->refresh           = $this->refresh;
      $inputMVersion->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );



  }//end public function input_MyProfile_MVersion */

 /**
  * create the ui element for field m_uuid
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_MUuid( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui: guess
      $inputMUuid = $this->view->newInput( 'inputWbfsysRoleUserMUuid' , 'Text' );
      $this->items['my_profile-m_uuid'] = $inputMUuid;
      $inputMUuid->addAttributes
      (
        array
        (
          'name'      => 'wbfsys_role_user[m_uuid]',
          'id'        => 'wgt-input-my_profile_m_uuid'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Uuid (Role User)', 'wbfsys.role_user.label' ),
        )
      );
      $inputMUuid->setWidth( 'medium' );

      $inputMUuid->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'm_uuid' ) );
      $inputMUuid->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'm_uuid' ) );
      $inputMUuid->setData( $this->entity->getSecure( 'm_uuid' ) );
      $inputMUuid->setLabel( $i18n->l( 'Uuid', 'wbfsys.role_user.label' ) );

      $inputMUuid->refresh           = $this->refresh;
      $inputMUuid->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );



  }//end public function input_MyProfile_MUuid */

 /**
  * create the ui element for field rowid
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedPerson_Rowid( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui: guess
      $inputRowid = $this->view->newInput( 'inputEmbedPersonRowid' , 'int' );
      $this->items['embed_person-rowid'] = $inputRowid;
      $inputRowid->addAttributes
      (
        array
        (
          'name'      => 'embed_person[rowid]',
          'id'        => 'wgt-input-embed_person_rowid'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip valid_required medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Rowid (Person)', 'core.person.label' ),
        )
      );
      $inputRowid->setWidth( 'medium' );

      $inputRowid->setReadonly( $this->fieldReadOnly( 'embed_person', 'rowid' ) );
      $inputRowid->setRequired( $this->fieldRequired( 'embed_person', 'rowid' ) );
      $inputRowid->setData( $this->entityEmbedPerson->getId() );
      $inputRowid->setLabel( $i18n->l( 'Rowid', 'core.person.label' ) );

      $inputRowid->refresh           = $this->refresh;
      $inputRowid->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );



  }//end public function input_EmbedPerson_Rowid */

 /**
  * create the ui element for field m_time_created
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedPerson_MTimeCreated( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:date
      $inputMTimeCreated = $this->view->newInput( 'inputEmbedPersonMTimeCreated' , 'Date' );
      $this->items['embed_person-m_time_created'] = $inputMTimeCreated;
      $inputMTimeCreated->addAttributes
      (
        array
        (
          'name'      => 'embed_person[m_time_created]',
          'id'        => 'wgt-input-embed_person_m_time_created'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Time Created (Person)', 'core.person.label' ),
          'maxlength' => $this->entityEmbedPerson->maxSize( 'm_time_created' ),
        )
      );
      $inputMTimeCreated->setWidth( 'small' );

      $inputMTimeCreated->setReadonly( $this->fieldReadOnly( 'embed_person', 'm_time_created' ) );
      $inputMTimeCreated->setRequired( $this->fieldRequired( 'embed_person', 'm_time_created' ) );
      $inputMTimeCreated->setData( $this->entityEmbedPerson->getDate( 'm_time_created' ) );
      $inputMTimeCreated->setLabel( $i18n->l( 'Time Created', 'core.person.label' ) );

      $inputMTimeCreated->refresh           = $this->refresh;
      $inputMTimeCreated->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );


  }//end public function input_EmbedPerson_MTimeCreated */

 /**
  * create the ui element for field m_role_create
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedPerson_MRoleCreate( $params )
  {
    $i18n     = $this->view->i18n;

    if (!Webfrap::classLoadable( 'WbfsysRoleUser_Entity' ) )
    {
      if(DEBUG)
        Debug::console( 'Entity WbfsysRoleUser not exists' );

      Log::warn( 'Looks like the Entity: WbfsysRoleUser is missing' );

      return;
    }


      //p: Window
      $objidWbfsysRoleUser = $this->entityEmbedPerson->getData( 'm_role_create' ) ;

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

      $inputMRoleCreate = $this->view->newInput( 'inputEmbedPersonMRoleCreate', 'Window' );
      $this->items['embed_person-m_role_create'] = $inputMRoleCreate;
      $inputMRoleCreate->addAttributes(array
      (
        'readonly'  => 'readonly',
        'name'      => 'embed_person[m_role_create]',
        'id'        => 'wgt-input-embed_person_m_role_create'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title'     => $i18n->l( 'Insert value for Role Create (Person)', 'core.person.label' ),
      ));

      if( $this->assignedForm )
        $inputMRoleCreate->assignedForm = $this->assignedForm;

      $inputMRoleCreate->setWidth( 'medium' );

      $inputMRoleCreate->setData( $this->entityEmbedPerson->getData( 'm_role_create' )  );
      $inputMRoleCreate->setReadonly( $this->fieldReadOnly( 'embed_person', 'm_role_create' ) );
      $inputMRoleCreate->setRequired( $this->fieldRequired( 'embed_person', 'm_role_create' ) );
      $inputMRoleCreate->setLabel( $i18n->l( 'Role Create', 'core.person.label' ) );


      $listUrl = 'modal.php?c=Wbfsys.RoleUser.selection'
        .'&amp;suffix='.$this->suffix.'&input=embed_person_m_role_create'.($this->suffix?'-'.$this->suffix:'');

      $inputMRoleCreate->setListUrl ( $listUrl );
      $inputMRoleCreate->setListIcon( 'webfrap/connect.png' );
      $inputMRoleCreate->setEntityUrl( 'maintab.php?c=Wbfsys.RoleUser.edit' );
      $inputMRoleCreate->conEntity         = $entityWbfsysRoleUser;
      $inputMRoleCreate->refresh           = $this->refresh;
      $inputMRoleCreate->serializeElement  = $this->sendElement;


        $inputMRoleCreate->setAutocomplete
        (
        '{
          "url":"ajax.php?c=Wbfsys.RoleUser.autocomplete&amp;key=",
          "type":"entity"
          }'
        );


      $inputMRoleCreate->view = $this->view;
      $inputMRoleCreate->buildJavascript( 'wgt-input-embed_person_m_role_create'.($this->suffix?'-'.$this->suffix:'') );
      $this->view->addJsCode( $inputMRoleCreate );

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );

  }//end public function input_EmbedPerson_MRoleCreate */

 /**
  * create the ui element for field m_time_changed
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedPerson_MTimeChanged( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:date
      $inputMTimeChanged = $this->view->newInput( 'inputEmbedPersonMTimeChanged' , 'Date' );
      $this->items['embed_person-m_time_changed'] = $inputMTimeChanged;
      $inputMTimeChanged->addAttributes
      (
        array
        (
          'name'      => 'embed_person[m_time_changed]',
          'id'        => 'wgt-input-embed_person_m_time_changed'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Time Changed (Person)', 'core.person.label' ),
          'maxlength' => $this->entityEmbedPerson->maxSize( 'm_time_changed' ),
        )
      );
      $inputMTimeChanged->setWidth( 'small' );

      $inputMTimeChanged->setReadonly( $this->fieldReadOnly( 'embed_person', 'm_time_changed' ) );
      $inputMTimeChanged->setRequired( $this->fieldRequired( 'embed_person', 'm_time_changed' ) );
      $inputMTimeChanged->setData( $this->entityEmbedPerson->getDate( 'm_time_changed' ) );
      $inputMTimeChanged->setLabel( $i18n->l( 'Time Changed', 'core.person.label' ) );

      $inputMTimeChanged->refresh           = $this->refresh;
      $inputMTimeChanged->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );


  }//end public function input_EmbedPerson_MTimeChanged */

 /**
  * create the ui element for field m_role_change
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedPerson_MRoleChange( $params )
  {
    $i18n     = $this->view->i18n;

    if (!Webfrap::classLoadable( 'WbfsysRoleUser_Entity' ) )
    {
      if(DEBUG)
        Debug::console( 'Entity WbfsysRoleUser not exists' );

      Log::warn( 'Looks like the Entity: WbfsysRoleUser is missing' );

      return;
    }


      //p: Window
      $objidWbfsysRoleUser = $this->entityEmbedPerson->getData( 'm_role_change' ) ;

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

      $inputMRoleChange = $this->view->newInput( 'inputEmbedPersonMRoleChange', 'Window' );
      $this->items['embed_person-m_role_change'] = $inputMRoleChange;
      $inputMRoleChange->addAttributes(array
      (
        'readonly'  => 'readonly',
        'name'      => 'embed_person[m_role_change]',
        'id'        => 'wgt-input-embed_person_m_role_change'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title'     => $i18n->l( 'Insert value for Role Change (Person)', 'core.person.label' ),
      ));

      if( $this->assignedForm )
        $inputMRoleChange->assignedForm = $this->assignedForm;

      $inputMRoleChange->setWidth( 'medium' );

      $inputMRoleChange->setData( $this->entityEmbedPerson->getData( 'm_role_change' )  );
      $inputMRoleChange->setReadonly( $this->fieldReadOnly( 'embed_person', 'm_role_change' ) );
      $inputMRoleChange->setRequired( $this->fieldRequired( 'embed_person', 'm_role_change' ) );
      $inputMRoleChange->setLabel( $i18n->l( 'Role Change', 'core.person.label' ) );


      $listUrl = 'modal.php?c=Wbfsys.RoleUser.selection'
        .'&amp;suffix='.$this->suffix.'&input=embed_person_m_role_change'.($this->suffix?'-'.$this->suffix:'');

      $inputMRoleChange->setListUrl ( $listUrl );
      $inputMRoleChange->setListIcon( 'webfrap/connect.png' );
      $inputMRoleChange->setEntityUrl( 'maintab.php?c=Wbfsys.RoleUser.edit' );
      $inputMRoleChange->conEntity         = $entityWbfsysRoleUser;
      $inputMRoleChange->refresh           = $this->refresh;
      $inputMRoleChange->serializeElement  = $this->sendElement;


        $inputMRoleChange->setAutocomplete
        (
        '{
          "url":"ajax.php?c=Wbfsys.RoleUser.autocomplete&amp;key=",
          "type":"entity"
          }'
        );


      $inputMRoleChange->view = $this->view;
      $inputMRoleChange->buildJavascript( 'wgt-input-embed_person_m_role_change'.($this->suffix?'-'.$this->suffix:'') );
      $this->view->addJsCode( $inputMRoleChange );

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );

  }//end public function input_EmbedPerson_MRoleChange */

 /**
  * create the ui element for field m_version
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedPerson_MVersion( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui: guess
      $inputMVersion = $this->view->newInput( 'inputEmbedPersonMVersion' , 'int' );
      $this->items['embed_person-m_version'] = $inputMVersion;
      $inputMVersion->addAttributes
      (
        array
        (
          'name'      => 'embed_person[m_version]',
          'id'        => 'wgt-input-embed_person_m_version'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip valid_int medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Version (Person)', 'core.person.label' ),
        )
      );
      $inputMVersion->setWidth( 'medium' );

      $inputMVersion->setReadonly( $this->fieldReadOnly( 'embed_person', 'm_version' ) );
      $inputMVersion->setRequired( $this->fieldRequired( 'embed_person', 'm_version' ) );
      $inputMVersion->setData( $this->entityEmbedPerson->getSecure( 'm_version' ) );
      $inputMVersion->setLabel( $i18n->l( 'Version', 'core.person.label' ) );

      $inputMVersion->refresh           = $this->refresh;
      $inputMVersion->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );



  }//end public function input_EmbedPerson_MVersion */

 /**
  * create the ui element for field m_uuid
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedPerson_MUuid( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui: guess
      $inputMUuid = $this->view->newInput( 'inputEmbedPersonMUuid' , 'Text' );
      $this->items['embed_person-m_uuid'] = $inputMUuid;
      $inputMUuid->addAttributes
      (
        array
        (
          'name'      => 'embed_person[m_uuid]',
          'id'        => 'wgt-input-embed_person_m_uuid'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Uuid (Person)', 'core.person.label' ),
        )
      );
      $inputMUuid->setWidth( 'medium' );

      $inputMUuid->setReadonly( $this->fieldReadOnly( 'embed_person', 'm_uuid' ) );
      $inputMUuid->setRequired( $this->fieldRequired( 'embed_person', 'm_uuid' ) );
      $inputMUuid->setData( $this->entityEmbedPerson->getSecure( 'm_uuid' ) );
      $inputMUuid->setLabel( $i18n->l( 'Uuid', 'core.person.label' ) );

      $inputMUuid->refresh           = $this->refresh;
      $inputMUuid->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );



  }//end public function input_EmbedPerson_MUuid */

 /**
  * create the ui element for field rowid
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedEnterpriseEmployee_Rowid( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui: guess
      $inputRowid = $this->view->newInput( 'inputEmbedEnterpriseEmployeeRowid' , 'int' );
      $this->items['embed_enterprise_employee-rowid'] = $inputRowid;
      $inputRowid->addAttributes
      (
        array
        (
          'name'      => 'embed_enterprise_employee[rowid]',
          'id'        => 'wgt-input-embed_enterprise_employee_rowid'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip valid_required medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Rowid (Employee)', 'enterprise.employee.label' ),
        )
      );
      $inputRowid->setWidth( 'medium' );

      $inputRowid->setReadonly( $this->fieldReadOnly( 'embed_enterprise_employee', 'rowid' ) );
      $inputRowid->setRequired( $this->fieldRequired( 'embed_enterprise_employee', 'rowid' ) );
      $inputRowid->setData( $this->entityEmbedEnterpriseEmployee->getId() );
      $inputRowid->setLabel( $i18n->l( 'Rowid', 'enterprise.employee.label' ) );

      $inputRowid->refresh           = $this->refresh;
      $inputRowid->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );



  }//end public function input_EmbedEnterpriseEmployee_Rowid */

 /**
  * create the ui element for field m_time_created
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedEnterpriseEmployee_MTimeCreated( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:date
      $inputMTimeCreated = $this->view->newInput( 'inputEmbedEnterpriseEmployeeMTimeCreated' , 'Date' );
      $this->items['embed_enterprise_employee-m_time_created'] = $inputMTimeCreated;
      $inputMTimeCreated->addAttributes
      (
        array
        (
          'name'      => 'embed_enterprise_employee[m_time_created]',
          'id'        => 'wgt-input-embed_enterprise_employee_m_time_created'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Time Created (Employee)', 'enterprise.employee.label' ),
          'maxlength' => $this->entityEmbedEnterpriseEmployee->maxSize( 'm_time_created' ),
        )
      );
      $inputMTimeCreated->setWidth( 'small' );

      $inputMTimeCreated->setReadonly( $this->fieldReadOnly( 'embed_enterprise_employee', 'm_time_created' ) );
      $inputMTimeCreated->setRequired( $this->fieldRequired( 'embed_enterprise_employee', 'm_time_created' ) );
      $inputMTimeCreated->setData( $this->entityEmbedEnterpriseEmployee->getDate( 'm_time_created' ) );
      $inputMTimeCreated->setLabel( $i18n->l( 'Time Created', 'enterprise.employee.label' ) );

      $inputMTimeCreated->refresh           = $this->refresh;
      $inputMTimeCreated->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );


  }//end public function input_EmbedEnterpriseEmployee_MTimeCreated */

 /**
  * create the ui element for field m_role_create
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedEnterpriseEmployee_MRoleCreate( $params )
  {
    $i18n     = $this->view->i18n;

    if (!Webfrap::classLoadable( 'WbfsysRoleUser_Entity' ) )
    {
      if(DEBUG)
        Debug::console( 'Entity WbfsysRoleUser not exists' );

      Log::warn( 'Looks like the Entity: WbfsysRoleUser is missing' );

      return;
    }


      //p: Window
      $objidWbfsysRoleUser = $this->entityEmbedEnterpriseEmployee->getData( 'm_role_create' ) ;

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

      $inputMRoleCreate = $this->view->newInput( 'inputEmbedEnterpriseEmployeeMRoleCreate', 'Window' );
      $this->items['embed_enterprise_employee-m_role_create'] = $inputMRoleCreate;
      $inputMRoleCreate->addAttributes(array
      (
        'readonly'  => 'readonly',
        'name'      => 'embed_enterprise_employee[m_role_create]',
        'id'        => 'wgt-input-embed_enterprise_employee_m_role_create'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title'     => $i18n->l( 'Insert value for Role Create (Employee)', 'enterprise.employee.label' ),
      ));

      if( $this->assignedForm )
        $inputMRoleCreate->assignedForm = $this->assignedForm;

      $inputMRoleCreate->setWidth( 'medium' );

      $inputMRoleCreate->setData( $this->entityEmbedEnterpriseEmployee->getData( 'm_role_create' )  );
      $inputMRoleCreate->setReadonly( $this->fieldReadOnly( 'embed_enterprise_employee', 'm_role_create' ) );
      $inputMRoleCreate->setRequired( $this->fieldRequired( 'embed_enterprise_employee', 'm_role_create' ) );
      $inputMRoleCreate->setLabel( $i18n->l( 'Role Create', 'enterprise.employee.label' ) );


      $listUrl = 'modal.php?c=Wbfsys.RoleUser.selection'
        .'&amp;suffix='.$this->suffix.'&input=embed_enterprise_employee_m_role_create'.($this->suffix?'-'.$this->suffix:'');

      $inputMRoleCreate->setListUrl ( $listUrl );
      $inputMRoleCreate->setListIcon( 'webfrap/connect.png' );
      $inputMRoleCreate->setEntityUrl( 'maintab.php?c=Wbfsys.RoleUser.edit' );
      $inputMRoleCreate->conEntity         = $entityWbfsysRoleUser;
      $inputMRoleCreate->refresh           = $this->refresh;
      $inputMRoleCreate->serializeElement  = $this->sendElement;


        $inputMRoleCreate->setAutocomplete
        (
        '{
          "url":"ajax.php?c=Wbfsys.RoleUser.autocomplete&amp;key=",
          "type":"entity"
          }'
        );


      $inputMRoleCreate->view = $this->view;
      $inputMRoleCreate->buildJavascript( 'wgt-input-embed_enterprise_employee_m_role_create'.($this->suffix?'-'.$this->suffix:'') );
      $this->view->addJsCode( $inputMRoleCreate );

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );

  }//end public function input_EmbedEnterpriseEmployee_MRoleCreate */

 /**
  * create the ui element for field m_time_changed
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedEnterpriseEmployee_MTimeChanged( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:date
      $inputMTimeChanged = $this->view->newInput( 'inputEmbedEnterpriseEmployeeMTimeChanged' , 'Date' );
      $this->items['embed_enterprise_employee-m_time_changed'] = $inputMTimeChanged;
      $inputMTimeChanged->addAttributes
      (
        array
        (
          'name'      => 'embed_enterprise_employee[m_time_changed]',
          'id'        => 'wgt-input-embed_enterprise_employee_m_time_changed'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip small'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Time Changed (Employee)', 'enterprise.employee.label' ),
          'maxlength' => $this->entityEmbedEnterpriseEmployee->maxSize( 'm_time_changed' ),
        )
      );
      $inputMTimeChanged->setWidth( 'small' );

      $inputMTimeChanged->setReadonly( $this->fieldReadOnly( 'embed_enterprise_employee', 'm_time_changed' ) );
      $inputMTimeChanged->setRequired( $this->fieldRequired( 'embed_enterprise_employee', 'm_time_changed' ) );
      $inputMTimeChanged->setData( $this->entityEmbedEnterpriseEmployee->getDate( 'm_time_changed' ) );
      $inputMTimeChanged->setLabel( $i18n->l( 'Time Changed', 'enterprise.employee.label' ) );

      $inputMTimeChanged->refresh           = $this->refresh;
      $inputMTimeChanged->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );


  }//end public function input_EmbedEnterpriseEmployee_MTimeChanged */

 /**
  * create the ui element for field m_role_change
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedEnterpriseEmployee_MRoleChange( $params )
  {
    $i18n     = $this->view->i18n;

    if (!Webfrap::classLoadable( 'WbfsysRoleUser_Entity' ) )
    {
      if(DEBUG)
        Debug::console( 'Entity WbfsysRoleUser not exists' );

      Log::warn( 'Looks like the Entity: WbfsysRoleUser is missing' );

      return;
    }


      //p: Window
      $objidWbfsysRoleUser = $this->entityEmbedEnterpriseEmployee->getData( 'm_role_change' ) ;

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

      $inputMRoleChange = $this->view->newInput( 'inputEmbedEnterpriseEmployeeMRoleChange', 'Window' );
      $this->items['embed_enterprise_employee-m_role_change'] = $inputMRoleChange;
      $inputMRoleChange->addAttributes(array
      (
        'readonly'  => 'readonly',
        'name'      => 'embed_enterprise_employee[m_role_change]',
        'id'        => 'wgt-input-embed_enterprise_employee_m_role_change'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
        'title'     => $i18n->l( 'Insert value for Role Change (Employee)', 'enterprise.employee.label' ),
      ));

      if( $this->assignedForm )
        $inputMRoleChange->assignedForm = $this->assignedForm;

      $inputMRoleChange->setWidth( 'medium' );

      $inputMRoleChange->setData( $this->entityEmbedEnterpriseEmployee->getData( 'm_role_change' )  );
      $inputMRoleChange->setReadonly( $this->fieldReadOnly( 'embed_enterprise_employee', 'm_role_change' ) );
      $inputMRoleChange->setRequired( $this->fieldRequired( 'embed_enterprise_employee', 'm_role_change' ) );
      $inputMRoleChange->setLabel( $i18n->l( 'Role Change', 'enterprise.employee.label' ) );


      $listUrl = 'modal.php?c=Wbfsys.RoleUser.selection'
        .'&amp;suffix='.$this->suffix.'&input=embed_enterprise_employee_m_role_change'.($this->suffix?'-'.$this->suffix:'');

      $inputMRoleChange->setListUrl ( $listUrl );
      $inputMRoleChange->setListIcon( 'webfrap/connect.png' );
      $inputMRoleChange->setEntityUrl( 'maintab.php?c=Wbfsys.RoleUser.edit' );
      $inputMRoleChange->conEntity         = $entityWbfsysRoleUser;
      $inputMRoleChange->refresh           = $this->refresh;
      $inputMRoleChange->serializeElement  = $this->sendElement;


        $inputMRoleChange->setAutocomplete
        (
        '{
          "url":"ajax.php?c=Wbfsys.RoleUser.autocomplete&amp;key=",
          "type":"entity"
          }'
        );


      $inputMRoleChange->view = $this->view;
      $inputMRoleChange->buildJavascript( 'wgt-input-embed_enterprise_employee_m_role_change'.($this->suffix?'-'.$this->suffix:'') );
      $this->view->addJsCode( $inputMRoleChange );

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );

  }//end public function input_EmbedEnterpriseEmployee_MRoleChange */

 /**
  * create the ui element for field m_version
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedEnterpriseEmployee_MVersion( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui: guess
      $inputMVersion = $this->view->newInput( 'inputEmbedEnterpriseEmployeeMVersion' , 'int' );
      $this->items['embed_enterprise_employee-m_version'] = $inputMVersion;
      $inputMVersion->addAttributes
      (
        array
        (
          'name'      => 'embed_enterprise_employee[m_version]',
          'id'        => 'wgt-input-embed_enterprise_employee_m_version'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip valid_int medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Version (Employee)', 'enterprise.employee.label' ),
        )
      );
      $inputMVersion->setWidth( 'medium' );

      $inputMVersion->setReadonly( $this->fieldReadOnly( 'embed_enterprise_employee', 'm_version' ) );
      $inputMVersion->setRequired( $this->fieldRequired( 'embed_enterprise_employee', 'm_version' ) );
      $inputMVersion->setData( $this->entityEmbedEnterpriseEmployee->getSecure( 'm_version' ) );
      $inputMVersion->setLabel( $i18n->l( 'Version', 'enterprise.employee.label' ) );

      $inputMVersion->refresh           = $this->refresh;
      $inputMVersion->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );



  }//end public function input_EmbedEnterpriseEmployee_MVersion */

 /**
  * create the ui element for field m_uuid
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedEnterpriseEmployee_MUuid( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui: guess
      $inputMUuid = $this->view->newInput( 'inputEmbedEnterpriseEmployeeMUuid' , 'Text' );
      $this->items['embed_enterprise_employee-m_uuid'] = $inputMUuid;
      $inputMUuid->addAttributes
      (
        array
        (
          'name'      => 'embed_enterprise_employee[m_uuid]',
          'id'        => 'wgt-input-embed_enterprise_employee_m_uuid'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Uuid (Employee)', 'enterprise.employee.label' ),
        )
      );
      $inputMUuid->setWidth( 'medium' );

      $inputMUuid->setReadonly( $this->fieldReadOnly( 'embed_enterprise_employee', 'm_uuid' ) );
      $inputMUuid->setRequired( $this->fieldRequired( 'embed_enterprise_employee', 'm_uuid' ) );
      $inputMUuid->setData( $this->entityEmbedEnterpriseEmployee->getSecure( 'm_uuid' ) );
      $inputMUuid->setLabel( $i18n->l( 'Uuid', 'enterprise.employee.label' ) );

      $inputMUuid->refresh           = $this->refresh;
      $inputMUuid->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Meta' ,
        true
      );



  }//end public function input_EmbedEnterpriseEmployee_MUuid */

 /**
  * create the ui element for field photo
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_EmbedPerson_Photo( $params )
  {
    $i18n     = $this->view->i18n;

      //p: input file image
      $inputPhoto = $this->view->newInput( 'inputEmbedPersonPhoto', 'FileImage' );
      $inputPhoto->addAttributes
      (
        array
        (
          'name'      => 'embed_person[photo]',
          'id'        => 'wgt-input-embed_person_photo'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium',
          'title'     => $i18n->l( 'Insert value for Photo (Person)', 'core.person.label' ),
        )
      );
      $inputPhoto->setWidth( 'medium' );

      if
      (
        ( $objid = $this->entityEmbedPerson->getId() )
          && $this->entityEmbedPerson->photo
      )
      {
        $inputPhoto->setSource
        (
          'thumb.php?f=core_person-photo-'.$objid.'&n='
            .base64_encode( $this->entityEmbedPerson->photo )
        );
        $inputPhoto->setLink
        (
          'image.php?f=core_person-photo-'.$objid.'&n='
            .base64_encode( $this->entityEmbedPerson->photo )
        );
      }

      if( $this->assignedForm )
        $inputPhoto->assignedForm = $this->assignedForm;

      $inputPhoto->setReadonly( $this->fieldReadOnly( 'embed_person', 'photo' ) );
      $inputPhoto->setRequired( $this->fieldRequired( 'embed_person', 'photo' ) );
      $inputPhoto->setLabel( $i18n->l( 'Photo', 'core.person.label' ) );


      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_EmbedPerson_Photo */

 /**
  * create the ui element for field password
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_Password( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:password
      $inputPassword = $this->view->newInput( 'inputWbfsysRoleUserPassword', 'Password' );
      $this->items['my_profile-password'] = $inputPassword;
      $inputPassword->addAttributes
      (
        array
        (
          'name'      => 'wbfsys_role_user[password]',
          'id'        => 'wgt-input-my_profile_password'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip valid_password medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Password (Role User)', 'wbfsys.role_user.label' ),
          'maxlength' => $this->entity->maxSize( 'password' ),
        )
      );
      $inputPassword->setWidth( 'medium' );

      $inputPassword->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'password' ) );
      $inputPassword->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'password' ) );
      $inputPassword->setLabel( $i18n->l( 'Password', 'wbfsys.role_user.label' ) );


      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


  }//end public function input_MyProfile_Password */

 /**
  * create the ui element for field level
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_Level( $params )
  {
    $i18n     = $this->view->i18n;
    
    if (!isset( $this->listElementData['wbfsys_role_user_level'] ) )
    {
      if (!Webfrap::classLoadable( 'WbfsysSecurityLevelValue_Selectbox' ) )
      {
        if( DEBUG )
          Debug::console( 'WbfsysSecurityLevelValue_Selectbox not exists' );
  
        Log::warn( 'Looks like Selectbox: WbfsysSecurityLevelValue_Selectbox is missing' );
  
        return;
      }
    }


      //p: Selectbox
      $inputLevel = $this->view->newItem( 'inputWbfsysRoleUserLevel', 'WbfsysSecurityLevelValue_Selectbox' );
      $this->items['my_profile-level'] = $inputLevel;
      $inputLevel->addAttributes
      (
        array
        (
          'name'      => 'wbfsys_role_user[level]',
          'id'        => 'wgt-input-my_profile_level'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Access Level (Role User)', 'wbfsys.role_user.label' ),
        )
      );
      $inputLevel->setWidth( 'medium' );


      if( $this->assignedForm )
        $inputLevel->assignedForm = $this->assignedForm;

      $inputLevel->setActive( $this->entity->getData( 'level' ) );
      $inputLevel->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'level' ) );
      $inputLevel->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'level' ) );


      $inputLevel->setLabel( $i18n->l( 'Access Level', 'wbfsys.role_user.label' ) );


      $acl = $this->getAcl();

      if( $acl->access( 'mod-wbfsys>mgmt-wbfsys_security_level:insert' ) )
      {
        $inputLevel->refresh           = $this->refresh;
        $inputLevel->serializeElement  = $this->sendElement;
        $inputLevel->editUrl = 'index.php?c=Wbfsys.SecurityLevel.listing&amp;target='.$this->namespace.'&amp;field=level&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-my_profile_level'.$this->suffix;
      }
      // set an empty first entry
      $inputLevel->setFirstFree( 'No Access Level selected' );

      
      $queryLevel = null;
      // prüfen ob nicht schon custom daten gesetzt wurden
      if (!isset( $this->listElementData['wbfsys_role_user_level'] ) )
      {
      
        $queryLevel = $this->db->newQuery( 'WbfsysSecurityLevelValue_Selectbox' );

        $queryLevel->fetchSelectbox();
        $inputLevel->setData( $queryLevel->getAll() );
      
      }
      else
      {
        $inputLevel->setData( $this->listElementData['wbfsys_role_user_level'] );
      }
      
      // fallback funktion um den aktiven datensatz laden zu können, auch wenn 
      // er von filtern in dern selectbox eigentlich ausgeblendet wurde
      // wird nur ausgeführt denn der aktive datensatz nicht in der liste 
      // vorhanden ist
      
      if (!$queryLevel )
        $queryLevel = $this->db->newQuery( 'WbfsysSecurityLevelValue_Selectbox' );
      
      $inputLevel->loadActive = function( $activeId ) use ( $queryLevel ){
 
        return $queryLevel->fetchSelectboxEntry( $activeId );
        
      };
      

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_MyProfile_Level */

 /**
  * create the ui element for field profile
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_Profile( $params )
  {
    $i18n     = $this->view->i18n;
    
    if (!isset( $this->listElementData['wbfsys_role_user_profile'] ) )
    {
      if (!Webfrap::classLoadable( 'WbfsysProfileValue_Selectbox' ) )
      {
        if( DEBUG )
          Debug::console( 'WbfsysProfileValue_Selectbox not exists' );
  
        Log::warn( 'Looks like Selectbox: WbfsysProfileValue_Selectbox is missing' );
  
        return;
      }
    }


      //p: Selectbox
      $inputProfile = $this->view->newItem( 'inputWbfsysRoleUserProfile', 'WbfsysProfileValue_Selectbox' );
      $this->items['my_profile-profile'] = $inputProfile;
      $inputProfile->addAttributes
      (
        array
        (
          'name'      => 'wbfsys_role_user[profile]',
          'id'        => 'wgt-input-my_profile_profile'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Profile (Role User)', 'wbfsys.role_user.label' ),
        )
      );
      $inputProfile->setWidth( 'medium' );


      if( $this->assignedForm )
        $inputProfile->assignedForm = $this->assignedForm;

      $inputProfile->setActive( $this->entity->getData( 'profile' ) );
      $inputProfile->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'profile' ) );
      $inputProfile->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'profile' ) );


      $inputProfile->setLabel( $i18n->l( 'Profile', 'wbfsys.role_user.label' ) );


      $acl = $this->getAcl();

      if( $acl->access( 'mod-wbfsys>mgmt-wbfsys_profile:insert' ) )
      {
        $inputProfile->refresh           = $this->refresh;
        $inputProfile->serializeElement  = $this->sendElement;
        $inputProfile->editUrl = 'index.php?c=Wbfsys.Profile.listing&amp;target='.$this->namespace.'&amp;field=profile&amp;publish=selectbox&amp;suffix='.$this->suffix.'&amp;input_id=wgt-input-my_profile_profile'.$this->suffix;
      }
      // set an empty first entry
      $inputProfile->setFirstFree( 'No Profile selected' );

      
      $queryProfile = null;
      // prüfen ob nicht schon custom daten gesetzt wurden
      if (!isset( $this->listElementData['wbfsys_role_user_profile'] ) )
      {
      
        $queryProfile = $this->db->newQuery( 'WbfsysProfileValue_Selectbox' );

        $queryProfile->fetchSelectbox();
        $inputProfile->setData( $queryProfile->getAll() );
      
      }
      else
      {
        $inputProfile->setData( $this->listElementData['wbfsys_role_user_profile'] );
      }
      
      // fallback funktion um den aktiven datensatz laden zu können, auch wenn 
      // er von filtern in dern selectbox eigentlich ausgeblendet wurde
      // wird nur ausgeführt denn der aktive datensatz nicht in der liste 
      // vorhanden ist
      
      if (!$queryProfile )
        $queryProfile = $this->db->newQuery( 'WbfsysProfileValue_Selectbox' );
      
      $inputProfile->loadActive = function( $activeId ) use ( $queryProfile ){
 
        return $queryProfile->fetchSelectboxEntry( $activeId );
        
      };
      

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );

  }//end public function input_MyProfile_Profile */

 /**
  * create the ui element for field inactive
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_Inactive( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:Checkbox
      $inputInactive = $this->view->newInput( 'inputWbfsysRoleUserInactive', 'Checkbox' );
      $this->items['my_profile-inactive'] = $inputInactive;
      $inputInactive->addAttributes
      (
        array
        (
          'name'      => 'wbfsys_role_user[inactive]',
          'id'        => 'wgt-input-my_profile_inactive'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for Inactive (Role User)', 'wbfsys.role_user.label' ),
        )
      );
      $inputInactive->setWidth( 'medium' );

      $inputInactive->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'inactive' ) );
      $inputInactive->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'inactive' ) );
      $inputInactive->setActive( $this->entity->getBoolean( 'inactive' ) );
      $inputInactive->setLabel( $i18n->l( 'Inactive', 'wbfsys.role_user.label' ) );

      $inputInactive->refresh           = $this->refresh;
      $inputInactive->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


  }//end public function input_MyProfile_Inactive */

 /**
  * create the ui element for field non_cert_login
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_NonCertLogin( $params )
  {
    $i18n     = $this->view->i18n;

      //tpl: class ui:Checkbox
      $inputNonCertLogin = $this->view->newInput( 'inputWbfsysRoleUserNonCertLogin', 'Checkbox' );
      $this->items['my_profile-non_cert_login'] = $inputNonCertLogin;
      $inputNonCertLogin->addAttributes
      (
        array
        (
          'name'      => 'wbfsys_role_user[non_cert_login]',
          'id'        => 'wgt-input-my_profile_non_cert_login'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip medium'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title'     => $i18n->l( 'Insert value for No Cert required (Role User)', 'wbfsys.role_user.label' ),
        )
      );
      $inputNonCertLogin->setWidth( 'medium' );

      $inputNonCertLogin->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'non_cert_login' ) );
      $inputNonCertLogin->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'non_cert_login' ) );
      $inputNonCertLogin->setActive( $this->entity->getBoolean( 'non_cert_login' ) );
      $inputNonCertLogin->setLabel( $i18n->l( 'No Cert required', 'wbfsys.role_user.label' ) );

      $inputNonCertLogin->refresh           = $this->refresh;
      $inputNonCertLogin->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Default' ,
        true
      );


  }//end public function input_MyProfile_NonCertLogin */

 /**
  * create the ui element for field description
  * @param TFlag $params named parameters
  * @return void
  */
  public function input_MyProfile_Description( $params )
  {
    $i18n     = $this->view->i18n;

      //p: textarea
      $inputDescription = $this->view->newInput( 'inputWbfsysRoleUserDescription', 'Textarea' );
      $this->items['my_profile-description'] = $inputDescription;
      $inputDescription->addAttributes
      (
        array
        (
          'name'  => 'wbfsys_role_user[description]',
          'id'    => 'wgt-input-my_profile_description'.($this->suffix?'-'.$this->suffix:''),
          'class'     => 'wcm wcm_ui_tip large medium-height'.($this->assignedForm?' asgd-'.$this->assignedForm:''),
          'title' => $i18n->l( 'Insert value for Description (Role User)', 'wbfsys.role_user.label' ),
        )
      );
      $inputDescription->setWidth( 'large' );


      $inputDescription->setReadonly( $this->fieldReadOnly( 'wbfsys_role_user', 'description' ) );
      $inputDescription->setRequired( $this->fieldRequired( 'wbfsys_role_user', 'description' ) );

      $inputDescription->setData( $this->entity->getSecure( 'description' ) );
      $inputDescription->setLabel( $i18n->l( 'Description', 'wbfsys.role_user.label' ) );

      $inputDescription->refresh           = $this->refresh;
      $inputDescription->serializeElement  = $this->sendElement;

      // activate the category
      $this->view->addVar
      (
        'showCat'.$this->namespace.'_Description' ,
        true
      );


  }//end public function input_MyProfile_Description */

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
      $orm->getValidationData( 'WbfsysRoleUser', array_keys( $this->fields['wbfsys_role_user']), true ),
      $orm->getErrorMessages( 'WbfsysRoleUser' ),
      'wbfsys_role_user'
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
      
    // Extrahieren der Daten für die embed_person Referenz
    $filterEmbedPerson = $request->checkFormInput
    (
      $orm->getValidationData( 'CorePerson', array_keys( $this->fields['embed_person']), true ),
      $orm->getErrorMessages( 'CorePerson' ),
      'embed_person'
    );
    
    $tmpEmbedPerson  = $filterEmbedPerson->getData();
    $dataEmbedPerson = array();
    
    // es werden nur daten gesetzt die tatsächlich übergeben wurden, sonst
    // würden default werte in den entities überschrieben werden
    foreach( $tmpEmbedPerson as $key => $value   )
    {
      if (!is_null( $value ) )
        $dataEmbedPerson[$key] = $value;
    }

    $this->entityEmbedPerson->addData( $dataEmbedPerson );
      
    // Extrahieren der Daten für die embed_enterprise_employee Referenz
    $filterEmbedEnterpriseEmployee = $request->checkFormInput
    (
      $orm->getValidationData( 'EnterpriseEmployee', array_keys( $this->fields['embed_enterprise_employee']), true ),
      $orm->getErrorMessages( 'EnterpriseEmployee' ),
      'embed_enterprise_employee'
    );
    
    $tmpEmbedEnterpriseEmployee  = $filterEmbedEnterpriseEmployee->getData();
    $dataEmbedEnterpriseEmployee = array();
    
    // es werden nur daten gesetzt die tatsächlich übergeben wurden, sonst
    // würden default werte in den entities überschrieben werden
    foreach( $tmpEmbedEnterpriseEmployee as $key => $value   )
    {
      if (!is_null( $value ) )
        $dataEmbedEnterpriseEmployee[$key] = $value;
    }

    $this->entityEmbedEnterpriseEmployee->addData( $dataEmbedEnterpriseEmployee );


  }//end public function fetchDefaultData */


}//end class WbfsysRoleUser_Crud_Create_Form */


