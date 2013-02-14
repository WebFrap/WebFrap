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
class WebfrapEditor_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var array
   */
  protected $options           = array
  (
    'workspace' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab' )
    ),
  );

/*//////////////////////////////////////////////////////////////////////////////
// Base Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_workspace( $request, $response )
  {

    /* @var $view WebfrapEditor_Workspace_Maintab_View  */
    $view = $response->loadView
    ( 
    	'webfrap-editor-workspace', 
    	'WebfrapEditor_Workspace', 
    	'displayWorkspace'
    );
    
    /* @var $model WebfrapEditor_Workspace_Model */
    $model = $this->loadModel( 'WebfrapEditor_Workspace' );

    $view->setModel( $model );
    $view->displayWorkspace(  );
    

  }//end public function service_workspace */



} // end class WebfrapStats_Controller


