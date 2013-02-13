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

/** Form Class
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtProcessFormSlice
{
/*//////////////////////////////////////////////////////////////////////////////
// public interface attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * der Prozess
   * @var LibProcessSlice
   */
  public $sliceData = null;

  /**
   * @param LibProcessSlice $sliceData
   */
  public function __construct( $sliceData )
  {
    
    $this->sliceData = $sliceData;
    
  }//end public function __construct */
  
  public function getI18n()
  {
    return Webfrap::$env->getI18n();
  }//end public function getI18n */

}//end class WgtProcessFormSlice


