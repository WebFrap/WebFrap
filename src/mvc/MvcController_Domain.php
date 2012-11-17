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
 * @subpackage tech_core
 */
abstract class MvcController_Domain 
  extends MvcController
{

  /**
   * Get the node with the domai information
   * if missing we can asume the request was invlid
   * 
   * @param LibRequestHttp $request
   * @throws InvalidRequest_Exception
   * @return DomainNode 
   */
  protected function getDomainNode( $request )
  {
    
    $domainKey   = $request->param( 'dkey', Validator::CKEY );
    if( !$domainKey )
    {
      throw new InvalidRequest_Exception
      (
        'Missing Domain Parameter',
        Response::BAD_REQUEST
      );
    }
    
    $domainNode  = DomainNode::getNode( $domainKey );
    
    if( !$domainNode )
    {
      throw new InvalidRequest_Exception
      (
        'The requestes Metadate not exists',
        Response::NOT_FOUND
      );
    }
    
    return $domainNode;
    
  }//end protected function getDomainNode */
  
  
  /**
   * Load a DomainNode Model
   *
   * @param string $domainNode
   * @param string $modelKey
   * @param string $key
   *
   * @return MvcModel_Domain
   * @throws Mvc_Exception is thrown when the requested model not exosts
   */
  public function loadDomainModel( $domainNode, $modelKey, $key = null )
  {
    
    $model = $this->loadModel( $modelKey, $key );
    $model->domainNode = $domainNode;

    return $model;
    
  }//end public function loadDomainModel */
  
} // end abstract class MvcController_Domain

