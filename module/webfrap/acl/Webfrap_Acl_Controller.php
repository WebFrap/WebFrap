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
class Webfrap_Acl_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Listing Interface
////////////////////////////////////////////////////////////////////////////////

  /**
   * the default table for the management ProjectAlias
   * @param TFlowFlag $params named parameters
   * @return boolean
   */
  public function listing( $params = null )
  {

    // check if the user may edit entrys
    if( !$this->acl->access( array('project/alias:admin') ) )
    {
      $this->accessDenied();
      return false;
    }

    // load request parameters an interpret as flags
    $params  = $this->getListingFlags( $params );

    if( !$view = $response->loadView( 'project_alias_acl_listing', 'ProjectAlias_Acl' ) )
    {
      $this->invalidRequest();
      return false;
    }

    $view->setModel( $this->loadModel('ProjectAlias_Acl') );

    return $view->display( $params );

  }//end public function listing */


  /**
   * the search method for the main table
   * this method is called for paging and search requests
   * it's not recommended to use another method than this for paging, cause
   * this method makes shure that you can page between the search results
   * and do not loose your filters in paging
   *
   * @param TFlowFlag $params named parameters
   * @return boolean
   */
  public function search( $params = null )
  {

    // check the access type
    if(!$this->checkAccessType( View::AJAX ))
      return false;

    // check if the user may edit entrys
    if( !$this->acl->access( array('project/alias:admin') ) )
    {
      $this->accessDenied();
      return false;
    }

    $areaId = $this->request->param('area_id',Validator::TEXT);

    // load the flow flags
    $params       = $this->getListingFlags( $params );
    $params->ajax = true;

    // load the default model
    $model   = $this->loadModel( 'ProjectAlias_Acl' );

    // this can only be an ajax request, so we can directly load the ajax view
    $view = $this->tplEngine->loadView('ProjectAlias_Acl_Ajax');

    $view->setModel( $model );
    $view->displaySearch( $areaId, $params );

    return true;

  }//end public function search */
////////////////////////////////////////////////////////////////////////////////
// Crud Interface
////////////////////////////////////////////////////////////////////////////////

  /**
   * the default table for the management ProjectAlias
   * @param TFlowFlag $params named parameters
   * @return boolean
   */
  public function loadGroups( $params = null )
  {

    // check if the user may edit entrys
    if( !$this->acl->access( array('project/alias:admin') ) )
    {
      $this->accessDenied();
      return false;
    }


    // load request parameters an interpret as flags
    $params = $this->getListingFlags( $params );

    $view   = $this->tplEngine->loadView('ProjectAlias_Acl_Ajax');
    $view->setModel( $this->loadModel('ProjectAlias_Acl') );

    $searchKey = $this->request->param('key',Validator::TEXT);
    $areaId = $this->request->param('area_id',Validator::TEXT);

    return $view->displayAutocomplete( $areaId, $searchKey, $params );

  }//end public function loadGroups */

  /**
   * the default table for the management ProjectAlias
   * @param TFlowFlag $params named parameters
   * @return boolean
   */
  public function appendGroup( $params = null )
  {

    // check if the user may edit entrys
    if( !$this->acl->access( array('project/alias:admin') ) )
    {
      $this->accessDenied();
      return false;
    }

    // load request parameters an interpret as flags
    $params = $this->getListingFlags( $params );

    $view   = $this->tplEngine->loadView('ProjectAlias_Acl_Ajax');

    $model = $this->loadModel('ProjectAlias_Acl');
    $view->setModel( $model );

    // fetch the data from the http request and load it in the model registry
    // if fails stop here
    if(!$model->fetchConnectData( $this->tplEngine, $params ))
    {
      return false;
    }

    if(!$model->connect( $this->tplEngine, $params ))
    {
      return false;
    }

    return $view->displayConnect( $params );

  }//end public function buildMethodAppendGroup */

 /**
  * update a single entity and all rerferencing datasets
  * @param TFlowFlag $params named parameters
  * @return boolean
  */
  public function updateArea( $params = null )
  {

    // check if the request method is POST or PUT
    // post is required, else it would not be possible to Upload files
    // cause http browsers only know GET and POST for forms
    if( !( $this->request->method('POST') || $this->request->method('PUT') ) )
    {
      $this->invalidRequest
      (
        $this->tplEngine->i18n->l
        (
          'Invalid request method for: , must be PUT or POST',
          'wbf.messages.InvalidRequestPost'
        )
      );
      return false;
    }

    // check the access type
    if(!$this->checkAccessType( View::AJAX ))
      return false;

    // check if the user may edit entrys
    if( !$this->acl->access( array('security_area:edit') ) )
    {
      $this->accessDenied();
      return false;
    }

    // check if there is a valid id for update
    if( !$id = $this->getOID('wbfsys_security_area') )
    {
      $this->invalidRequest('Missing resource ID');
      return false;
    }

    // interpret the parameters from the request
    $params = $this->getCrudFlags( $params );

    // if there is no given window id we close the expected default window
    if(!$params->windowId)
      $params->windowId = 'form-project_alias-acl-'.$id;

    $model = $this->loadModel('ProjectAlias_Acl');

    // fetch the data from the http request and load it in the model registry
    // if fails stop here
    if(!$model->fetchUpdateData( $this->tplEngine, $id, $params ))
    {
      return false;
    }

    // when we are here the data must be valid ( if not your meta model is broken! )
    // try to update
    if( !$model->update( $this->tplEngine, $params ) )
    {
      // update failed :-(
      return false;
    }

    if( $subRequestAccess = $this->request->getSubRequest('ar') )
    {
      $modelMultiAccess = $this->loadModel('ProjectAlias_Acl_Multi');
      $modelMultiAccess->setRequest( $subRequestAccess );
      $modelMultiAccess->fetchUpdateData( $this->tplEngine, $params );
      $modelMultiAccess->update( $this->tplEngine, $params  );
    }

    // if this point is reached everything is fine
    return true;

  }//end public function updateArea */

////////////////////////////////////////////////////////////////////////////////
// parse flags
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param TFlowFlag $flowFlags
   * @return TFlowFlag
   */
  protected function getListingFlags( $flowFlags = null )
  {

    if( !$flowFlags )
      $flowFlags = new TFlowFlag();

    // the publish type, like selectbox, tree, table..
    if( $publish  = $this->request->get( 'publish', Validator::CNAME ) )
      $flowFlags->publish   = $publish;

    // listing type
    if( $ltype   = $this->request->get( 'ltype', Validator::CNAME ) )
      $flowFlags->ltype    = $ltype;

    // input type
    if( $input = $this->request->get( 'input', Validator::CKEY ) )
      $flowFlags->input    = $input;

    // input type
    if( $suffix = $this->request->get( 'suffix', Validator::CKEY ) )
      $flowFlags->suffix    = $suffix;


    // per default
    $flowFlags->categories = array();

    if( 'selectbox' === $flowFlags->publish )
    {

      // fieldname of the calling selectbox
      $flowFlags->field
        = $this->request->get( 'field', Validator::CNAME );

      // html id of the calling selectbox
      $flowFlags->inputId
        = $this->request->get( 'input_id', Validator::CKEY );

      // html id of the table
      $flowFlags->targetId
        = $this->request->get( 'target_id', Validator::CKEY );

      // html id of the calling selectbox
      $flowFlags->target
        = str_replace('_','.',$this->request->get('target',Validator::CKEY ));

    }
    else
    {

      // start position of the query and size of the table
      $flowFlags->start
        = $this->request->get('start', Validator::INT );

      // stepsite for query (limit) and the table
      if( !$flowFlags->qsize = $this->request->get('qsize', Validator::INT ) )
        $flowFlags->qsize = Wgt::$defListSize;

      // order for the multi display element
      $flowFlags->order
        = $this->request->get('order', Validator::CNAME );

      // target for a callback function
      $flowFlags->target
        = $this->request->get('target', Validator::CKEY  );

      // target for some ui element
      $flowFlags->targetId
        = $this->request->get('target_id', Validator::CKEY  );

      // flag for beginning seach filter
      if( $text = $this->request->get('begin', Validator::TEXT  ) )
      {
        // whatever is comming... take the first char
        $flowFlags->begin = $text[0];
      }

      // the model should add all inputs in the ajax request, not just the text
      // converts per default to false, thats ok here
      $flowFlags->fullLoad
        = $this->request->get('full_load', Validator::BOOLEAN );

      // exclude whatever
      $flowFlags->exclude
        = $this->request->get('exclude', Validator::CKEY  );

      // keyname to tageting ui elements
      $flowFlags->keyName
        = $this->request->get('key_name', Validator::CKEY  );

      // the activ id, mostly needed in exlude calls
      $flowFlags->objid
        = $this->request->get('objid', Validator::EID  );

    }

    return $flowFlags;

  }//end protected function getListingFlags */

  /**
   * @param TFlowFlag $flowFlags
   * @return TFlowFlag
   */
  protected function getCrudFlags( $flowFlags = null )
  {

    // create named parameters object
    if( !$flowFlags )
      $flowFlags = new TFlowFlag();

    // the publish type, like selectbox, tree, table..
    if( $publish  = $this->request->get( 'publish', Validator::CNAME ) )
      $flowFlags->publish   = $publish;

    // listing type
    if( $ltype   = $this->request->get( 'ltype', Validator::CNAME ) )
      $flowFlags->ltype    = $ltype;

    // context
    if( $context   = $this->request->get( 'context', Validator::CNAME ) )
      $flowFlags->context    = $context;

    // if of the target element, can be a table, a tree or whatever
    if( $targetId = $this->request->get( 'target_id', Validator::CKEY ) )
      $flowFlags->targetId  = $targetId;


    // callback for a target function in thr browser
    if( $target   = $this->request->get( 'target', Validator::CNAME ) )
      $flowFlags->target    = $target;

    // mask key
    if( $mask = $this->request->get( 'mask', Validator::CNAME ) )
      $flowFlags->mask  = $mask;

    // mask key
    if( $viewType = $this->request->get( 'view', Validator::CNAME ) )
      $flowFlags->viewType  = $viewType;

    // mask key
    if( $viewId = $this->request->get( 'view_id', Validator::CKEY ) )
      $flowFlags->viewId  = $viewId;

    // refid
    if( $refid = $this->request->get( 'refid', Validator::INT ) )
      $flowFlags->refId  = $refid;


    // per default
    $flowFlags->categories = array();

    return $flowFlags;

  }//end protected function getCrudFlags */

} // end class WebFrap_Acl_Controller */

