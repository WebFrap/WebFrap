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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapPeople_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Search Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * de:
   * Suche für den Autocomplete service
   * Die Anfrage wird über ein WbfsysAnnouncement_Acl_Query Objekt
   * gehandelt, das result als array zurückgegeben
   *
   * @param string $key der Suchstring für den namen der Gruppe
   * @param TFlag $params
   * @return array
   */
  public function getUsersByKey( $key, $params )
  {

    $db     = $this->getDb();
    $query  = $db->newQuery( 'WebfrapPeople' );

    $query->fetchByKey
    (
      $key,
      $params
    );

    return $query->getAll();

  }//end public function getUsersByKey */

  



} // end class WebfrapPeople_Model */

