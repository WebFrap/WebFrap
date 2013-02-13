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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapDocu_Page_Data
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var WbfsysDocuTree_Entity
   */
  public $page = null;

  /**
   * @var [WbfsysDocuTree_Entity]
   */
  public $slices = array();

  /**
   * @var string
   */
  public $template = null;

  /**
   * @var string
   */
  public $content = null;

  /**
   * @var string
   */
  public $key = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param WbfsysDocuTree_Entity $page
   * @param [WbfsysDocuTree_Entity] $slices
   */
  public function __construct( $page, $slices )
  {

    if( $page->template )
      $this->template = $page->template;
    else
      $this->template = '';

    $this->content = $page->content;
    $this->key     = $page->key;

    $this->page = $page;
    $this->slices = $slices;

  }//end public function __construct */


}//end class WebfrapDocu_Page_Data

