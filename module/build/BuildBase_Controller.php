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
 * @subpackage Build
 */
class BuildBase_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var unknown_type
   */
  protected $callAble = array
  (
    'table',
    'build',
  );

  /**
   * ignore accesslist everything is free accessable
   * @var boolean
   */
  protected $fullAccess = true;

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function table()
  {

    $view = $this->getView();

    $view->setTemplate( 'simple/table' );
    $table = $view->newItem( 'table' , 'TableBuild' );

  }//end public function table */

  /**
   * @return boolean
   */
  public function build()
  {

    $view         = $this->getView();
    $httpRequest  = $this->getRequest();

    if( !$key = $httpRequest->get( 'objid' , 'cname' ) )
    {
      Message::addError('Invalid Request');
      return false;
    }

    if( !$buildFile = $this->model->getBuildFile( $key ) )
    {
      Message::addError('Requested ');
      return false;
    }

    $builder = new LibBuild( $buildFile );

    if( $builder->build() )
    {
      Message::addMessage( 'Successfully build '.$key.'.' );
    }
    else
    {
      Message::addError( 'Build '.$key.' failed.' );
    }

  }//end public function build */


} // end class BuildBase_Controller

