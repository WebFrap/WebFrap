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
class DaidalosBdlNode_Model
  extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var DaidalosBdlModeller_Model
   */
  public $modeller = null;
  
  /**
   * @var BdlNode
   */
  public $node = null;
  
  /**
   * @param $modeller DaidalosBdlModeller_Model 
   */
  public function loadBdlNode( $modeller )
  {
    $this->modeller = $modeller;
  }//end public function loadBdlNode */
  
  
  /**
   * @return array
   */
  public function getLanguages(  )
  {
    
    $db = $this->getDb();
    
    $langQuery = $db->newQuery( 'WbfsysLanguageKey_Selectbox' );
    
    $langQuery->fetchSelectbox();
    
    return $langQuery;
    
  }//end public function getLanguages */

}//end class DaidalosBdlNode_Model

