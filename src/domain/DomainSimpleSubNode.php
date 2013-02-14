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
 * Simple helper node for subdomain keys
 * like names of elements
 * 
 * @package WebFrap
 * @subpackage Core
 *
 * @author domnik bonsch <dominik.bonsch@webfrap.net>
 */
class DomainSimpleSubNode
{
  
  /**
   * @example project_activity
   * @var string
   */
  public $key = null;
  
  /**
   * @example project/activity
   * @var string
   */
  public $mask = null;
  
  /**
   * @param stringt $key
   */
  public function __construct($key )
  {
    
    $this->key  = $key;
    $this->mask = SFormatStrings::subToCamelCase($key );
    
  }//end public function __construct */


}//end class DomainSimpleSubNode
