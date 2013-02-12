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
 * @subpackage tech_core
 */
class WgtDyntpl
  extends BaseChild
{

  /**
   * @param LibTemplateView $env
   */
  public function __construct( $env )
  {
    
    $this->env = $env;
    $this->view = $env;
    
  }//end public function __construct */
  
} // end class WgtDyntpl

