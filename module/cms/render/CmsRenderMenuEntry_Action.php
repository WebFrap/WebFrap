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
class CmsRenderMenuEntry_Action
  extends Action
{
////////////////////////////////////////////////////////////////////////////////
// Trigger Methodes
////////////////////////////////////////////////////////////////////////////////

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
  
    if( !$entity->getId() || !$entity->id_menu )
      return;
  
     $this->env = $env;
     
    $db = $this->getDb();

    $sql = <<<SQL

select
  cms_menu_entry.rowid as rowid,
  cms_menu_entry.label as label,
  cms_menu_entry.title as title,
  cms_menu_entry.m_parent as parent,
  cms_menu_entry.http_url as url,
  cms_menu_entry.target_key as url_key
from
  cms_menu_entry
    join
      cms_menu
    on
      cms_menu.rowid = cms_menu_entry.id_menu
where
  cms_menu.rowid = {$entity->id_menu}

SQL;

    $result = $db->select($sql);


    $menuBuilder = new WgtBuilderTreemenu();
    $menuBuilder->setRawData( $result );
    
    $orm = $db->getOrm();
    $orm->update( 'CmsMenu', $entity->id_menu, $menuBuilder->build()  );

  }//end public function render */
    
}//end CmsRenderMenuEntry_Action

