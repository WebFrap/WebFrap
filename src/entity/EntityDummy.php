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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class EntityDummy extends Entity
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * the name of the sql table for the entity
  * @var string $table
  */
  public $table = 'dummy';

 /**
  * the name of primary key field in the sql table
  * mostly will be WBF_DB_KEY
  * @var string $tablePk
  */
  public $tablePk = WBF_DB_KEY;

 /**
  * the default url to show an entry of this dataset
  * @var string $tablePk
  */
  protected $toUrl = 'index.php?c=Dummy.Dummy.show';

 /**
  * all keynames for fields that will be displayed in the textvalue of the entity
  * @var array $textKeys
  */
  protected $textKeys = array();

 /**
  * the name of the entity in the System
  * @var string $entityName
  */
  protected $entityName = 'Dummy';

/*//////////////////////////////////////////////////////////////////////////////
// Logic (Individual Querys)
//////////////////////////////////////////////////////////////////////////////*/

}//end class EntityDummy

