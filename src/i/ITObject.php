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
 * Interface für TObjecte wie TArray oder TNode
 * Hauptsächlich vorhanden um mit für Typehinting zu vallidieren
 * dass die Objekte kompatibel zu den Libs sind
 *
 * ArrayAccess und Statische getter und setter
 *
 * @package WebFrap
 * @subpackage tech_core
 */
interface ITObject extends ArrayAccess
{

  /**
   * @param string $key
   * @param string $value
   */
  public function __set($key , $value );

  /**
   * @param string $key
   */
  public function __get($key );

} // end interface ITObject

