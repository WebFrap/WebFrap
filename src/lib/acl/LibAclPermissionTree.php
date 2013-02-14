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
 * @lang:de
 *
 * Container zum transportieren von acl informationen.
 *
 * Wird benötigt, da ACLs in der Regel aus mehr als nur einem Zugriffslevel bestehen
 * Weiter ermöglicht der Permission Container einfach zusätzliche Checks
 * mit einzubauen.
 *
 * @example
 * <code>
 *
 *  $access = new LibAclPermission( 16 );
 *
 *  if ($access->access )
 *  {
 *    echo 'Zugriff erlaubt';
 *  }
 *
 *  if ($access->admin )
 *  {
 *    echo 'Wenn du das lesen kannst... Liest du hoffentlich nur das Beispiel hier';
 *  }
 *
 * </code>
 *
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class LibAclPermissionTree extends LibAclPermissionList
{  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Standard lade Funktion für den Access Container
   * Mappt die Aufrufe auf passene Profil loader soweit vorhanden.
   *
   * @param string $profil der namen des Aktiven Profil als CamelCase
   * @param LibSqlQuery $query
   * @param string $context
   * @param TFlag $params
   * @param Entity $entity
   */
  public function fetchChildrenIds($profil, $context, $query, $ids, $conditions, $params = null  )
  {

    
    
    ///TODO Den Pfad auch noch als möglichkeit für die Diversifizierung einbauen

    // sicherheitshalber den String umbauen
    $profil   = SParserString::subToCamelCase($profil );
    $context  = ucfirst( strtolower($context ) );

    if ( method_exists($this, 'fetchChildren_'.$context.'_Profile_'.$profil  ) )
    {
      return $this->{'fetchChildren_'.$context.'_Profile_'.$profil}($query, $ids, $conditions, $params );
    } else {
      return $this->fetchChildrenTreetableDefault($query, $ids, $conditions, $params );
      //return $this->{'fetchChildren'.$context.'Default'}($query, $ids, $conditions, $params );
    }

  }//end public function fetchChildrenIds */


}//end class LibAclPermissionTree

