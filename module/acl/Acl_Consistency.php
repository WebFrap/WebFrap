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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class Acl_Consistency extends DataContainer
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function run()
  {


    $this->fixAccess();

  }//end public function run */

  
  /**
   *
   */
  protected function fixAccess()
  {
    
    $db = $this->getDb();
    
      $queries = array();
      $queries[] = 'UPDATE wbfsys_security_access set message_level = 0 WHERE message_level is null; ';
  
      foreach ($queries as $query) {
        $db->exec($query);
      }
      
  }//end protected function fixAccess */

}//end class WebfrapMessage_Consistency

