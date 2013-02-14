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
 * @subpackage ModEnterprise
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapNavigation_Model extends Model
{
  
  
  /**
   * @param string $key
   * @param TArray $params
   */
  public function searchEntriesAutocomplete($key, $params )
  {

    $db     = $this->getDb();
    $query  = $db->newQuery('WebfrapNavigation');

    $query->fetchEntriesByKey
    (
      $key,
      $params
    );

    return $query->getAll();

  }//end public function searchEntriesAutocomplete */


}//end class WebfrapNavigation_Model

