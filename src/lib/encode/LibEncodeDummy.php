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
class LibEncodeDummy
{

  /**
   * @var LibI18n
   */
  public $i18n = null;
  
  /**
   * @param string $from
   * @param string $to
   */
  public function __construct()
  {

    $this->i18n = Webfrap::$env->getI18n();
    
  }//end public function __construct */
  
  /**
   * @param string $pwd
   */
  public function encode( $string )
  {
    return $string;
  }//end public static function encode */
  
  /**
   * check for hidden redirects in the url
   * @return void
   */
  public function i18n( $key, $repo, $data = array() )
  {
    
    return $this->i18n->l( $key, $repo, $data );

  }//end function function i18n */

} // end class LibEncodeDummy

