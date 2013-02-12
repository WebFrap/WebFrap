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
 * Item zum generieren einer Linkliste
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtElementLinklist
  extends WgtAbstract
{


  /**
   * @return string
   */
  public function render( $params = null )
  {
    

    $codeEntr = '';
    
    /**
     * url:
     * label:
     * key:
     * desc:
     */
    foreach( $this->data as $entry )
    {
      $codeEntr .= '<li><a class="wcm wcm_req_ajax" href="'.$entry['url'].'" >'.$entry['label'].'</a></li>';
    }
    
    $id = $this->getId();
    
    $html = <<<HTML
<ul id="{$id}" >
{$codeEntr}
</ul>
HTML;


    return $html;

  } // end public function render */

} // end class WgtElementLinklist


