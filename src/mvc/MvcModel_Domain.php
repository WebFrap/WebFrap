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
 * 
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class MvcModel_Domain
  extends MvcModel
{
  
  /**
   * The actual domain node
   * 
   * @var DomainNode
   */
  public $domainNode = null;
  
  
  /**
   * @param Base $env
   */
  public function __construct(  $domainNode = null, $env = null )
  {
    
    if( $domainNode )
      $this->domainNode = $domainNode;

    if( !$env )
      $env = Webfrap::getActive();
    
    $this->env = $env;

    $this->getRegistry();

    if( DEBUG )
      Debug::console( 'Load model '.get_class( $this ) );

  }//end public function __construct */


} // end abstract class MvcModel_Domain

