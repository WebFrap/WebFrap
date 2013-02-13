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
 *
 * @package WebFrap
 * @subpackage ModCms
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class CmsRenderArea_Action
  extends Action
{
/*//////////////////////////////////////////////////////////////////////////////
// Trigger Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Entity $entity
   * @param TFlag $params
   * @param BaseChild $env
   *
   * @throws LibActionBreak_Exception bei so schwerwiegenden Fehlern, dass
   *  der komplette Programmfluss abgebrochen werden sollte
   *
   * @throws LibAction_Exception Bei Fehlern die jedoch nicht so schwer sind
   *  um den Fortlauf des Programms zu gefährden
   *  
   */
  public function render( $entity, $params, $env )
  {
  
     $this->env = $env;
     $orm = $env->getOrm();
     
     $entity->parsed_content = $entity->content;

  }//end public function render */
    
}//end CmsRenderArea_Action

