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
 * @author Dominik Bonsch
 * @copyright Dominik Bonsch <dominik.bonsch@webfrap.net>
 */
class ImportExample_Csv_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public $pool = array();

  /**
   * @var array
   */
  public $stats = array();

/*//////////////////////////////////////////////////////////////////////////////
// Getter & Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function import()
  {

    $orm = $this->getOrm();

    $reader = new LibFilereaderCsv(PATH_GW.'data/import/contract/.csv');

    foreach ($reader as $row) {
      $entity = $orm->newEntity('key');
      $entity->f = $row[1];

      $orm->save($entity);

      $this->pool['key'][$row[0]] = $entity;
    }

  }//end public function import */

} // end class ImportExample_Csv_Model

