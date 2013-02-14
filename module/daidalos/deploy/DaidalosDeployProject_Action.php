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
 * @subpackage ModDaidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class DaidalosDeployProject_Action extends Action
{ 
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/


  
  /**
   * @var DaidalosDeployProject_Model
   */
  public $model = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Trigger Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param DaidalosSystemNode_Entity $entity
   * @param TFlag $params
   * @param BaseChild $env
   */
  public function trigger($entity, $params, $env )
  {
  
     $this->env = $env;
     
     $this->model = $this->loadModel( 'DaidalosDeployProject' );
     
     $deployConf = new DaidalosDeployProject_Conf();
     
     $deployConf->cache->full = true;
     $deployConf->backup->full = true;

     $this->model->deploy($entity, $deployConf, $params, $env );

  }//end public function trigger */


}//end DaidalosDeployProject_Action

