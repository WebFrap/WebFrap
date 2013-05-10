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
class LibTemplateHtmlPrint extends LibTemplateHtml
{

  /**
   * @var string
   */
  public $keyCss              = 'print';

  /**
   * @var string
   */
  public $keyTheme            = 'print';

  /**
   * @var string
   */
  public $keyJs               = 'print';

  /**
   * doctype of the page
   * @var string
   */
  protected $doctype          = View::HTML5;



} // end class LibTemplateHtmlPrint

