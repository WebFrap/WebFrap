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
 */
class DaidalosSystem_Model extends Model
{

  /**
   * @param string $key
   * @param TFlag $params
   */
  public function getUsersByKey( $key, $params )
  {

    $db     = $this->getDb();
    $query  = $db->newQuery( 'DaidalosSystem' );

    $query->fetchUsersByKey
    (
      $key,
      $params
    );

    return $query->getAll();

  }//end public function getUsersByKey */


} // end class DaidalosSystem_Model

