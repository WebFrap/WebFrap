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
abstract class WgtItemAbstract extends WgtAbstract
{

 /**
  * @param mixed $data
  * @return void
  */
  public function setContent( $data )
  {
    
    $this->attributes['value'] = $data;
    
  }// end public function setContent */

 /**
  * @return mixed
  */
  public function getContent(  )
  {
    
    return $this->attributes['value'];
    
  }// end public function getContent */

} // end class WgtItemAbstract

