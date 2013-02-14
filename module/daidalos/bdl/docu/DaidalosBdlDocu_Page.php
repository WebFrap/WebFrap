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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBdlDocu_Page
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes 
//////////////////////////////////////////////////////////////////////////////*/

  public $orm = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes 
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param LibDbOrm $orm
   */
  public function __construct($orm )
  {
    $this->orm = $orm;
  }//end public function __construct */

  /**
   * 
   */
  public function sync($lang  )
  {

  }//end public function sync */

}//end class DaidalosBdlDocu_Page

