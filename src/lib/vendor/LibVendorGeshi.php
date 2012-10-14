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

require PATH_VENDOR.'geshi/geshi.php';

/**
 * A Mapperclass to map Geshi in WebFrap
 * @package WebFrap
 * @subpackage tech_core
 */
class LibVendorGeshi
{

  /**
   * @param $string
   * @param $lang
   * @return string
   */
  public function highlightCode( $string , $lang = null  )
  {
    $geshi = new GeSHi( $string, $lang );
    $geshi->set_header_type(GESHI_HEADER_NONE);
    return '<code>' . $geshi->parse_code() . '</code>' ;
  }


} // end class LibVendorGeshi

