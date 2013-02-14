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
class MaintenanceDbConsistency_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @return void
   */
  public function service_table( $request, $response )
  {
    
    $params = $this->getFlags( $request );
    
    $view   = $response->loadView( 'maintenance-db-consistency' , 'MaintenanceDbConsistency' );

    
    $view->display( $params );
    
  }//end public function service_table */
  
  /**
   * @return void
   */
  public function service_fix( $request, $response )
  {

    $extensionLoader = new ExtensionLoader( 'fix_db' );
    //$protocol = new TProtocol();
    
    foreach( $extensionLoader as $extension )
    {
      if( Webfrap::classLoadable( $extension ) )
      {
        $ext = new $extension( $this );
        try
        {
          $ext->run();
        }
        catch( Exception $e )
        {
          $response->addError( $e->getMessage() );
        }
      }
    }
    
  }//end public function service_fix */
  
  /**
   * @return void
   */
  public function service_fixAll( $request, $response )
  {
  
    $extensionLoader = new ExtensionLoader( 'fix_db' );
    //$protocol = new TProtocol();
  
    foreach( $extensionLoader as $extension )
    {
      if( Webfrap::classLoadable( $extension ) )
      {
        $ext = new $extension( $this );
        try
        {
          $ext->run();
        }
        catch( Exception $e )
        {
          $response->addError( $e->getMessage() );
        }
      }
    }
    
    $response->addMessage( "Sucessfully executed all fixes" );
  
  }//end public function service_fixAll */


}//end class MaintenanceDbConsistency_Controller

