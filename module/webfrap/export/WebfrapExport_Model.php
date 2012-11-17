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
 * @subpackage Acl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapExport_Model
  extends MvcModel_Domain
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $exportName
   * @return LibAclPermission
   */
  public function getAccessContainer( $exportName )
  {
    
    $user = $this->getUser();
    
    if( !$exportName )
      $exportName = 'List';
    else 
      $exportName = SFormatStrings::subToCamelCase($exportName);
    
    $className = $this->domainNode->domainKey.'_Export_'.$exportName.'Access_Container';
    
    // if the requested access container not exists, we can assume this request
    // was invalid
    if( !Webfrap::classLoadable( $className ) )
      throw new R();

    $access = new AclMgmt_Access_Container( null, null, $this, $this->domainNode );
    $access->load( $user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if( !$access->admin )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission for administration in {@resource@}',
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
    $params->access = $access;
    
  }//end public function getAccessContainer */
  
  /**
   * de:
   * prüfen ob eine derartige referenz nicht bereits existiert
   *
   * @param WbfsysSecurityAccess_Entity $entity
   * @return boolean false wenn eine derartige verknüpfung bereits existiert
   */
  public function checkAccess( $domainNode, $params )
  {



  }//end public function checkAccess */
  

} // end class WebfrapExport_Model */

