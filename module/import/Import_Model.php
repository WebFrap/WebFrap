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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class ModelImport extends Model
{

  /**
   * @param string $name
   * @return EntityWbfsysDataRepository
   */
  public function getRepo($name)
  {

    $orm = $this->getOrm();

    if (!$entityRepo = $orm->get('WbfsysDataRepository', " name = '$name' ")) {
      $entityRepo = $orm->newEntity('WbfsysDataRepository');

      $entityRepo->name = $name;
      $orm->insert($entityRepo);

    }

    return $entityRepo;

  }//end public function getRepo */

}//end class ModelImport

