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
class DaidalosBdlDocu_Page_Wbf
  extends DaidalosBdlDocu_Page
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  public $langData = array
  (
    'de' => array
    (
      'title' => 'Dokumentation',
      'short_desc' => 'Webfrap Dokumentation',
      'content' => 'Webfrap Dokumentation',
    ),
    'en' => array
    (
      'title' => 'Dokumentation',
      'short_desc' => 'Webfrap Dokumentation',
      'content' => 'Webfrap Dokumentation',
    )
  );

  /**
   * @param int $lang
   */
  public function sync( $langKey )
  {
    
    if( !isset( $this->langData[$langKey] ) )
      return;
    
    
    $langNode = $this->orm->getByKey( 'WbfsysLanguage', $langKey );

    // profil erstellen
    $page = $this->orm->get( 'WbfsysDocuTree', "access_key = 'wbf' AND id_lang=".$langNode->getId() );
    
    if( !$page )
    {
      $page = new WbfsysDocuTree_Entity();
    }
    
    $page->access_key = 'wbf';
    $page->title = $this->langData[$langKey]['title'];
    $page->id_lang = $langNode->getId();
    $page->template = 'menu';
    
    $page->short_desc = <<<CODE
{$this->langData[$langKey]['short_desc']}
CODE;
    
    $page->content = <<<CODE
{$this->langData[$langKey]['content']}
CODE;
      
    $this->orm->save( $page );
    
  }//end public function sync */


}//end class DaidalosBdlDocu_Page_Wbf

