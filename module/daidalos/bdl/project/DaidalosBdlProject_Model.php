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
class DaidalosBdlProject_Model
  extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var string
   */
  public $key = null;
  
  /**
   * Das aktive Projekt
   * @var BdlProject
   */
  public $project = null;
  
  /**
   * Architecture Nodes
   * @var array
   */
  public $archNodes = array
  (
    'entity',
    'module',
    'management',
    'component',
    'profile',
    'desktop',
    'widget',
    'page',
    'menu',
    'service',
    'message',
    'process',
    'action',
    'item',
    'role',
    'action',
    'event',
  );
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param string $key
   */
  public function setKey( $key )
  {
    $this->key = $key;
  }//end public function setKey */

  /**
   * @return BdlProject
   */
  public function getActiveProject()
  {
    
    if( $this->project )
      return $this->project;
    
    $conf = $this->getConf();
    
    $repoPath = $conf->getResource( 'bdl', 'project_repo' );
    
    $this->project = new BdlProject( $repoPath.'/'.$this->key.'/Project.bdl' );
    
    return $this->project;
    
  }//end public function getActiveProject */
  

}//end class DaidalosBdlProject_Model

