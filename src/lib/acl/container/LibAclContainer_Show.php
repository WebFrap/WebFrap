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
 *  $access = new LibAclPermission(16);
 *
 *  if ($access->access)
 *  {
 *    echo 'Zugriff erlaubt';
 *  }
 *
 *  if ($access->admin)
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
class LibAclContainer_Show extends LibAclContainer_Edit
{

}//end class LibAclContainer_Show

