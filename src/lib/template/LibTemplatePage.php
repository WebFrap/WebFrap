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
 * empty implementation
 * @package WebFrap
 * @subpackage tech_core
 */
class LibTemplatePage extends LibTemplateHtml
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var TDataObject
   */
  public $menus = null;

  /**
   * @var TDataObject
   */
  public $texts = null;

  /**
   * @var TDataObject
   */
  public $areas = null;

  /**
   * what type of view ist this object, html, ajax, document...
   * @var string
   */
  public $type         = 'page';

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the contstructor
   * @param array $conf the configuration loaded from the conf
   */
  public function __construct($view, $conf = array() )
  {

    $this->menus = new TDataObject();
    $this->texts = new TDataObject();
    $this->areas = new TDataObject();

    parent::__construct(  );

  }// end public function __construct */

} // end class LibTemplateDocument

