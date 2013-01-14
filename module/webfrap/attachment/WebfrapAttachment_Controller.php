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
 * @subpackage core_item\attachment
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapAttachment_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var array
   */
  protected $options           = array
  (
    'search' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
    'disconnect' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'delete' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
    'formuploadfiles' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'uploadfile' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'savefile' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'formaddlink' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'addlink' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'savelink' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'edit' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'formaddstorage' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'addstorage' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax' )
    ),
    'editstorage' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'savestorage' => array
    (
      'method'    => array( 'PUT' ),
      'views'      => array( 'ajax' )
    ),
    'deletestorage' => array
    (
      'method'    => array( 'DELETE' ),
      'views'      => array( 'ajax' )
    ),
  );

////////////////////////////////////////////////////////////////////////////////
// Base Methodes
////////////////////////////////////////////////////////////////////////////////
  
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_delete( $request, $response )
  {
    
    
    $context = new WebfrapAttachment_Context( $request );

    $id       = $request->param( 'objid', Validator::EID );

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    $model->deleteFile( $id );
    
    /* @var $view WebfrapAttachment_Ajax_View  */
    $view = $response->loadView
    ( 
    	'upload-form', 
    	'WebfrapAttachment', 
    	'renderRemoveEntry'
    );
    $view->setModel( $model );
    
    $view->renderRemoveEntry( $id, $context );

  }//end public function service_delete */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_disconnect( $request, $response )
  {
    
    $context = new WebfrapAttachment_Context( $request );

    $id   = $request->param( 'objid', Validator::EID );
    
    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    $model->disconnect( $id );

  }//end public function service_disconnect */


  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_search( $request, $response )
  {

    $context = new WebfrapAttachment_Context( $request );
    

    $searchKey = $request->param( 'skey', Validator::SEARCH );

    
    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    $searchData  = $model->getAttachmentList( $context->refId, null, $searchKey ); 
    
    /* @var $view WebfrapAttachment_Ajax_View */
    $view = $response->loadView
    ( 
    	'search-form', 
    	'WebfrapAttachment', 
    	'renderSearch'
    );
    $view->setModel( $model );
    
    $view->renderSearch(  $context, $searchData );

  }//end public function service_search */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formUploadFiles( $request, $response )
  {
    
    $context = new WebfrapAttachment_Context( $request );

    
    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    /* @var $view WebfrapAttachment_File_Modal_View */
    $view = $response->loadView
    ( 
    	'upload-form', 
    	'WebfrapAttachment_File', 
    	'displayForm',
      View::MODAL
    );
    $view->setModel( $model );
    
    $view->displayForm( $context );
    

  }//end public function service_formUploadFiles */
  
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_uploadFile( $request, $response )
  {
    
    $context = new WebfrapAttachment_Context( $request );
    
    // refid

    
    $file = $request->file( 'file' );
    
    if( !$file || !is_object($file) )
    {
      throw new InvalidRequest_Exception
      ( 
        Error::INVALID_REQUEST,
        Error::INVALID_REQUEST_MSG
      );
    }
    
    $type = $request->data( 'type', Validator::EID );
    $versioning   = $request->data( 'version', Validator::BOOLEAN );
    $description  = $request->data( 'description', Validator::TEXT );
    $confidentiality   = $request->data( 'id_confidentiality', Validator::EID );

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    $attachNode = $model->uploadFile( $context->refId, $file, $type, $versioning, $confidentiality, $description );
    $entryData  = $model->getAttachmentList( $context->refId, $attachNode->getId() ); 
    
    /* @var $view WebfrapAttachment_Ajax_View  */
    $view = $response->loadView
    ( 
    	'upload-form', 
    	'WebfrapAttachment', 
    	'renderAddEntry'
    );
    $view->setModel( $model );
    
    $view->renderAddEntry(  $context, $entryData );
    

  }//end public function service_uploadFile */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_saveFile( $request, $response )
  {
    
    $context = new WebfrapAttachment_Context( $request );
    
    // refid
    $attachId  = $request->param( 'attachid', Validator::EID );
    
    $file = $request->file( 'file' );

    $objid = $request->data( 'objid', Validator::EID );
    $type = $request->data( 'type', Validator::EID );
    $versioning   = $request->data( 'version', Validator::BOOLEAN );
    $description  = $request->data( 'description', Validator::TEXT );
    $confidentiality   = $request->data( 'id_confidentiality', Validator::EID );

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    $model->saveFile( $objid, $file, $type, $versioning, $confidentiality, $description );
    $entryData  = $model->getAttachmentList( null, $attachId ); 
    
    $view = $response->loadView
    ( 
    	'upload-form', 
    	'WebfrapAttachment', 
    	'renderUpdateEntry'
    );
    $view->setModel( $model );
    
    
    if( $entryData )
      $view->renderUpdateEntry( $objid, $context->element, $entryData );
    

  }//end public function service_saveFile */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formAddLink( $request, $response )
  {
    
    $context = new WebfrapAttachment_Context( $request );

    
    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    /* @var $view WebfrapAttachment_Link_Modal_View  */
    $view = $response->loadView
    ( 
    	'upload-form', 
    	'WebfrapAttachment_Link', 
    	'displayForm',
      View::MODAL
    );
    $view->setModel( $model );
   
    
    $view->displayForm( $context );
    

  }//end public function service_formAddLink */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_addLink( $request, $response )
  {
    
    $context = new WebfrapAttachment_Context( $request );
    
    // refid
    $refId   = $request->param( 'refid', Validator::EID );
    $elementId = $request->param( 'element', Validator::CKEY );
    $refMask  = $request->param( 'ref_mask', Validator::CKEY );
    $refField  = $request->param( 'ref_field', Validator::CKEY );
    
    $maskFiler = $request->param( 'mask_filter', Validator::CKEY );
    $typeFilter= $request->param( 'type_filter', Validator::CKEY );
    
    $link = $request->data( 'link', Validator::LINK );
    $type = $request->data( 'id_type', Validator::EID );
    $storage     = $request->data( 'id_storage', Validator::EID );
    $description = $request->data( 'description', Validator::TEXT );
    $confidentiality   = $request->data( 'id_confidentiality', Validator::EID );

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    $attachNode = $model->addLink( $refId, $link, $type, $storage, $confidentiality, $description );
    $entryData  = $model->getAttachmentList( $refId, $attachNode->getId() ); 
    
    $view = $response->loadView
    ( 
    	'upload-form', 
    	'WebfrapAttachment', 
    	'renderAddEntry'
    );
    $view->setModel( $model );
    
    $view->renderAddEntry(  $refId, $elementId, $entryData );
    

  }//end public function service_addLink */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_saveLink( $request, $response )
  {
    
    $context = new WebfrapAttachment_Context( $request );
    
    // refid
    $refId     = $request->param( 'refid', Validator::EID );
    $attachId  = $request->param( 'attachid', Validator::EID );
    $elementId   = $request->param( 'element', Validator::CKEY );
    $refMask  = $request->param( 'ref_mask', Validator::CKEY );
    $refField  = $request->param( 'ref_field', Validator::CKEY );
    
    $maskFiler = $request->param( 'mask_filter', Validator::CKEY );
    $typeFilter= $request->param( 'type_filter', Validator::CKEY );
    
    $objid = $request->data( 'objid', Validator::EID );
    $link = $request->data( 'link', Validator::LINK );
    $type = $request->data( 'id_type', Validator::EID );
    $storage     = $request->data( 'id_storage', Validator::EID );
    $description = $request->data( 'description', Validator::TEXT );
    $confidentiality   = $request->data( 'id_confidentiality', Validator::EID );

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    $model->saveLink( $objid, $link, $type, $storage, $confidentiality, $description );
    $entryData  = $model->getAttachmentList( null, $attachId ); 
    
    $view = $response->loadView
    ( 
    	'upload-form', 
    	'WebfrapAttachment', 
    	'renderUpdateEntry'
    );
    $view->setModel( $model );
    
    $view->renderUpdateEntry( $refId, $elementId, $entryData );
    

  }//end public function service_saveLink */

  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_edit( $request, $response )
  {
    
    $context = new WebfrapAttachment_Context( $request );

    $objid   = $request->param( 'objid', Validator::EID );
    $elementId = $request->param( 'element', Validator::CKEY );
    $refId   = $request->param( 'refid', Validator::EID );
    $refMask  = $request->param( 'ref_mask', Validator::CKEY );
    $refField  = $request->param( 'ref_field', Validator::CKEY );
    
    $maskFiler = $request->param( 'mask_filter', Validator::CKEY );
    $typeFilter= $request->param( 'type_filter', Validator::CKEY );
    
    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel('WebfrapAttachment');
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    $fileNode = $model->loadFile( $objid );
    
    if( $fileNode->link )
    {
      $view = $response->loadView
      ( 
      	'upload-edit-form', 
      	'WebfrapAttachment_Link', 
      	'displayEdit',
        View::MODAL
      );
    }
    else 
    {
      $view = $response->loadView
      ( 
      	'upload-edit-form', 
      	'WebfrapAttachment_File', 
      	'displayEdit',
        View::MODAL
      );
    }
    $view->setModel( $model );
    
    
    $view->displayEdit( $objid, $refId, $fileNode, $elementId );
    

  }//end public function service_edit */
  
////////////////////////////////////////////////////////////////////////////////
// Storage
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_deleteStorage( $request, $response )
  {
    
    $context = new WebfrapAttachment_Context( $request );

    $id       = $request->param( 'objid', Validator::EID );
    $elementId  = $request->param( 'element', Validator::CKEY );
    $refId  = $request->param( 'refid', Validator::EID );
    $refMask  = $request->param( 'ref_mask', Validator::CKEY );
    $refField  = $request->param( 'ref_field', Validator::CKEY );
    
    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->setProperties( $context  );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    $model->deleteStorage( $id );
    
    /* @var $view WebfrapAttachment_Ajax_View  */
    $view = $response->loadView
    ( 
    	'upload-form', 
    	'WebfrapAttachment', 
    	'renderRemoveStorageEntry'
    );
    $view->setModel( $model );
    
    $view->renderRemoveStorageEntry(  $id, $elementId );

  }//end public function service_deleteStorage */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_formAddStorage( $request, $response )
  {
    
    $context = new WebfrapAttachment_Context( $request );

    $refId   = $request->param( 'refid', Validator::EID );
    $elementId = $request->param( 'element', Validator::CKEY );
    $refMask  = $request->param( 'ref_mask', Validator::CKEY );
    $refField  = $request->param( 'ref_field', Validator::CKEY );
    
    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    /* @var $view WebfrapAttachment_Link_Modal_View  */
    $view = $response->loadView
    ( 
    	'upload-form', 
    	'WebfrapAttachment_Storage', 
    	'displayForm',
      View::MODAL
    );
    $view->setModel( $model );
    
    $view->displayForm( $elementId );
    

  }//end public function service_formAddStorage */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_addStorage( $request, $response )
  {
    
    $context = new WebfrapAttachment_Context( $request );
    
    // refid
    $refId   = $request->param( 'refid', Validator::EID );
    $elementId = $request->param( 'element', Validator::CKEY );
    $refMask  = $request->param( 'ref_mask', Validator::CKEY );
    $refField  = $request->param( 'ref_field', Validator::CKEY );
    
    $name = $request->data( 'name', Validator::TEXT );
    $link = $request->data( 'link', Validator::LINK );
    $type = $request->data( 'id_type', Validator::EID );
    $description = $request->data( 'description', Validator::TEXT );
    $confidentiality   = $request->data( 'id_confidentiality', Validator::EID );

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    $storageNode = $model->addStorage( $refId, $name, $link, $type, $confidentiality, $description );
    $entryData   = $model->getStorageList( null, $storageNode->getId() ); 
    
    $view = $response->loadView
    ( 
    	'form-add-storage', 
    	'WebfrapAttachment', 
    	'renderAddStorageEntry'
    );
    $view->setModel( $model );
    
    $view->renderAddStorageEntry(  $refId, $elementId, $entryData );
    

  }//end public function service_addStorage */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_editStorage( $request, $response )
  {
    
    $context = new WebfrapAttachment_Context( $request );

    $objid   = $request->param( 'objid', Validator::EID );
    $refId   = $request->param( 'refid', Validator::EID );
    $elementId = $request->param( 'element', Validator::CKEY );
    $refMask  = $request->param( 'ref_mask', Validator::CKEY );
    $refField  = $request->param( 'ref_field', Validator::CKEY );
    
    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel('WebfrapAttachment');
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    $storageNode = $model->loadStorage( $objid );
    
    $view = $response->loadView
    ( 
    	'upload-edit-form', 
    	'WebfrapAttachment_Storage', 
    	'displayEdit',
      View::MODAL
    );
    $view->setModel( $model );
    
    $view->displayEdit( $storageNode, $elementId );
    
  }//end public function service_editStorage */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_saveStorage( $request, $response )
  {
    
    $context = new WebfrapAttachment_Context( $request );
    
    // refid
    $refId   = $request->param( 'refid', Validator::EID );
    $elementId = $request->param( 'element', Validator::CKEY );
    $refMask  = $request->param( 'ref_mask', Validator::CKEY );
    $refField  = $request->param( 'ref_field', Validator::CKEY );
    
    $objid = $request->data( 'objid', Validator::EID );
    $name = $request->data( 'name', Validator::TEXT );
    $link = $request->data( 'link', Validator::LINK );
    $type = $request->data( 'id_type', Validator::EID );
    $description = $request->data( 'description', Validator::TEXT );
    $confidentiality   = $request->data( 'id_confidentiality', Validator::EID );

    /* @var $model WebfrapAttachment_Model */
    $model = $this->loadModel( 'WebfrapAttachment' );
    $model->setProperties( $context );
    $model->loadAccessContainer( $context );
    
    if( !$model->access->update )
    {
      throw new PermissionDenied_Exception();
    }
    
    $model->saveStorage( $objid, $name, $link, $type, $confidentiality, $description );
    $entryData  = $model->getStorageList( null, $objid ); 
    
    $view = $response->loadView
    ( 
    	'form-save-storage', 
    	'WebfrapAttachment', 
    	'renderUpdateStorageEntry'
    );
    $view->setModel( $model );
    
    $view->renderUpdateStorageEntry( $refId, $objid, $elementId, $entryData );
    
  }//end public function service_saveStorage */

  
} // end class WebfrapAttachment_Controller


