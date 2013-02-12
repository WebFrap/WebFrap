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
 * @subpackage ModDeveloper
 */
class DeveloperSearch_Controller
  extends Controller
{

  /**
   * Enter description here ...
   * @var array
   */
  protected $callAble = array
  (
    'form','search'
  );

////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function form( )
  {

    if( $this->tplEngine->isType( View::WINDOW ) )
    {
      $view = $this->tplEngine->newWindow('DeveloperSearch', 'Default');
    }
    else
    {
      $view = $this->tplEngine;
    }

    $model = $this->loadModel('DeveloperSearch');
    $view->setModel( $model );

    $view->setTitle('Search Form');
    $view->setTemplate( 'daidalos/search_form' );

  } // end public function form

  /**
   *
   */
  public function search()
  {

    $httpRequest  = $this->getRequest();
    $view         = $this->tplEngine->newSubView('table_searchresult');

    $view->setPosition( '#search_results' );
    $view->setTemplate( 'daidalos/search_result' );

    $model = $this->loadModel('DeveloperSearch');

    $pattern = $httpRequest->data( 'keyword', Validator::TEXT );
    $endings = $httpRequest->data( 'endings', Validator::TEXT );
    $projects = $httpRequest->data( 'projects', Validator::TEXT );


    $seachFolders = array();

    if( $projects )
    {
      foreach ( $projects as $project )
      {
        $seachFolders[] = PATH_ROOT.'/'.$project.'/';
      }

      $model->search( $seachFolders, $pattern, $endings );

    }
    else
    {
      $model->search( PATH_GW, $pattern, $endings );
    }


    $view->setModel( $model );

  }//end public function search */


} // end class ControllerDeveloperSearch

