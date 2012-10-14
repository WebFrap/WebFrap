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
class WgtSelectboxWebfrapInstype
  extends WgtSelectboxHardcoded
{

  /**
   * Enter description here...
   *
   * @var string
   */
  public $firstFree = 'select an installation type';

  /**
   * Enter description here...
   *
   * @var array
   */
  protected $data = array
  (
  'dev_multi'       =>  array( 'value' => 'developer multiuser'   ),
  'prod_multi'      =>  array( 'value' => 'production multiuser'   ),
  );


} // end class WgtSelectboxWebfrapInstype


