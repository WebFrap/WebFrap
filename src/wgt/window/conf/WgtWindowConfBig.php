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
 * @subpackage tech_core
 */
class WgtWindowConfBig
  extends TArray
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  public function __construct()
  {
    
    $this->pool['minWidth']   = 600;
    $this->pool['minHeight']  = 400;
    $this->pool['width']      = 950;
    $this->pool['height']     = 650;
    
    $this->pool['resizable']  = false;
    $this->pool['movable']    = false;
    $this->pool['closable']   = true;
    
  }


}// class WgtWindowConfBig

