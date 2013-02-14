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
class WebfrapExport_Model extends MvcModel_Domain
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param DomainSimpleSubNode $variant
   * @param Context $context
   * @return LibAclPermission
   */
  public function injectAccessContainer($variant, $context )
  {
    
    $user = $this->getUser();

    $className = $this->domainNode->domainKey.'_'.$variant->mask.'_Access';
    
    // if the requested access container not exists, we can assume this request
    // was invalid
    if (!Webfrap::classLoadable($className ) )
      throw new ServiceNotExists_Exception($this->domainNode->domainKey.'_'.$variant->mask );

    $access = new $className( null, null, $this );
    $access->load($user->getProfileName(), $context );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if (!$access->listing )
    {
      $response = $this->getResponse();
      
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission to export from {@resource@}',
          'wbf.message',
          array
          (
            'resource'  => $response->i18n->l($this->domainNode->label, $this->domainNode->domainI18n.'.label' )
          )
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $context->access = $access;
    
  }//end public function injectAccessContainer */
  
  /**
   * @param LibAclPermission $access
   * @param string $context
   */
  public function search($access, $context )
  {
    
  }//end public function search */

  /**
   * @param LibAclPermission $access
   * @param string $context
   */
  public function searchAll($access, $context )
  {
    
  }//end public function searchAll */
  
  /**
   * @param array $ids
   * @param LibAclPermission $access
   * @param string $context
   */
  public function searchByIds($ids, $access, $context )
  {
    
  }//end public function searchByIds

} // end class WebfrapExport_Model */

