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
interface LibSanitizerAdapter
{
  
  /**
   * Methode zum entfernen unerwünschter Tags und Attribute aus HTML
   * 
   * @param string $raw
   * @param string $encoding
   * @param string $configKey
   * 
   * @return string
   */
  public function sanitize($raw, $encoding = 'utf-8', $configKey = 'default' );
  
  
}//end class LibSanitizerAdapter


