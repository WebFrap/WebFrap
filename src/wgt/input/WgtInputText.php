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
 * Objekt zum generieren einer Inputbox
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtInputText extends WgtInput
{

  /**
   *
   * @return unknown_type
   */
  public function build($attributes = array() )
  {

    // ist immer ein text attribute
    $this->attributes['type'] = 'text';

    return parent::build();

  } // end public function build */

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjaxArea()
   */
  public function buildAjaxArea()
  {

    if (!isset($this->attributes['id']))
      return '';

    if (!isset($this->attributes['value']) )
      $this->attributes['value'] = '';

    $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="value" ><![CDATA['
      .($this->attributes['value']).']]></htmlArea>'.NL;

    return $html;

  }//end public function buildAjaxArea */

} // end class WgtInputText


