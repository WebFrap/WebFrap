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
class WebfrapStatsUsage_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var array
   */
  protected $options           = array
  (
    'show' => array
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
  public function service_show($request, $response )
  {

    /* @var $view WebfrapStatsUsage_Maintab_View  */
    $view = $this->loadView
    ( 
      'stats-usage-page', 
      'WebfrapStatsUsage', 
      'displayStats'
    );
    
    /* @var $model WebfrapStatsUsage_Model */
    $model = $this->loadModel( 'WebfrapStatsUsage' );

    $view->setModel($model );
    $view->displayStats();
    

  }//end public function service_show */



} // end class WebfrapStats_Controller


