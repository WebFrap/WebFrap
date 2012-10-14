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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class Webfrap_Acl_List_Groups
  extends WgtAbstract
{

  /**
   * @return string
   */
  public function build()
  {
    
    if( $this->html )
      return $this->htm;

    $html = '<ul>';
    
    foreach( $this->data as $value )
    {
      
    }
    
    $html = '</ul>';
   
    $this->html = $html;
    
    return $this->html;
    
  }//end public function build 

}// end class Webfrap_Acl_Selectbox_Access */

