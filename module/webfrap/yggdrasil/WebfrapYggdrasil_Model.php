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
class WebfrapYggdrasil_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function getModules(  )
  {
    
    $db = $this->getDb();
    
    $query = <<<SQL
SELECT
  rowid,
  name,
  access_key,
  description
FROM
  wbfsys_module
ORDER BY
  name;
SQL;

    return $db->select($query );
    
  }//end public function getModules */
  
  /**
   * @return void
   */
  public function getEntities($moduleId )
  {
    
    $db = $this->getDb();
    
    $query = <<<SQL
SELECT
  rowid,
  name,
  access_key,
  description
FROM
  wbfsys_entity
WHERE
  id_module = {$moduleId}
ORDER BY
  name;
SQL;

    return $db->select($query );
    
  }//end public function getEntities */


}//end class WebfrapYggdrasil_Model */

