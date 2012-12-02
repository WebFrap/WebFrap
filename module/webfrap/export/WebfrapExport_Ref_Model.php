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
 * @subpackage Export
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapExport_Ref_Model
  extends MvcModel_Domain
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param DomainSimpleSubNode $variant
   * @param Context $context
   * @param DomainSimpleSubNode $refNode
   * @return LibAclPermission
   */
  public function injectAccessContainer( $variant, $context, $refNode, $refId )
  {
    
    $user      = $this->getUser();
    
    $classKey  = $this->domainNode->domainKey.'_Ref_'.$refNode->mask.'_'.$variant->mask;
    $className = $classKey.'_Access';
    
    // if the requested access container not exists, we can assume this request
    // was invalid
    if( !Webfrap::classLoadable( $className ) )
      throw new ServiceNotExists_Exception( $classKey );

    $access = new $className( null, null, $this );
    $access->load( $user->getProfileName(), $context );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->listing )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission to export from {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l( $domainNode->label, $domainNode->domainI18n.'.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $context->access = $access;
    
  }//end public function injectAccessContainer */
  
  /**
   * @param int $refId
   * @param LibAclPermission $access
   * @param string $context
   */
  public function search( $refId, $access, $context )
  {
    
  }//end public function search */

  /**
   * @param int $refId
   * @param LibAclPermission $access
   * @param string $context
   */
  public function searchAll( $refId, $access, $context )
  {
    
  }//end public function searchAll */
  
  /**
   * @param int $refId
   * @param array $ids
   * @param LibAclPermission $access
   * @param string $context
   */
  public function searchByIds( $refId, $ids, $access, $context )
  {
    
  }//end public function searchByIds

} // end class WebfrapExport_Model */

