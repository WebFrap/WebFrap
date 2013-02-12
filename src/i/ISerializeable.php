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
 * Abstract Class For SysExtention Controllers
 *
 * @package WebFrap
 * @subpackage tech_core
 */
interface ISerializeable
{

  /**
   * return all data to serialize in an array, only arrays an scalares
   * @return  array
   */
  public function serialize();

  /**
   * @param write back the data in de new object vor deserializing
   */
  public function deserialize( $data );

} // end interface ISerializeable
