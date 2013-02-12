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
 * @subpackage ModCms
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class CmsRenderPage_Action
  extends Action
{
////////////////////////////////////////////////////////////////////////////////
// Trigger Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Wird im Page Crud Modell vor dem Speichern der Seite aufgerufen
   * @param CmsPage_Entity $entity
   * @param TFlag $params
   * @param BaseChild $env
   */
  public function renderPage( $entity, $params, $env )
  {
  
     $this->env = $env;
     $orm = $env->getOrm();
     
     if( $entity->type == ECmsPageType::SLICED )
     {
       
       $slices = $orm->getListWhere( 'CmsSlice', "id_page=".$entity, array( 'order', array('m_order') ) );
       
       $content = '';

       foreach( $slices as $slice )
       {
         $content .= $slice->parsed_content;
       }
       
       $entity->parsed_content = $content;
       
     }
     else
     {
       $entity->parsed_content = $entity->page_content;
     }
     

  }//end public function renderPage */
    
}//end CmsRenderPage_Action

