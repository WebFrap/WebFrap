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
class DaidalosBdlDocu_Page_WbfProfile extends DaidalosBdlDocu_Page
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param int $lang
   */
  public function sync( $lang )
  {
    
    // profil erstellen
    $page = $this->orm->getByKey( 'WbfsysDocuTree', 'wbf-profile' );
    
    if (!$page )
    {
      $page = new WbfsysDocuTree_Entity();
      $page->m_parent = $this->orm->getByKey( 'WbfsysDocuTree', 'wbf' );
    }
    
    $page->access_key = 'wbf-profile';
    $page->title      = 'Profiles';
    $page->template   = 'grid';
    
    $page->short_desc = <<<CODE
The Profiles
CODE;

    $page->content = <<<CODE
The Profiles
CODE;
      
    $this->orm->save( $page );
    
  }//end public function sync */


}//end class DaidalosBdlDocu_Page_Wbf

