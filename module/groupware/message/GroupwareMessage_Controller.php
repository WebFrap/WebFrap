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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class GroupwareMessage_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var array
   */
  protected $options           = array
  (
    'openarea' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'modal' )
    ),
    'messagelist' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
    'searchlist' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax' )
    ),
  );
  
////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////
    
 /**
  * create an new window with an edit form for the enterprise_company entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_openArea( $request, $response )
  {
    
    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags( $request );

    // create a window
    $view   = $response->loadView
    (
      'list-groupware-messages',
      'GroupwareMessage',
      'displayOpen',
      View::AJAX
    );
    $view->setModel( $this->loadModel( 'GroupwareMessage' ) );

   $view->displayOpen( $domainNode, $params );

  }//end public function service_showMeta */

 /**
  * create an new window with an edit form for the enterprise_company entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_messageList( $request, $response )
  {
    
    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags( $request );
    
    $model = $this->loadModel( 'GroupwareMessage' );
    $model->loadTableAccess( $params );
    
    if( !$model->access->listing )
    {
      throw new InvalidRequest_Exception
      (
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }
    
    // create a window
    $view   = $response->loadView
    (
      'list-groupware-message_list',
      'GroupwareMessage_List',
      'displayList',
      View::MAINTAB
    );
    $view->setModel( $this->loadModel( 'GroupwareMessage' ) );
    
    $view->displayList( $params );

  }//end public function service_messageList */

 /**
  * create an new window with an edit form for the enterprise_company entity
  * @param LibRequestHttp $request
  * @param LibResponseHttp $response
  * @return boolean
  */
  public function service_searchList( $request, $response )
  {
    
    // prüfen ob irgendwelche steuerflags übergeben wurde
    $params  = $this->getFlags( $request );
    
    $model = $this->loadModel( 'GroupwareMessage' );
    $model->loadTableAccess( $params );
    
    if( !$model->access->listing )
    {
      throw new InvalidRequest_Exception
      (
        Response::FORBIDDEN_MSG,
        Response::FORBIDDEN
      );
    }
    
    // create a window
    $view   = $response->loadView
    (
      'list-groupware-message_list',
      'GroupwareMessage_List',
      'displaySearch',
      View::AJAX
    );
    $view->setModel( $this->loadModel( 'GroupwareMessage' ) );
    
    $view->displaySearch( $params );

  }//end public function service_searchList */

} // end class MaintenanceEntity_Controller
